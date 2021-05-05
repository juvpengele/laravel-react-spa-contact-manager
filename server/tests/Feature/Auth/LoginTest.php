<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_a_user_can_get_his_api_token()
    {
        $user = User::factory()->create([
            "email" => "john@example.com",
            "password" => bcrypt("password")
        ]);

        $response = $this->postJson(route("auth.login"), [
            "email" => "john@example.com",
            "password" => "password"
        ]);

        $response->assertStatus(200)
                ->assertJson(function (AssertableJson $assertableJson) use ($user) {
                    return $assertableJson
                        ->has("api_token")
                        ->has("auth")
                        ->etc();
                })
                ->assertJsonPath("auth.username", $user->username);
    }


    /** @test */
    public function login_requires_an_email()
    {
        $user = User::factory()->create([
            "email" => "john@example.com",
            "password" => bcrypt("password")
        ]);

        $response = $this->postJson(route("auth.login"), [
            "email" => null,
            "password" => "password"
        ]);

        $response->assertStatus(422)
            ->assertJson(function (AssertableJson $assertableJson) use ($user) {
                return $assertableJson
                    ->has("errors.email")
                    ->etc();
            });
    }


    /** @test */
    public function login_requires_a_valid_email()
    {
        $user = User::factory()->create([
            "email" => "john@example.com",
            "password" => bcrypt("password")
        ]);

        $response = $this->postJson(route("auth.login"), [
            "email" => "hello",
            "password" => "password"
        ]);

        $response->assertStatus(422)
            ->assertJson(function (AssertableJson $assertableJson) use ($user) {
                return $assertableJson
                    ->has("errors.email")
                    ->etc();
            });
    }

    /** @test */
    public function login_requires_an_existing_email()
    {
        $user = User::factory()->create([
            "email" => "john@example.com",
            "password" => bcrypt("password")
        ]);

        $response = $this->postJson(route("auth.login"), [
            "email" => "jane@example.com",
            "password" => "password"
        ]);

        $response->assertStatus(422)
            ->assertJson(function (AssertableJson $assertableJson) use ($user) {
                return $assertableJson
                    ->has("errors.email")
                    ->etc();
            });
    }

    /** @test */
    public function login_requires_a_password()
    {
        $user = User::factory()->create([
            "email" => "john@example.com",
            "password" => bcrypt("password")
        ]);

        $response = $this->postJson(route("auth.login"), [
            "email" => "john@example.com",
            "password" => ""
        ]);

        $response->assertStatus(422)
            ->assertJson(function (AssertableJson $assertableJson) {
                return $assertableJson
                    ->has("errors.password")
                    ->etc();
            });
    }

    /** @test */
    public function login_requires_a_valid_password()
    {
        $user = User::factory()->create([
            "email" => "john@example.com",
            "password" => bcrypt("password")
        ]);

        $response = $this->postJson(route("auth.login"), [
            "email" => "john@example.com",
            "password" => "fake-password"
        ]);

        $response->assertStatus(422)
            ->assertJson(function (AssertableJson $assertableJson) use ($user) {
                return $assertableJson
                    ->has("errors.email")
                    ->etc();
            });
    }


    /** @test */
    public function login_requires_email_and_password_attributes()
    {

        $response = $this->postJson(route("auth.login"), []);

        $response->assertStatus(422)
            ->assertJson(function (AssertableJson $assertableJson) {
                return $assertableJson
                    ->has("errors.email")
                    ->has("errors.password")
                    ->etc();
            });
    }


    /** @test */
    public function a_user_with_not_verified_email_can_not_login()
    {
        User::factory()->create([
            "email" => "john@example.com",
            "password" => bcrypt("password"),
            "email_verified_at" => null
        ]);


        $response = $this->postJson(route("auth.login"), [
            "email" => "john@example.com",
            "password" => "password"
        ]);

        $response->assertStatus(422)
            ->assertJson(function (AssertableJson $assertableJson) {
                return $assertableJson
                    ->has("errors.email")
                    ->etc();
            });
    }
}
