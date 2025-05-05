<?php

namespace App\Repository;

use App\Models\Comment;
use App\Models\Group;
use App\Models\Post;
use App\Repository\Impl\IGroupRepository;
use Illuminate\Database\Eloquent\Collection;

class GroupRepository implements IGroupRepository
{
    public function getAllGroups(): Collection
    {
        return Group::all();
    }

    public function findById(int $id): ?Group
    {
        return Group::find($id);
    }

    public function deleteGroup(int $id): bool
    {
        $group = $this->findById($id);

        if (!$group) {
            return false;
        }

        $posts = $group->posts;
        foreach ($posts as $post) {
            $post->comments()->delete();
            $post->likes()->delete();
            $post->delete();
        }

        return $group->delete();
    }

    public function getGroupWithDetails(int $id): array
    {
        $group = Group::with(['createdBy', 'posts' => function ($query) {
            $query->with('user')->latest()->take(5);
        }])
            ->withCount(['posts'])
            ->findOrFail($id);

        $commentCount = Comment::whereHas('post', function ($query) use ($id) {
            $query->where('group_id', $id);
        })->count();

        $lastActivity = Post::where('group_id', $id)
            ->latest()
            ->first();

        if (!$lastActivity) {
            $lastActivity = $group->created_at;
        } else {
            $lastActivity = $lastActivity->created_at;
        }

        return [
            'group' => $group,
            'commentCount' => $commentCount,
            'lastActivity' => $lastActivity->diffForHumans(),
        ];
    }

    public function getTopGroups(int $limit = 10): Collection
    {
        $groups = Group::withCount('posts')
            ->with(['posts' => function ($query) {
                $query->withCount('comments');
            }])
            ->orderBy('posts_count', 'desc')
            ->take($limit)
            ->get();

        foreach ($groups as $group) {
            $group->comments_count = $group->posts->sum('comments_count');
        }

        return $groups;
    }

    public function getGroupCount(): int
    {
        return Group::count();
    }

    public function getGroupsWithStats(): Collection
    {
        return Group::withCount(['posts', 'latestPosts'])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function updateGroup(int $id, array $data): bool
    {
        $group = $this->findById($id);

        if (!$group) {
            return false;
        }

        return $group->update([
            'name' => $data['name'],
            'description' => $data['description'],
        ]);
    }

    public function createGroup(array $data, int $userId): Group
    {
        $group = new Group();
        $group->name = $data['name'];
        $group->description = $data['description'];
        $group->created_by = $userId;
        $group->save();

        return $group;
    }

    public function getGroupWithPosts(int $id): ?Group
    {
        $group = Group::findOrFail($id);

        $posts = Post::where('group_id', $id)
            ->with(['user', 'comments', 'likes'])
            ->withCount(['comments', 'likes'])
            ->orderBy('is_pinned', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $group->setAttribute('paginatedPosts', $posts);

        return $group;
    }
}
