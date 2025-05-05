<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Repository\Impl\IForumRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ForumController extends Controller
{
    private $forumRepository;

    public function __construct(IForumRepository $forumRepository)
    {
        $this->forumRepository = $forumRepository;
    }

    public function index()
    {
        $stats = $this->forumRepository->getDashboardStats();
        $topGroups = $this->forumRepository->getTopGroups();
        $recentPosts = $this->forumRepository->getRecentPosts();
        $recentComments = $this->forumRepository->getRecentComments();
        $topPosts = $this->forumRepository->getTopPosts();
        $monthlyPosts = $this->forumRepository->getMonthlyActivityData(Post::class);
        $monthlyComments = $this->forumRepository->getMonthlyActivityData(Comment::class);
        $announcements = $this->forumRepository->getAnnouncements();

        return view('admin.forum', compact(
            'stats',
            'topGroups',
            'recentPosts',
            'recentComments',
            'topPosts',
            'monthlyPosts',
            'monthlyComments',
            'announcements'
        ));
    }

    public function destroyPost($id)
    {
        $this->forumRepository->deletePost($id);
        return redirect()->route('admin.forum.index')
            ->with('success', 'Post and all associated content deleted successfully.');
    }

    public function destroyComment($id)
    {
        $this->forumRepository->deleteComment($id);
        return redirect()->route('admin.forum.index')
            ->with('success', 'Comment deleted successfully.');
    }

    public function createAnnouncement(Request $request)
    {
        $request->validate([
            'content' => 'required|string',
            'user_ids' => 'nullable|array',
            'user_ids.*' => 'exists:users,id',
        ]);

        $this->forumRepository->createAnnouncement(
            $request->content,
            $request->has('user_ids') ? $request->user_ids : null
        );

        return redirect()->route('admin.forum.index')
            ->with('success', 'Announcement created and notifications sent successfully.');
    }

    public function destroyAnnouncement($id)
    {
        $this->forumRepository->deleteAnnouncement($id);
        return redirect()->route('admin.forum.index')
            ->with('success', 'Announcement deleted successfully.');
    }

    public function getGroupPosts($groupId)
    {
        $posts = $this->forumRepository->getGroupPosts($groupId);
        return response()->json($posts);
    }

    public function getTopPosts()
    {
        $topPosts = $this->forumRepository->getTopPosts(10);
        return response()->json($topPosts);
    }

    public function getMostActiveUsers()
    {
        $activeUsers = $this->forumRepository->getMostActiveUsers();
        return response()->json($activeUsers);
    }

    public function indexUser()
    {
        $groups = $this->forumRepository->getAllGroups();
        $stats = $this->forumRepository->getForumStats();
        return view('user.forum.index', compact('groups', 'stats'));
    }

    public function showPost($groupId, $postId)
    {
        $data = $this->forumRepository->getPostWithComments($groupId, $postId);
        return view('user.forum.post', compact('post', 'comments', 'userLiked'));
    }

    public function createPost($groupId)
    {
        $group = Group::findOrFail($groupId);
        return view('user.forum.create-post', compact('group'));
    }

    public function storePost(Request $request, $groupId)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required'
        ]);

        $post = $this->forumRepository->createPost($validated, Auth::id(), $groupId);

        return redirect()->route('forum.post', ['groupId' => $groupId, 'postId' => $post->id])
            ->with('success', 'Post created successfully!');
    }

    public function storeComment(Request $request, $groupId, $postId)
    {
        $validated = $request->validate([
            'content' => 'required'
        ]);

        $this->forumRepository->createComment($validated['content'], Auth::id(), $postId);

        return redirect()->route('forum.post', ['groupId' => $groupId, 'postId' => $postId])
            ->with('success', 'Comment added successfully!');
    }

    public function toggleLike($groupId, $postId)
    {
        $userId = Auth::id();
        $this->forumRepository->toggleLike($postId, $userId);
        return redirect()->back();
    }
}
