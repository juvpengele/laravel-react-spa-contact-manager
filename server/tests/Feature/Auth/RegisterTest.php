<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\RegistrationToken;


class RegisterTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function getUserAttributes(array $attributes = []) : array
    {
        return array_merge([
            "name" => $this->faker->name,
            "email" => $this->faker->email,
            "username" => $this->faker->username,
            "password" => $this->faker->password(8)
        ], $attributes);
    }

    /** @test */

    public function a_guest_can_register()
    {
        $formAttributes = $this->getUserAttributes();

        $this->postJson(route("auth.register"), $formAttributes);

        $this->assertDatabaseHas("users", [
            "name" => $formAttributes["name"],
            "email" => $formAttributes["email"],
            "username" => $formAttributes["username"],
        ]);
    }

      /** @test */

    public function when_a_user_is_created_it_responses_with_success()
    {
        $formAttributes = $this->getUserAttributes();

        $response = $this->postJson(route("auth.register"), $formAttributes);

        $jsonResponse = $response->json();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertContains("message", array_keys($jsonResponse));
    }

    /** @test */
    public function when_a_user_is_created_he_receives_an_email()
    {
        $this->withoutExceptionHandling();

        Mail::fake();

        $userAttributes = $this->getUserAttributes();

        $this->postJson(route('auth.register'), $userAttributes);

        Mail::assertSent(RegistrationToken::class);
        Mail::assertSent(RegistrationToken::class, function($mail) use ($userAttributes) {
            return $mail->hasTo($userAttributes["email"]);
        });

    }

    /** @test */
    public function a_user_registration_requires_a_name()
    {
        $userAttributes = $this->getUserAttributes(["name" => null]);

        $response = $this->postJson(route("auth.register"), $userAttributes);
        $responseKeys = $response->json();

        $this->assertEquals(422, $response->getStatusCode());
        $this->assertContains("name", array_keys($responseKeys["errors"]));
    }

     /** @test */
     public function a_user_registration_requires_an_email()
     {
         $userAttributes = $this->getUserAttributes(["email" => null]);

         $response = $this->postJson(route("auth.register"), $userAttributes);
         $responseKeys = $response->json();

         $this->assertEquals(422, $response->getStatusCode());
         $this->assertContains("email", array_keys($responseKeys["errors"]));
     }

     /** @test */
    public function a_user_registration_requires_an_non_existing_email()
    {

        User::factory()->create([
            "email" => "john@example.com"
        ]);

        $userAttributes = $this->getUserAttributes(["email" => "john@example.com"]);

        $response = $this->postJson(route("auth.register"), $userAttributes);
        $responseKeys = $response->json();

        $this->assertEquals(422, $response->getStatusCode());
        $this->assertContains("email", array_keys($responseKeys["errors"]));
    }

    /** @test */
    public function a_user_registration_requires_an_username()
    {
        $userAttributes = $this->getUserAttributes(["username" => null]);

        $response = $this->postJson(route("auth.register"), $userAttributes);
        $jsonResponse = $response->json();

        $this->assertEquals(422, $response->getStatusCode());

        $this->assertContains("username", array_keys($jsonResponse["errors"]));
    }

    /** @test */
    public function a_user_registration_requires_an_non_existing_username()
    {
        User::factory()->create([
            "username" => "john"
        ]);

        $userAttributes = $this->getUserAttributes(["username" => "john"]);

        $response = $this->postJson(route("auth.register"), $userAttributes);
        $jsonResponse = $response->json();

        $this->assertEquals(422, $response->getStatusCode());
        $this->assertContains("username", array_keys($jsonResponse["errors"]));
    }

    /** @test */
    public function a_user_registration_requires_a_password()
    {
        $userAttributes = $this->getUserAttributes(["password" => null]);

        $response = $this->postJson(route("auth.register"), $userAttributes);
        $jsonResponse = $response->json();

        $this->assertEquals(422, $response->getStatusCode());

        $this->assertContains("password", array_keys($jsonResponse["errors"]));
    }

    /** @test */
    public function a_user_registration_requires_a_8_length_password()
    {
        $userAttributes = $this->getUserAttributes(["password" => "hellowo"]);

        $response = $this->postJson(route("auth.register"), $userAttributes);
        $jsonResponse = $response->json();

        $this->assertEquals(422, $response->getStatusCode());

        $this->assertContains("password", array_keys($jsonResponse["errors"]));
    }

    /** @test */
    public function registration_email_contains_registration_token()
    {
        $user = User::factory()->create();

        $registrationMail = new RegistrationToken($user);

        $registrationMail->assertSeeInHtml($user->remember_token);
    }
}
