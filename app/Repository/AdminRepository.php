<?php

namespace App\Repository;

use App\Models\User;
use App\Models\Role;
use App\Repository\Impl\IAdminRepository;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminRepository implements IAdminRepository
{

    public function getPaginatedUsers(int $perPage = 8): LengthAwarePaginator
    {
        return User::with('role')->paginate($perPage);
    }


    public function getAllRoles(): Collection
    {
        return Role::all();
    }


    public function getTotalUsersCount(): int
    {
        return User::count();
    }


    public function getActiveUsersCount(): int
    {
        return User::where('status', 'active')->count();
    }


    public function getNewUsersCount(int $days = 7): int
    {
        return User::where('created_at', '>=', Carbon::now()->subDays($days))->count();
    }


    public function getMonthlyRegistrations(): array
    {
        $monthlyRegistrations = DB::table('users')
            ->select(DB::raw('MONTH(created_at) as month'), DB::raw('COUNT(*) as count'))
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->pluck('count', 'month')
            ->toArray();

        $chartData = [];
        for ($i = 1; $i <= 12; $i++) {
            $chartData[$i] = $monthlyRegistrations[$i] ?? 0;
        }

        return $chartData;
    }


    public function createUser(array $userData): User
    {
        return User::create([
            'firstname' => $userData['firstname'],
            'lastname' => $userData['lastname'],
            'email' => $userData['email'],
            'password' => Hash::make($userData['password']),
            'status' => $userData['status'],
            'role_id' => $userData['role_id']
        ]);
    }


    public function findUserById(int $id, array $relations = []): ?User
    {
        return User::with($relations)->find($id);
    }

    public function findById(int $id): ?User
    {
        return User::find($id);
    }


    public function updateUser(int $id, array $userData): ?User
    {
        $user = $this->findUserById($id);

        if (!$user) {
            return null;
        }

        $user->firstname = $userData['firstname'];
        $user->lastname = $userData['lastname'];
        $user->email = $userData['email'];
        $user->role_id = $userData['role_id'];
        $user->status = $userData['status'];

        if (!empty($userData['password'])) {
            $user->password = Hash::make($userData['password']);
        }

        if (isset($userData['country'])) {
            $user->country = $userData['country'];
        }

        $user->save();

        return $user;
    }


    public function getAuthenticatedUser(): ?User
    {
        return Auth::user();
    }

    public function hasTickets(int $id): bool
    {
        $user = $this->findById($id);

        if (!$user) {
            return false;
        }

        return $user->tickets()->count() > 0;
    }

    public function hasComments(int $id): bool
    {
        $user = $this->findById($id);

        if (!$user) {
            return false;
        }

        return $user->comments()->count() > 0;
    }

    public function deleteUser(int $id): bool
    {
        $user = $this->findById($id);

        if (!$user) {
            return false;
        }

        return $user->delete();
    }

    public function hasLikes(int $id): bool
    {
        $user = $this->findById($id);

        if (!$user) {
            return false;
        }

        return $user->likes()->count() > 0;
    }

    public function hasNotifications(int $id): bool
    {
        $user = $this->findById($id);

        if (!$user) {
            return false;
        }

        return $user->notifications()->count() > 0;
    }
}
