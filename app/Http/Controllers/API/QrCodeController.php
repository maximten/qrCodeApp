<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Requests\GenerateQrCodeRequest;
use App\Http\Requests\SetStatusRequest;
use App\Http\Controllers\Controller;
use App\Models\QrCodeType;
use App\Models\QrCode;
use App\Http\Resources\QrCodeResource;
use App\Contracts\QrCodeWriterContract;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class QrCodeController extends Controller
{

    /**
     * Qr code writer
     *
     * @var App\Contracts\QrCodeWriterContract
     */
    protected $qrCodeWriter = null; 

    /**
    * Creates a new controller instance
    *
    * @param App\Contracts\QrCodeWriterContract
    * @return void
    */
    public function __construct(QrCodeWriterContract $qrCodeWriter)
    {
        $this->qrCodeWriter = $qrCodeWriter;
    }

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

        $qrCodeUrl = URL::action('API\QrCodeController@getByHash', $qrCode->hash); 
        $prefix = mb_substr($qrCode->hash, 0, 2);
        $filename = "{$qrCode->hash}.{$this->qrCodeWriter->getExtension()}";
        $path = "$prefix/$filename";

        if (!QrCode::where('hash', $qrCode->hash)->exists()) {
            $qrCode->save();
            $qrCodeContents = $this->qrCodeWriter->generate($qrCodeUrl);
            Storage::disk('public')->put($path, $qrCodeContents);
        }

        return Storage::disk('public')->url($path);
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
