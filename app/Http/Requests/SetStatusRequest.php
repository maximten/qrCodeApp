<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SetStatusRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'status' => 'boolean|required'
        ];
    }
}
