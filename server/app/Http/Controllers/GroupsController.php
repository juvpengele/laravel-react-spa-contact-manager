<?php

namespace App\Http\Controllers;

use App\Http\Requests\GroupRequest;
use App\Models\Group;
use App\Http\Resources\Group as GroupResource;
use Tests\Utils\SqlDebugger;

class GroupsController extends Controller
{
    public function store(GroupRequest $request)
    {
        $group = Group::create($request->getFormAttributes());
        $group->loadCount("contacts");

        return new GroupResource($group);
    }

    public function update(GroupRequest $request, Group $group)
    {
        $this->applyOwnerGuard($group, "You are not allowed to update this group");

        $group->update($request->getFormAttributes());
        $group->loadCount("contacts");

        return new GroupResource($group);
    }

    public function destroy(Group $group)
    {
        $this->applyOwnerGuard($group, "You are not allowed to destroy this group");

        $group->delete();

        return response()->json([], 204);
    }

    protected function applyOwnerGuard(Group $group, string $errorMessage)
    {
        abort_if(
            auth()->user()->isNot($group->owner), 403, $errorMessage
        );
    }

}
