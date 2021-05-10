<?php

namespace Tests\Feature;

use App\Models\Group;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class GroupManagementTest extends TestCase
{
    use RefreshDatabase, WithFaker, WithAuthFeatures;

    protected User $auth;

    protected function setUp(): void
    {
        parent::setUp();

        $this->auth = User::factory()->create();
    }


    protected function formAttributes(array $attributes = []): array
    {
        $groupAttributes = Group::factory()->raw();
        $groupAttributes["image"] = UploadedFile::fake()->image("image.png");

        return array_merge($groupAttributes, $attributes);
    }

    public function test_a_user_can_create_a_group()
    {
        Storage::fake("public");

        $this->withoutExceptionHandling();

        $response = $this->postJSON(
                route("groups.store"), $formAttributes = $this->formAttributes(),
                $this->authHeaders()
            )->assertStatus(201);


        $response->assertJsonPath("data.name", $formAttributes["name"]);
        $this->assertDatabaseHas("groups", [
            "name" => $formAttributes["name"]
        ]);
    }

    public function test_only_authenticated_users_can_create_a_group()
    {
        $this->postJSON(
            route("groups.store"), $formAttributes = $this->formAttributes()
        )->assertStatus(401);


        $this->assertDatabaseMissing("groups", [
            "title" => $formAttributes["name"]
        ]);
    }

    public function test_we_can_upload_a_file_with_a_group()
    {
        Storage::fake("public");

        $this->postJSON(
            route("groups.store"), $formAttributes = $this->formAttributes(),
            $this->authHeaders()
        );

        $group = Group::first();
        Storage::disk("public")->assertExists($group->image_name);
    }

    public function test_a_group_creation_requires_a_name()
    {
        $formAttributes = $this->formAttributes(["name" => null]);

        $this->postJSON(
            route("groups.store"), $formAttributes,
            $this->authHeaders()
        )
        ->assertStatus(422)
        ->assertJson(function (AssertableJson $assertableJson) {
            return $assertableJson
                ->has("errors.name")
                ->etc();
        });
    }

    public function test_a_group_creation_may_miss_an_image()
    {
        $this->withoutExceptionHandling();

        $formAttributes = $this->formAttributes(["image" => null]);

        $this->postJSON(
            route("groups.store"), $formAttributes,
            $this->authHeaders()
        )->assertStatus(201);
    }
}
