<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegistrationRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\{ Mail, Hash };
use Illuminate\Support\Str;
use App\Mail\RegistrationToken;

class RegisterController extends Controller
{
    use AuthApiData;

    public function store(RegistrationRequest $request)
    {
        $user = User::create($request->data());

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

        $this->validate($request, [
            "token" => [
                "required",
                function($attribute, $value, $fail) use ($user) {
                    if(! $user) {
                        $fail("The provided ". $attribute . " is invalid");
                    }
                }
            ]
        ]);

        $user->update([
            "email_verified_at" => now(),
            "remember_token" => null
        ]);

        return $this->getAuthApiData($user);
    }
}
