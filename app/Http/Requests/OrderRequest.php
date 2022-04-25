<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class OrderRequest extends FormRequest
{
    public function rules()
    {
        return [
            'id_user' => 'required',
            'id_product' => 'required',
            'count' => 'required|min:1'
        ];

    }
    public function failedValidation(Validator $validator) {
        throw new HttpResponseException(response()->json([
            'status' => false,
            'message' => 'Invalid data',
            'errors' => $validator->errors()
        ], 422));
    }
}
