<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RegistrationRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            "name" => "required|max:255",
            "email" => "required|unique:users",
            "username" => "required|unique:users",
            "password" => "required|min:8"
        ];
    }

    public function data()
    {
        return $this->merge([
            "password" => Hash::make($this->password),
            "remember_token" => Str::random(5)
        ])
        ->only([ "name", "username", "password", "email", "remember_token" ]);
    }
}
