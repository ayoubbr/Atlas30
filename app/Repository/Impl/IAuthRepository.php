<?php

namespace App\Repository\Impl;

use App\Models\User;
use Illuminate\Http\Request;

interface IAuthRepository
{
    public function createUser(array $data): User;
    public function attemptLogin(array $credentials): bool;
    public function logout(Request $request): void;
    public function getCurrentUser(): ?User;
}