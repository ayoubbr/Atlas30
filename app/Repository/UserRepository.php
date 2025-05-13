<?php

namespace App\Repository;

use App\Models\User;
use App\Repository\Impl\IUserRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserRepository implements IUserRepository
{
    public function getAuthenticatedUser(): ?User
    {
        return Auth::user();
    }

    public function findById(int $id): ?User
    {
        return User::find($id);
    }

    public function updateProfile(User $user, array $data, $image = null): User
    {
        $user->firstname = $data['firstname'];
        $user->lastname = $data['lastname'];
        $user->email = $data['email'];

        if ($image) {
            $imageName = Str::slug($data['firstname']) . '_' . Str::slug($data['lastname']) . '-' . time() . '.' . $image->extension();
            $image->storeAs('public/users', $imageName);
            $user->image = 'storage/users/' . $imageName;
        }

        $user->save();

        return $user;
    }

    public function checkCurrentPassword(User $user, string $currentPassword): bool
    {
        return Hash::check($currentPassword, $user->password);
    }

    public function updatePassword(User $user, string $newPassword): User
    {
        $user->password = Hash::make($newPassword);
        $user->save();

        return $user;
    }

    public function getUsersList(): Collection
    {
        return User::select('id', 'firstname', 'lastname', 'email')
            ->orderBy('firstname')
            ->get();
    }
}
