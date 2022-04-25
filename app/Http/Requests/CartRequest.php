<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CartRequest extends FormRequest
{

    public function rules() {
        return [
            'product_id' => 'required',
            'user_id' => 'required'
        ];
    }
    public function failedValidation(Validator $validator) {
        throw new HttpResponseException(response()->json([
            'status' => false,
            'errors' => $validator->errors()
        ], 422));
    }
}
