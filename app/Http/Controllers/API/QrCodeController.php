<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Requests\GenerateQrCodeRequest;
use App\Http\Controllers\Controller;
use App\Models\QrCodeType;
use App\Models\QrCode;

class QrCodeController extends Controller
{
    /**
     * Generate hash and qr code for given url and user type.
     *
     * @return \Illuminate\Http\Response
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
}
