<?php


namespace Tests\Feature;


trait WithAuthFeatures
{

    protected function getAuthToken() : string
    {
        return $this->auth->createToken("api:auth")->plainTextToken;
    }

    protected function authHeaders() : array
    {
        return [
            "Authorization" => "Bearer " . $this->getAuthToken()
        ];
    }
}
