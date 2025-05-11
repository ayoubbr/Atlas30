<?php

namespace App\Repository\Impl;

use App\Models\Team;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface ITeamRepository
{
    public function getAllTeams(): Collection;
    public function getPaginatedTeams(int $perPage = 8): LengthAwarePaginator;
    public function getTeamById(int $id): ?Team;
    public function createTeam(array $data): Team;
    public function updateTeam(int $id, array $data): bool;
    public function deleteTeam(int $id): bool;
    public function getTeamCount(): int;
    public function searchTeams(string $search = null, string $sort = 'name', string $direction = 'asc'): Collection;
    public function getTeamWithMatches(int $id): ?Team;
    public function getTeamStatistics(int $id): array;
    public function getTeamRecentGames(int $id): Collection;
}
