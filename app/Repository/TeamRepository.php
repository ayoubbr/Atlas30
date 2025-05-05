<?php

namespace App\Repository;

use App\Models\Game;
use App\Models\Team;
use App\Repository\Impl\ITeamRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TeamRepository implements ITeamRepository
{
    public function getAllTeams(): Collection
    {
        return Team::all();
    }

    public function getPaginatedTeams(int $perPage = 8): LengthAwarePaginator
    {
        return Team::paginate($perPage);
    }

    public function getTeamById(int $id): ?Team
    {
        return Team::find($id);
    }

    public function createTeam(array $data): Team
    {
        $team = new Team();
        $team->name = $data['name'];
        $team->code = strtoupper($data['code']);

        if (isset($data['flag']) && $data['flag']) {
            $flagName = Str::slug($data['name']) . '-' . time() . '.' . $data['flag']->extension();
            $data['flag']->storeAs('public/flags', $flagName);
            $team->flag = 'storage/flags/' . $flagName;
        }

        $team->save();

        return $team;
    }

    public function updateTeam(int $id, array $data): bool
    {
        $team = $this->getTeamById($id);

        if (!$team) {
            return false;
        }

        $team->name = $data['name'];
        $team->code = strtoupper($data['code']);

        if (isset($data['flag']) && $data['flag']) {
            if ($team->flag && Storage::exists('public/' . str_replace('storage/', '', $team->flag))) {
                Storage::delete('public/' . str_replace('storage/', '', $team->flag));
            }

            $flagName = Str::slug($data['name']) . '-' . time() . '.' . $data['flag']->extension();
            $data['flag']->storeAs('public/flags', $flagName);
            $team->flag = 'storage/flags/' . $flagName;
        }

        return $team->save();
    }

    public function deleteTeam(int $id): bool
    {
        $team = $this->getTeamById($id);

        if (!$team) {
            return false;
        }

        if ($team->homeGames()->count() > 0 || $team->awayGames()->count() > 0) {
            return false;
        }

        if ($team->flag && Storage::exists('public/' . str_replace('storage/', '', $team->flag))) {
            Storage::delete('public/' . str_replace('storage/', '', $team->flag));
        }

        return $team->delete();
    }

    public function getTeamCount(): int
    {
        return Team::count();
    }

    public function searchTeams(string $search = null, string $sort = 'name', string $direction = 'asc', int $perPage = 12): LengthAwarePaginator
    {
        $query = Team::query();

        if ($search) {
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('code', 'like', "%{$search}%");
        }

        $query->orderBy($sort, $direction);

        return $query->paginate($perPage)->withQueryString();
    }

    public function getTeamWithMatches(int $id): ?Team
    {
        return Team::with(['homeGames', 'awayGames'])->find($id);
    }

    public function getTeamStatistics(int $id): array
    {
        $team = $this->getTeamById($id);

        if (!$team) {
            return [];
        }

        $upcomingMatches = Game::where(function ($query) use ($team) {
            $query->where('home_team_id', $team->id)
                ->orWhere('away_team_id', $team->id);
        })
            ->where('start_date', '>=', now()->format('Y-m-d'))
            ->orderBy('start_date', 'asc')
            ->orderBy('start_hour', 'asc')
            ->take(5)
            ->get();

        $recentMatches = Game::where(function ($query) use ($team) {
            $query->where('home_team_id', $team->id)
                ->orWhere('away_team_id', $team->id);
        })
            ->where('start_date', '<', now()->format('Y-m-d'))
            ->orderBy('start_date', 'desc')
            ->orderBy('start_hour', 'desc')
            ->take(5)
            ->get();

        $totalMatches = $team->homeGames()->count() + $team->awayGames()->count();
        $homeMatches = $team->homeGames()->count();
        $awayMatches = $team->awayGames()->count();

        return [
            'upcomingMatches' => $upcomingMatches,
            'recentMatches' => $recentMatches,
            'totalMatches' => $totalMatches,
            'homeMatches' => $homeMatches,
            'awayMatches' => $awayMatches
        ];
    }
}
