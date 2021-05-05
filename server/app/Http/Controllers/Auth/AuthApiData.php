<?php

namespace App\Http\Controllers\Auth;

trait AuthApiData
{

    public function getAuthApiData($user)
    {
        $token = $user->createToken("api:auth")->plainTextToken;

        return response()->json([
            "api_token" => $token,
            "auth" => $user->toArray()
        ], 200);
    }
}
