<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Rules\ValidCredentials;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthApiData;

    public function __invoke(Request $request)
    {
        $request->validate([
            "email" => ["required", "email", new ValidCredentials($request->all())],
            "password" => ["required"]
        ]);

        $user = User::whereEmail($request->email)->first();
        return $this->getAuthApiData($user);
    }



}
