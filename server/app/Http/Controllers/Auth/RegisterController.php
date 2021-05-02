<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\{ Mail, Hash };
use Illuminate\Support\Str;
use App\Mail\RegistrationToken;

class RegisterController extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request, [
            "name" => "required|max:255",
            "email" => "required|unique:users",
            "username" => "required|unique:users",
            "password" => "required|min:8"
        ]);

        $formAttributes = $request->merge([
            "password" => Hash::make($request->password),
            "remember_token" => Str::random(5)
        ])->only([ "name", "username", "password", "email", "remember_token" ]);

        $user = User::create($formAttributes);

        Mail::to($user->email)->send(new RegistrationToken($user));

        return response()->json([
            "message" => "User is created successfully. He receives a email with confirmation token"
        ], 201);
    }

    public function confirm(Request $request)
    {
        $user = User::where("remember_token", "=", $request->token)
                    ->whereNull("email_verified_at")
                    ->first();

        $user->update([
            "email_verified_at" => now(),
            "remember_token" => null
        ]);

        $token = $user->createToken("api:auth")->plainTextToken;

        return response()->json([
            "api_token" => $token,
            "auth"  => $user->toArray()
        ], 200);
    }
}
