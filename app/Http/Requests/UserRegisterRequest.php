<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRegisterRequest extends ValidatorRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "name" => ["required", "max:50"],
            "email" => ["required", "unique:users,email","email:dns"],
            "phonenumber" => [ "numeric", "digits:12", "unique:users,phonenumber"],
            "password" => ["required", "min:8"],
        ];
    }
}
