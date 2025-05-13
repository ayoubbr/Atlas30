<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Repository\Impl\IGroupRepository;
use App\Repository\Impl\IPostRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroupController extends Controller
{
    private $groupRepository;
    private $postRepository;

    public function __construct(IGroupRepository $groupRepository, IPostRepository $postRepository)
    {
        $this->groupRepository = $groupRepository;
        $this->postRepository = $postRepository;
    }

    public function index()
    {
        $groups = $this->groupRepository->getGroupsWithStats();
        
        $stats = [
            'total_posts' => $this->postRepository->getPostCount(),
            'total_members' => User::count()
        ];

        return view('user.forum.index', compact('groups', 'stats'));
    }

    public function showGroup($id)
    {
        $group = $this->groupRepository->getGroupWithPosts($id);
        $posts = $group->posts;

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

    public function edit($id)
    {
        $group = $this->groupRepository->findById($id);

        if (!$group) {
            return redirect()->back()->with('error', 'Group not found.');
        }

        return view('user.forum.edit-group', compact('group'));
    }

    public function updateGroup(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $result = $this->groupRepository->updateGroup($id, $request->all());

        if (!$result) {
            return redirect()->back()->with('error', 'Failed to update group.');
        }

        return redirect()->route('admin.forum.index')
            ->with('success', 'Group updated successfully.');
    }

    public function destroyGroup($id)
    {
        $result = $this->groupRepository->deleteGroup($id);

        if (!$result) {
            return redirect()->back()->with('error', 'Failed to delete group.');
        }

        return redirect()->route('admin.forum.index')
            ->with('success', 'Group and all associated content deleted successfully.');
    }

    public function getGroup($id)
    {
        $groupData = $this->groupRepository->getGroupWithDetails($id);
        return response()->json($groupData);
    }

    public function getTopGroups()
    {
        $topGroups = $this->groupRepository->getTopGroups();
        return response()->json($topGroups);
    }
}
