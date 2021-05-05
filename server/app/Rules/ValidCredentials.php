<?php

namespace App\Rules;

use App\Models\User;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class ValidCredentials implements Rule
{

    protected array $requestData = [];

    /**
     * Create a new rule instance.
     *
     * @param array $requestDaa
     */
    public function __construct(array $requestDaa)
    {
        $this->requestData = $requestDaa;
    }


    public function passes($attribute, $value)
    {
        $user = User::where("email", $this->requestData["email"])
            ->whereNotNull("email_verified_at")
            ->first();

        return  $user && Hash::check($this->requestData["password"], $user->password);

    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Your credentials do not match with our records.';
    }
}
