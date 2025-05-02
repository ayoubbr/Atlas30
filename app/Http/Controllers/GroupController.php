<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroupController extends Controller
{
    public function showGroup($id)
    {
        $group = Group::findOrFail($id);

        $posts = Post::where('group_id', $id)
            ->with(['user', 'comments', 'likes'])
            ->withCount(['comments', 'likes'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

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

        $group = new Group();
        $group->name = $validated['name'];
        $group->description = $validated['description'];
        $group->created_by = Auth::id();
        $group->save();

        return redirect()->route('forum.group', $group->id)
            ->with('success', 'Group created successfully!');
    }


    public function storeGroup(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        Group::create([
            'name' => $request->name,
            'description' => $request->description,
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('admin.forum.index')
            ->with('success', 'Group created successfully.');
    }


    public function updateGroup(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $group = Group::findOrFail($id);

        $group->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.forum.index')
            ->with('success', 'Group updated successfully.');
    }


    public function destroyGroup($id)
    {
        $group = Group::findOrFail($id);

        $posts = $group->posts;
        foreach ($posts as $post) {
            $post->comments()->delete();
            $post->likes()->delete();

            $post->delete();
        }

        $group->delete();

        return redirect()->route('admin.forum.index')
            ->with('success', 'Group and all associated content deleted successfully.');
    }


    public function getGroup($id)
    {
        $group = Group::with(['createdBy', 'posts' => function ($query) {
            $query->with('user')->latest()->take(5);
        }])
            ->withCount(['posts'])
            ->findOrFail($id);

        $commentCount = Comment::whereHas('post', function ($query) use ($id) {
            $query->where('group_id', $id);
        })
            ->count();

        $lastActivity = Post::where('group_id', $id)
            ->latest()
            ->first();

        if (!$lastActivity) {
            $lastActivity = $group->created_at;
        } else {
            $lastActivity = $lastActivity->created_at;
        }

        return response()->json([
            'group' => $group,
            'commentCount' => $commentCount,
            'lastActivity' => $lastActivity->diffForHumans(),
        ]);
    }
}
