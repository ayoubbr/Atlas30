<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ForumController extends Controller
{
    public function index()
    {
        $totalGroups = Group::count();
        $totalPosts = Post::count();
        $totalComments = Comment::count();
        $totalLikes = Like::count();

        $activeUsers = User::whereHas('posts', function ($query) {
            $query->where('created_at', '>=', Carbon::now()->subDays(30));
        })
            ->orWhereHas('comments', function ($query) {
                $query->where('created_at', '>=', Carbon::now()->subDays(30));
            })
            ->count();

        $topGroups = Group::withCount('posts')
            ->with(['posts' => function ($query) {
                $query->withCount('comments');
            }])
            ->orderBy('posts_count', 'desc')
            ->take(10)
            ->get();

        $recentPosts = Post::with(['user', 'group'])
            ->withCount(['comments', 'likes'])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        foreach ($topGroups as $group) {
            $group->comments_count = $group->posts->sum('comments_count');
        }

        $recentComments = Comment::with(['user', 'post.group'])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        $topPosts = Post::with(['user', 'group'])
            ->withCount(['comments', 'likes'])
            ->orderBy('likes_count', 'desc')
            ->orderBy('comments_count', 'desc')
            ->take(5)
            ->get();

        $monthlyPosts = $this->getMonthlyActivityData(Post::class);
        $monthlyComments = $this->getMonthlyActivityData(Comment::class);

        $announcements = Notification::orderBy('created_at', 'desc')
            ->get()
            ->unique('content')
            ->take(10)
            ->values();

        return view('admin.forum', compact(
            'totalGroups',
            'totalPosts',
            'totalComments',
            'totalLikes',
            'activeUsers',
            'topGroups',
            'recentPosts',
            'recentComments',
            'topPosts',
            'monthlyPosts',
            'monthlyComments',
            'announcements'
        ));
    }


    private function getMonthlyActivityData($model)
    {
        $data = $model::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('COUNT(*) as count')
        )
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->pluck('count', 'month')
            ->toArray();

        // Fill in missing months with zeros
        $result = [];
        for ($i = 1; $i <= 12; $i++) {
            $result[$i] = $data[$i] ?? 0;
        }

        return array_values($result);
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


    public function destroyPost($id)
    {
        $post = Post::findOrFail($id);

        $post->comments()->delete();
        $post->likes()->delete();

        $post->delete();

        return redirect()->route('admin.forum.index')
            ->with('success', 'Post and all associated content deleted successfully.');
    }


    public function destroyComment($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->delete();

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

        // Create notifications for specific users
        if ($request->has('user_ids') && !empty($request->user_ids)) {
            foreach ($request->user_ids as $userId) {
                Notification::create([
                    'content' => $request->content,
                    'status' => 'unread',
                    'user_id' => $userId,
                ]);
            }
        } else {
            // Create notification for all users
            $users = User::all();
            foreach ($users as $user) {
                Notification::create([
                    'content' => $request->content,
                    'status' => 'unread',
                    'user_id' => $user->id,
                ]);
            }
        }

        return redirect()->route('admin.forum.index')
            ->with('success', 'Announcement created and notifications sent successfully.');
    }


    public function destroyAnnouncement($id)
    {
        $announcement = Notification::findOrFail($id);
        $announcement->delete();

        return redirect()->route('admin.forum.index')
            ->with('success', 'Announcement deleted successfully.');
    }


    public function getGroupPosts($groupId)
    {
        $posts = Post::with(['user', 'comments' => function ($query) {
            $query->with('user')->latest();
        }])
            ->withCount(['comments', 'likes'])
            ->where('group_id', $groupId)
            ->latest()
            ->paginate(10);

        return response()->json($posts);
    }


    public function getTopPosts()
    {
        $topPosts = Post::with(['user', 'group'])
            ->withCount(['comments', 'likes'])
            ->orderBy('likes_count', 'desc')
            ->orderBy('comments_count', 'desc')
            ->take(10)
            ->get();

        return response()->json($topPosts);
    }


    public function getMostActiveUsers()
    {
        $activeUsers = User::withCount(['posts', 'comments'])
            ->orderByRaw('posts_count + comments_count DESC')
            ->take(10)
            ->get();

        return response()->json($activeUsers);
    }

    // ////
    public function indexUser()
    {
        $groups = Group::withCount(['posts', 'latestPosts'])
            ->orderBy('created_at', 'desc')
            ->get();

        $stats = [
            'total_posts' => Post::count(),
            'total_members' => User::count()
        ];


        return view('user.forum.index', compact('groups', 'stats'));
    }


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


    public function showPost($groupId, $postId)
    {
        $post = Post::where('id', $postId)
            ->where('group_id', $groupId)
            ->with(['user', 'group'])
            ->firstOrFail();

        $comments = Comment::where('post_id', $postId)
            ->with('user')
            ->orderBy('created_at', 'asc')
            ->paginate(20);

        $userLiked = false;
        if (Auth::check()) {
            $userLiked = Like::where('post_id', $postId)
                ->where('user_id', Auth::id())
                ->exists();
        }

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

        $post = new Post();
        $post->title = $validated['title'];
        $post->content = $validated['content'];
        $post->user_id = Auth::id();
        $post->group_id = $groupId;
        $post->save();

        return redirect()->route('forum.post', ['groupId' => $groupId, 'postId' => $post->id])
            ->with('success', 'Post created successfully!');
    }


    public function storeComment(Request $request, $groupId, $postId)
    {
        $validated = $request->validate([
            'content' => 'required'
        ]);

        $comment = new Comment();
        $comment->content = $validated['content'];
        $comment->user_id = Auth::id();
        $comment->post_id = $postId;
        $comment->save();

        return redirect()->route('forum.post', ['groupId' => $groupId, 'postId' => $postId])
            ->with('success', 'Comment added successfully!');
    }


    public function toggleLike($groupId, $postId)
    {
        $userId = Auth::id();

        $like = Like::where('post_id', $postId)
            ->where('user_id', $userId)
            ->first();

        if ($like) {
            $like->delete();
            $action = 'unliked';
        } else {
            $like = new Like();
            $like->post_id = $postId;
            $like->user_id = $userId;
            $like->save();
            $action = 'liked';
        }

        return redirect()->back();
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
}
