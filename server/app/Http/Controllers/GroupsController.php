<?php

namespace App\Http\Controllers;

use App\Http\Requests\GroupRequest;
use App\Models\Group;
use App\VO\ImageUploader;
use Illuminate\Http\Request;
use App\Http\Resources\Group as GroupResource;

class GroupsController extends Controller
{
    public function store(GroupRequest $request)
    {
        $group = Group::create($request->getFormAttributes());

        return new GroupResource($group);
    }

    public function update(GroupRequest $request, Group $group)
    {
        abort_if($group->user_id != auth()->id(), 403, "You are not allowed to update this group");

        $group->update($request->getFormAttributes());

        return new GroupResource($group);
    }
}
