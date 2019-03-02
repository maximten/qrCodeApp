<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\QrCodeType;

class GenerateQrCodeRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'url' => 'url|required',
            'status' => 'boolean|required',
            'type' => 'string|required|in:' . join(',', [QrCodeType::USER, QrCodeType::MERCHANT]),
        ];
    }
}
