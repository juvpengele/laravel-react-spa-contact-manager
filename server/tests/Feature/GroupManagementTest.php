<?php

namespace Tests\Feature;

use App\Models\Group;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Storage;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;
use Tests\Utils\SqlDebugger;

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

        return array_merge($groupAttributes, $attributes);
    }

    public function test_a_user_can_create_a_group()
    {
        Storage::fake("public");

        $this->withoutExceptionHandling();
        $authHeader = $this->authHeaders();
        $formAttributes = $this->formAttributes();


        $response = $this->postJSON(
                route("groups.store"), $formAttributes,
                $authHeader
            )->assertStatus(201);

        SqlDebugger::stopListening();

        $group = Group::first();
        $response->assertJson([
            "data" => [
                "name" => $group->name,
                "description" => $group->description,
                "user_id" => $this->auth->id,
                "contacts_count" => 0
            ]
        ]);

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


    /** @test */
    public function a_user_can_update_a_group()
    {
        $john = $this->auth;
        $group = Group::factory()->create([
            "user_id" => $john->id
        ]);

        $formAttributes = $this->formAttributes();

        $response = $this->putJson(
            route("groups.update", $group->id), $formAttributes,
            $this->authHeaders()
        )->assertStatus(200);

        $group = $group->fresh();
        $this->assertDatabaseHas("groups", [
            "id" =>  $group->id,
            "name" => $formAttributes["name"]
        ]);

        $response->assertJson([
            "data" => [
                "name" => $group->name,
                "description" => $group->description,
                "user_id" => $john->id,
                "contacts_count" => 0
            ]
        ]);
    }

    /** @test */
    public function a_user_can_only_update_his_groups()
    {
        $group = Group::factory()->create([
            "user_id" => User::factory()->create()->id
        ]);

        $formAttributes = $this->formAttributes();

        $response = $this->putJson(
            route("groups.update", $group->id), $formAttributes,
            $this->authHeaders()
        )->assertStatus(403);

        $group = $group->fresh();
        $this->assertDatabaseMissing("groups", [
            "id" =>  $group->id,
            "name" => $formAttributes["name"]
        ]);


        $response->assertJson([
            "message" => "You are not allowed to update this group",
        ]);

    }

    /** @test */
    public function a_group_update_requires_a_name()
    {

        $group = Group::factory()->create([
            "user_id" => $this->auth->id,
        ]);

        $formAttributes = $this->formAttributes(["name" => null]);

        $this->putJson(
            route("groups.update", $group->id), $formAttributes,
            $this->authHeaders()
        )->assertStatus(422)
            ->assertJson(function (AssertableJson $assertableJson) {
            return $assertableJson
                ->has("errors.name")
                ->etc();
        });
    }

    /** @test */
    public function a_user_can_create_only_one_name_per_group()
    {
        $group = Group::factory()->create([
            "user_id" => $this->auth->id,
        ]);

        $formAttributes = $this->formAttributes(["name" => $group->name]);

        $this->postJson(
            route("groups.store"), $formAttributes,
            $this->authHeaders()
        )->assertStatus(422)
        ->assertJson(function (AssertableJson $assertableJson) {
            return $assertableJson
                ->has("errors.name")
                ->etc();
        });
    }

    /** @test */
    public function a_user_can_not_update_a_group_with_existing_name()
    {
        $groupName = "First group";

        Group::factory()->create([
            "name" => $groupName,
            "user_id" => $this->auth->id,
        ]);

        $group = Group::factory()->create([
            "user_id" => $this->auth->id,
        ]);


        $this->putJson(
            route("groups.update", $group->id), $this->formAttributes(["name" => $groupName]),
            $this->authHeaders()
        )
        ->assertStatus(422)
        ->assertJson(function (AssertableJson $assertableJson) {
            return $assertableJson
                ->has("errors.name")
                ->etc();
        });
    }


    /** @test */
    public function a_user_can_delete_his_group()
    {
        $this->withoutExceptionHandling();

        $group = Group::factory()->create([
            "user_id" => $this->auth->id,
        ]);

        $this->deleteJson(
            route("groups.destroy", $group->id), [],
            $this->authHeaders()
        )->assertStatus(204);
    }

    /** @test */
    public function only_group_owner_can_delete_his_group()
    {
        $group = Group::factory()->create([
            "user_id" => User::factory()->create()->id,
        ]);

        $this->deleteJson(
            route("groups.destroy", $group->id), [],
            $this->authHeaders()
        )->assertStatus(403);
    }

}
