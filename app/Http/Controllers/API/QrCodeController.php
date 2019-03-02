<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Requests\GenerateQrCodeRequest;
use App\Http\Requests\SetStatusRequest;
use App\Http\Controllers\Controller;
use App\Models\QrCodeType;
use App\Models\QrCode;
use App\Http\Resources\QrCodeResource;

class QrCodeController extends Controller
{
    /**
     * Generate hash and qr code for given url and user type.
     *
     * @return \App\Http\Requests\GenerateQrCodeRequest
     */
    public function generate(GenerateQrCodeRequest $request)
    {
        $qrCodeType = QrCodeType::getByName($request->type);
        $qrCode = new QrCode();
        $qrCode->url = $request->url;
        $qrCode->status = $request->status;
        $qrCode->type()->associate($qrCodeType);
        $qrCode->generateHash();

        if (!QrCode::where('hash', $qrCode->hash)->exists()) {
            $qrCode->save();
        }

        return $qrCode->hash;
    }

    /**
     * Get QrCode by hash
     *
     * @param string $hash
     * @return array
     */
    public function getByHash(string $hash)
    {
        $qrCode = QrCode::getByHash($hash);
        return new QrCodeResource($qrCode);
    }

    /**
     * Set status to qr code by hash
     *
     * @param SetStatusRequest $request
     * @param string $hash
     * @return void
     */
    public function setStatusByHash(SetStatusRequest $request, string $hash)
    {
        $qrCode = QrCode::getByHash($hash);
        $qrCode->status = $request->status;
        $qrCode->save();
        return new QrCodeResource($qrCode);
    } 
}
