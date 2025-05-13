<?php

namespace App\Repository;

use App\Models\Post;
use App\Models\Ticket;
use App\Models\User;
use App\Repository\Impl\IProfileRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ProfileRepository implements IProfileRepository
{
    public function getUserById(int $id): ?User
    {
        return User::find($id);
    }

    public function getUserWithTickets(int $id): ?User
    {
        return User::with(['tickets.game.homeTeam', 'tickets.game.awayTeam', 'tickets.game.stadium'])
            ->find($id);
    }

    public function updateUserProfile(int $id, array $data): bool
    {
        $user = $this->getUserById($id);

        if (!$user) {
            return false;
        }

        $user->firstname = $data['firstname'];
        $user->lastname = $data['lastname'];
        $user->email = $data['email'];
        $user->phone = $data['phone'] ?? $user->phone;

        if (isset($data['image']) && $data['image']) {
            $imageName = Str::slug($data['firstname']) . '_' . Str::slug($data['lastname']) . '-' . time() . '.' . $data['image']->extension();
            $data['image']->storeAs('public/users', $imageName);
            $user->image = 'storage/users/' . $imageName;
        }

        return $user->save();
    }

    public function updateUserPassword(int $id, string $newPassword): bool
    {
        $user = $this->getUserById($id);

        if (!$user) {
            return false;
        }

        $user->password = Hash::make($newPassword);
        return $user->save();
    }

    public function getUserActivity(int $id): Collection
    {
        $activities = collect();

        $recentTickets = Ticket::where('user_id', $id)
            ->with(['game.homeTeam', 'game.awayTeam'])
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        $recentPosts = Post::where('user_id', $id)
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        foreach ($recentTickets as $ticket) {
            $activities->push([
                'type' => 'ticket',
                'icon' => 'ticket-alt',
                'title' => 'Purchased ticket for ' . $ticket->game->homeTeam->name . ' vs ' . $ticket->game->awayTeam->name,
                'time' => $ticket->created_at,
            ]);
        }

        foreach ($recentPosts as $post) {
            $activities->push([
                'type' => 'post',
                'icon' => 'comment',
                'title' => 'Posted in "' . $post->title . '" forum',
                'time' => $post->created_at,
            ]);
        }

        return $activities->sortByDesc('time')->values();
    }

    public function getUserPostCount(int $id): int
    {
        return Post::where('user_id', $id)->count();
    }

    public function getUserTickets(int $id): Collection
    {
        return Ticket::where('user_id', $id)->get();
    }
}
