<?php

namespace App\Repository;

use App\Models\Comment;
use App\Models\Group;
use App\Models\Post;
use App\Repository\Impl\IGroupRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class GroupRepository implements IGroupRepository
{
    public function findById(int $id): ?Group
    {
        return Group::find($id);
    }

    public function getGroupWithPosts(int $id): ?Group
    {
        $group = Group::findOrFail($id);

        $posts = Post::where('group_id', $id)
            ->with(['user', 'comments', 'likes'])
            ->withCount(['comments', 'likes'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $group->setAttribute('paginatedPosts', $posts);

        return $group;
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
}
