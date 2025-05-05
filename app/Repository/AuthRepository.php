<?php

namespace App\Repository;

use App\Models\User;
use App\Repository\Impl\IAuthRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthRepository implements IAuthRepository
{
    public function createUser(array $data): User
    {
        return User::create([
            'firstname' => $data['firstname'],
            'lastname' => $data['lastname'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'status' => 'active',
            'role_id' => 2, // User role 
        ]);
    }

    public function attemptLogin(array $credentials): bool
    {
        return Auth::attempt($credentials);
    }

    public function logout(Request $request): void
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    }

    public function getCurrentUser(): ?User
    {
        return Auth::user();
    }
}
