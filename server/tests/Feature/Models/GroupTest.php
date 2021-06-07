<?php

namespace Tests\Feature\Models;

use App\Models\Contact;
use App\Models\Group;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GroupTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_a_owner()
    {
        $group = Group::factory()->create();

        $this->assertInstanceOf(User::class, $group->owner);
    }

    /** @test */
    public function it_has_contacts()
    {
        $group = Group::factory()->create();

        Contact::factory()->count(3)->create([
            "group_id" => $group->id
        ]);

        $this->assertCount(3, $group->contacts);
        $this->assertInstanceOf(Contact::class, $group->contacts[0]);
    }
}
