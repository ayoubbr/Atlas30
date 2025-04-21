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

class ForumController extends Controller
{
    public function index()
    {
        $totalGroups = Group::count();
        $totalPosts = Post::count();
        $totalComments = Comment::count();
        $totalLikes = Like::count();

        // Get active users (users who have created posts or comments in the last 30 days)
        $activeUsers = User::whereHas('posts', function ($query) {
            $query->where('created_at', '>=', Carbon::now()->subDays(30));
        })
            ->orWhereHas('comments', function ($query) {
                $query->where('created_at', '>=', Carbon::now()->subDays(30));
            })
            ->count();

        // Get top groups by post count
        $topGroups = Group::withCount('posts')
            ->with(['posts' => function ($query) {
                $query->withCount('comments');
            }])
            ->orderBy('posts_count', 'desc')
            ->take(10)
            ->get();

        // Get recent posts with their groups and users
        $recentPosts = Post::with(['user', 'group'])
            ->withCount(['comments', 'likes'])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        // Calculate comments count for each group
        foreach ($topGroups as $group) {
            $group->comments_count = $group->posts->sum('comments_count');
        }

        // Get recent comments with their posts and users
        $recentComments = Comment::with(['user', 'post.group'])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        // Get top posts by likes and comments
        $topPosts = Post::with(['user', 'group'])
            ->withCount(['comments', 'likes'])
            ->orderBy('likes_count', 'desc')
            ->orderBy('comments_count', 'desc')
            ->take(5)
            ->get();

        // Get monthly activity data for chart
        $monthlyPosts = $this->getMonthlyActivityData(Post::class);
        $monthlyComments = $this->getMonthlyActivityData(Comment::class);

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
            'monthlyComments'
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
}
