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
        $topGroups = Group::withCount(['posts', 'posts as comments_count' => function ($query) {
            $query->withCount('comments')->get();
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


   
}
