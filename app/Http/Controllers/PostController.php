<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Repository\Impl\IPostRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    private $postRepository;

    public function __construct(IPostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function index()
    {
        $posts = $this->postRepository->getAllPosts();
        return view('admin.posts.index', compact('posts'));
    }

    public function show($groupId, $postId)
    {
        $data = $this->postRepository->getPostWithComments($groupId, $postId);
        $post = $data['post'];
        $comments = $data['comments'];
        $userLiked = $data['userLiked'];

        return view('user.forum.post', compact('post', 'comments', 'userLiked'));
    }

    public function create($groupId)
    {
        $group = Group::findOrFail($groupId);
        return view('user.forum.create-post', compact('group'));
    }

    public function store(Request $request, $groupId)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'is_pinned' => 'sometimes|boolean'
        ]);

        $post = $this->postRepository->createPost($validated, Auth::id(), $groupId);

        return redirect()->route('forum.post', ['groupId' => $groupId, 'postId' => $post->id])
            ->with('success', 'Post created successfully!');
    }

    public function edit($groupId, $postId)
    {
        $post = $this->postRepository->getPostById($postId);
        $group = Group::findOrFail($groupId);

        if (!$post || $post->group_id != $groupId) {
            return redirect()->back()->with('error', 'Post not found.');
        }

        return view('user.forum.edit-post', compact('post', 'group'));
    }

    public function update(Request $request, $groupId, $postId)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'is_pinned' => 'sometimes|boolean'
        ]);

        $result = $this->postRepository->updatePost($postId, $validated);

        if (!$result) {
            return redirect()->back()->with('error', 'Failed to update post.');
        }

        return redirect()->route('forum.post', ['groupId' => $groupId, 'postId' => $postId])
            ->with('success', 'Post updated successfully!');
    }

    public function destroy($id)
    {
        $result = $this->postRepository->deletePost($id);

        if (!$result) {
            return redirect()->back()->with('error', 'Failed to delete post.');
        }

        return redirect()->route('admin.forum.index')
            ->with('success', 'Post and all associated content deleted successfully.');
    }

    public function getTopPosts()
    {
        $topPosts = $this->postRepository->getTopPosts(10);
        return response()->json($topPosts);
    }

    public function getRecentPosts()
    {
        $recentPosts = $this->postRepository->getRecentPosts();
        return response()->json($recentPosts);
    }

    public function getMonthlyPostData()
    {
        $monthlyData = $this->postRepository->getMonthlyPostData();
        return response()->json($monthlyData);
    }
}
