<?php

namespace App\Http\Controllers\Group;

use App\Http\Controllers\Controller;
use App\Http\Requests\Group\GroupRequest;
use App\Http\Requests\Shared\GetRequest;
use App\Models\Group;
use App\Services\Group\GroupService;

class GroupController extends Controller
{
    protected GroupService $service;

    public function __construct()
    {
        $this->service = new GroupService();
    }

    public function index(GetRequest $request)
    {
        return $this->service->get(
            $request->input('include'),
            $request->input('filter'),
            $request->input('sort'),
            $request->input('perPage'),
        );
    }

    public function get(Group $group, GetRequest $request)
    {
        // Verify ownership
        if ($group->user_id !== $request->user()->id) {
            return response()->json(['message' => 'No tens accés a aquest grup.'], 403);
        }

        $filter = array_merge($request->input('filter'), ['id' => $group->id]);

        return $this->service->get(
            $request->input('include'),
            $filter,
            $request->input('sort'),
        );
    }

    public function save(Group $group, GroupRequest $request)
    {
        return $this->service->save($group, $request);
    }

    public function duplicate(Group $group, GroupRequest $request)
    {
        if ($group->user_id !== $request->user()->id) {
            return response()->json(['message' => 'No tens accés a aquest grup.'], 403);
        }

        return $this->service->duplicate($group, $request);
    }

    public function delete(Group $group)
    {
        $this->service->delete($group);

        return response()->json(['message' => 'Grup eliminat correctament.']);
    }
}
