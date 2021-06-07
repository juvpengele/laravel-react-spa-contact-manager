<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;


class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_has_an_avatar()
    {
        $user = User::factory()->create();

        $this->assertEquals(url("/images/avatars/{$user->profile_picture}"), $user->avatar);
    }
}
