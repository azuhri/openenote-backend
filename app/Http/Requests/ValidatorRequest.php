<?php

namespace App\Http\Requests;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

use Illuminate\Foundation\Http\FormRequest;

class ValidatorRequest extends FormRequest
{
    public function withValidator(Validator $validator)
    {
        if ($validator->fails()) {
            throw new HttpResponseException(response()->json(
                [
                    'errors' => $validator->errors()->first(),
                ],
            400));
        }
    }
}