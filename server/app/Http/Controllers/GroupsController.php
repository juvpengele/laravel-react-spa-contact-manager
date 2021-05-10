<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\VO\ImageUploader;
use Illuminate\Http\Request;
use App\Http\Resources\Group as GroupResource;

class GroupsController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            "name" => "required"
        ]);

        if($request->image) {
            $imageName = ImageUploader::generateName();
        }


        $formAttributes = $request->merge(["image_name" => $imageName ?? null, "user_id" => auth()->id()])
                                  ->only(["name", "description", "image_name", "user_id"]);

        $group = Group::create($formAttributes);

        if($group->image_name) {
            $group->image()->save($request->file("image"), $imageName);
        }


        return new GroupResource($group);
    }
}
