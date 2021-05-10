<?php

namespace Tests\Unit;

use App\Models\Group;
use Illuminate\Support\Facades\Storage;


class GroupTest extends \Tests\TestCase
{

    public function test_a_group_has_his_url_path()
    {
       $group = new Group([
           "image_name" => "image.png"
       ]);

       $this->assertEquals(
           Storage::disk("public")->url($group->image_name),
           $group->image()->url
       );
    }
}
