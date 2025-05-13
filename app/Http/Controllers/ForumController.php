<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\User;
use App\Repository\Impl\ICommentRepository;
use App\Repository\Impl\IGroupRepository;
use App\Repository\Impl\ILikeRepository;
use App\Repository\Impl\IPostRepository;
use App\Repository\Impl\INotificationRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ForumController extends Controller
{
    private $groupRepository;
    private $postRepository;
    private $commentRepository;
    private $likeRepository;
    private $notificationRepository;

    public function __construct(
        IGroupRepository $groupRepository,
        IPostRepository $postRepository,
        ICommentRepository $commentRepository,
        ILikeRepository $likeRepository,
        INotificationRepository $notificationRepository
    ) {
        $this->groupRepository = $groupRepository;
        $this->postRepository = $postRepository;
        $this->commentRepository = $commentRepository;
        $this->likeRepository = $likeRepository;
        $this->notificationRepository = $notificationRepository;
    }

    public function index()
    {
        $stats = [
            'totalGroups' => $this->groupRepository->getGroupCount(),
            'totalPosts' => $this->postRepository->getPostCount(),
            'totalComments' => $this->commentRepository->getCommentCount(),
            'totalLikes' => $this->likeRepository->getTotalLikes(),
            'activeUsers' => $this->getActiveUsers()
        ];

        $topGroups = $this->groupRepository->getTopGroups();
        $recentPosts = $this->postRepository->getRecentPosts();
        $recentComments = $this->commentRepository->getRecentComments();
        $topPosts = $this->postRepository->getTopPosts();
        $announcements = $this->getAnnouncements();

        return view('admin.forum', compact(
            'stats',
            'topGroups',
            'recentPosts',
            'recentComments',
            'topPosts',
            'announcements'
        ));
    }

    private function getActiveUsers()
    {
        return User::whereHas('posts', function ($query) {
            $query->where('created_at', '>=', Carbon::now()->subDays(30));
        })
            ->orWhereHas('comments', function ($query) {
                $query->where('created_at', '>=', Carbon::now()->subDays(30));
            })->count();
    }

    private function getAnnouncements()
    {
        return Notification::orderBy('created_at', 'desc')
            ->get();
    }

    public function createAnnouncement(Request $request)
    {
        $request->validate([
            'content' => 'required|string',
            'user_ids' => 'nullable|array',
            'user_ids.*' => 'exists:users,id',
        ]);

        $content = $request['content'];
        $userIds = $request->has('user_ids') ? $request['user_ids'] : null;

        if ($userIds && !empty($userIds)) {
            foreach ($userIds as $userId) {
                Notification::create([
                    'content' => $content,
                    'status' => 'unread',
                    'user_id' => $userId,
                ]);
            }
        } else {
            $users = User::all();
            foreach ($users as $user) {
                Notification::create([
                    'content' => $content,
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

    public function getMostActiveUsers()
    {
        $activeUsers = User::withCount(['posts', 'comments'])
            ->orderByRaw('posts_count + comments_count DESC')
            ->take(10)
            ->get();

        return response()->json($activeUsers);
    }
}
