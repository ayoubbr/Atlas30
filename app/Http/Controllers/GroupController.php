<?php

namespace App\Http\Controllers;

use App\Repository\Impl\IGroupRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroupController extends Controller
{
    private $groupRepository;

    public function __construct(IGroupRepository $groupRepository)
    {
        $this->groupRepository = $groupRepository;
    }

    public function showGroup($id)
    {
        $group = $this->groupRepository->getGroupWithPosts($id);
        $posts = $group->paginatedPosts;

        return view('user.forum.group', compact('group', 'posts'));
    }

    public function createGroup()
    {
        return view('user.forum.create-group');
    }

    public function storeGroupUser(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255|unique:groups',
            'description' => 'required'
        ]);

        $group = $this->groupRepository->createGroup($validated, Auth::id());

        return redirect()->route('forum.group', $group->id)
            ->with('success', 'Group created successfully!');
    }

    public function storeGroup(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $this->groupRepository->createGroup($request->all(), auth()->id());

        return redirect()->route('admin.forum.index')
            ->with('success', 'Group created successfully.');
    }

    public function updateGroup(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $this->groupRepository->updateGroup($id, $request->all());

        return redirect()->route('admin.forum.index')
            ->with('success', 'Group updated successfully.');
    }

    public function destroyGroup($id)
    {
        $this->groupRepository->deleteGroup($id);

        return redirect()->route('admin.forum.index')
            ->with('success', 'Group and all associated content deleted successfully.');
    }

    public function getGroup($id)
    {
        $groupData = $this->groupRepository->getGroupWithDetails($id);
        return response()->json($groupData);
    }
}
