<?php

namespace App\Repository;

use App\Models\Game;
use App\Repository\Impl\IGameRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class GameRepository implements IGameRepository
{
    public function home()
    {
        return Game::with(['homeTeam', 'awayTeam', 'stadium'])
            ->where('start_date', '>=', Carbon::now()->toDateString())
            ->orderBy('start_date')
            ->take(3)
            ->get();
    }

    public function getAllWithRelations()
    {
        return Game::with(['homeTeam', 'awayTeam', 'stadium'])->get();
    }

    public function findById($id)
    {
        return Game::findOrFail($id);
    }

    public function store(array $data)
    {
        $game = new Game();
        $game->start_date = $data['start_date'];
        $game->start_hour = $data['start_hour'];
        $game->home_team_id = $data['home_team_id'];
        $game->away_team_id = $data['away_team_id'];
        $game->stadium_id = $data['stadium_id'];
        $game->home_team_goals = $data['home_team_goals'] ?? 0;
        $game->away_team_goals = $data['away_team_goals'] ?? 0;
        $game->status = $data['status'];

        if (isset($data['image'])) {
            $imageName = 'game-' . time() . '.' . $data['image']->extension();
            $data['image']->storeAs('public/games', $imageName);
            $game->image = 'storage/games/' . $imageName;
        }

        $game->save();
        return $game;
    }

    public function update($id, array $data)
    {
        $game = $this->findById($id);

        $game->start_date = $data['start_date'];
        $game->start_hour = $data['start_hour'];
        $game->home_team_id = $data['home_team_id'];
        $game->away_team_id = $data['away_team_id'];
        $game->stadium_id = $data['stadium_id'];
        $game->home_team_goals = $data['home_team_goals'] ?? 0;
        $game->away_team_goals = $data['away_team_goals'] ?? 0;
        $game->status = $data['status'];

        if (isset($data['image'])) {
            if ($game->image && Storage::exists('public/' . str_replace('storage/', '', $game->image))) {
                Storage::delete('public/' . str_replace('storage/', '', $game->image));
            }

            $imageName = 'game-' . time() . '.' . $data['image']->extension();
            $data['image']->storeAs('public/games', $imageName);
            $game->image = 'storage/games/' . $imageName;
        }

        $game->save();
        return $game;
    }

    public function delete($id)
    {
        $game = $this->findById($id);

        if ($game->image && Storage::exists('public/' . str_replace('storage/', '', $game->image))) {
            Storage::delete('public/' . str_replace('storage/', '', $game->image));
        }

        return $game->delete();
    }

    public function hasTickets($id)
    {
        $game = $this->findById($id);
        return $game->tickets()->count() > 0;
    }

    public function getFilteredGames(Request $request)
    {
        $query = Game::with(['homeTeam', 'awayTeam', 'stadium']);

        if ($request->date_range) {
            $today = Carbon::today();

            switch ($request->date_range) {
                case 'today':
                    $query->whereDate('start_date', $today->format('Y-m-d'));
                    break;
                case 'tomorrow':
                    $query->whereDate('start_date', $today->addDay()->format('Y-m-d'));
                    break;
                case 'this-week':
                    $query->whereBetween('start_date', [
                        $today->startOfWeek()->format('Y-m-d'),
                        $today->endOfWeek()->format('Y-m-d')
                    ]);
                    break;
                case 'next-week':
                    $nextWeekStart = Carbon::today()->addWeek()->startOfWeek();
                    $nextWeekEnd = Carbon::today()->addWeek()->endOfWeek();
                    $query->whereBetween('start_date', [
                        $nextWeekStart->format('Y-m-d'),
                        $nextWeekEnd->format('Y-m-d')
                    ]);
                    break;
                case 'this-month':
                    $query->whereBetween('start_date', [
                        $today->startOfMonth()->format('Y-m-d'),
                        $today->endOfMonth()->format('Y-m-d')
                    ]);
                    break;
            }
        }

        if ($request->team_id) {
            $teamId = $request->team_id;
            $query->where(function ($q) use ($teamId) {
                $q->where('home_team_id', $teamId)
                    ->orWhere('away_team_id', $teamId);
            });
        }

        if ($request->stadium_id) {
            $query->where('stadium_id', $request->stadium_id);
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('homeTeam', function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%');
                })
                    ->orWhereHas('awayTeam', function ($q) use ($search) {
                        $q->where('name', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('stadium', function ($q) use ($search) {
                        $q->where('name', 'like', '%' . $search . '%')
                            ->orWhere('city', 'like', '%' . $search . '%');
                    });
            });
        }

        return $query->get();
    }

    public function getGameWithRelations($id)
    {
        return Game::with(['homeTeam', 'awayTeam', 'stadium'])->findOrFail($id);
    }

    public function getTeamGames($teamId)
    {
        return Game::with(['homeTeam', 'awayTeam', 'stadium'])
            ->where('home_team_id', $teamId)
            ->orWhere('away_team_id', $teamId)
            ->orderBy('start_date', 'asc')
            ->orderBy('start_hour', 'asc')
            ->paginate(12);
    }

    public function getUpcomingGames($limit = 5)
    {
        return Game::with(['homeTeam', 'awayTeam', 'stadium'])
            ->where('status', 'upcoming')
            ->orderBy('start_date', 'asc')
            ->orderBy('start_hour', 'asc')
            ->limit($limit)
            ->get();
    }

    public function getLiveGames()
    {
        return Game::with(['homeTeam', 'awayTeam', 'stadium'])
            ->where('status', 'live')
            ->get();
    }

    public function getRecentResults($limit = 5)
    {
        return Game::with(['homeTeam', 'awayTeam', 'stadium'])
            ->where('status', 'completed')
            ->orderBy('start_date', 'desc')
            ->orderBy('start_hour', 'desc')
            ->limit($limit)
            ->get();
    }
}
