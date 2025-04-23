<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Team;
use App\Models\Stadium;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class GameController extends Controller
{

    public function index()
    {
        $games = Game::with(['homeTeam', 'awayTeam', 'stadium'])->get();
        $teams = Team::all();
        $stadiums = Stadium::all();

        return view('admin.games', compact('games', 'teams', 'stadiums'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'start_hour' => 'required|string',
            'home_team_id' => 'required|exists:teams,id',
            'away_team_id' => 'required|exists:teams,id|different:home_team_id',
            'stadium_id' => 'required|exists:stadiums,id',
            'status' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
        ]);

        $game = new Game();
        $game->start_date = $request->start_date;
        $game->start_hour = $request->start_hour;
        $game->home_team_id = $request->home_team_id;
        $game->away_team_id = $request->away_team_id;
        $game->stadium_id = $request->stadium_id;
        $game->home_team_goals = $request->home_team_goals ?? 0;
        $game->away_team_goals = $request->away_team_goals ?? 0;
        $game->status = $request->status;

        if ($request->hasFile('image')) {
            $imageName = 'game-' . time() . '.' . $request->image->extension();
            $request->image->storeAs('public/games', $imageName);
            $game->image = 'storage/games/' . $imageName;
        }

        $game->save();

        return redirect()->route('admin.games.index')
            ->with('success', 'Match created successfully.');
    }


    public function update(Request $request, $id)
    {
        $game = Game::findOrFail($id);

        $request->validate([
            'start_date' => 'required|date',
            'start_hour' => 'required|string',
            'home_team_id' => 'required|exists:teams,id',
            'away_team_id' => 'required|exists:teams,id|different:home_team_id',
            'stadium_id' => 'required|exists:stadiums,id',
            'status' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
        ]);

        $game->start_date = $request->start_date;
        $game->start_hour = $request->start_hour;
        $game->home_team_id = $request->home_team_id;
        $game->away_team_id = $request->away_team_id;
        $game->stadium_id = $request->stadium_id;
        $game->home_team_goals = $request->home_team_goals ?? 0;
        $game->away_team_goals = $request->away_team_goals ?? 0;
        $game->status = $request->status;

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($game->image && Storage::exists('public/' . str_replace('storage/', '', $game->image))) {
                Storage::delete('public/' . str_replace('storage/', '', $game->image));
            }

            $imageName = 'game-' . time() . '.' . $request->image->extension();
            $request->image->storeAs('public/games', $imageName);
            $game->image = 'storage/games/' . $imageName;
        }

        $game->save();

        return redirect()->route('admin.games.index')
            ->with('success', 'Match updated successfully.');
    }


    public function updateScore(Request $request, $id)
    {
        $game = Game::findOrFail($id);

        $request->validate([
            'home_team_goals' => 'required|integer|min:0',
            'away_team_goals' => 'required|integer|min:0',
        ]);

        $game->home_team_goals = $request->home_team_goals;
        $game->away_team_goals = $request->away_team_goals;
        $game->save();

        return redirect()->route('admin.games.index')
            ->with('success', 'Match score updated successfully.');
    }


    public function destroy($id)
    {
        $game = Game::findOrFail($id);

        if ($game->tickets()->count() > 0) {
            return redirect()->route('admin.games.index')
                ->with('error', 'Cannot delete match with associated tickets.');
        }

        if ($game->image && Storage::exists('public/' . str_replace('storage/', '', $game->image))) {
            Storage::delete('public/' . str_replace('storage/', '', $game->image));
        }

        $game->delete();

        return redirect()->route('admin.games.index')
            ->with('success', 'Match deleted successfully.');
    }

    // public function userGames()
    // {
    //     $games = Game::with(['homeTeam', 'awayTeam', 'stadium'])
    //         ->where('status', 'scheduled')
    //         ->orderBy('start_date')
    //         ->get();

    //     return view('user.games', compact('games'));
    // }

    /**
     * Visitor methods
     */
    public function visitorIndex(Request $request)
    {
        $query = Game::with(['homeTeam', 'awayTeam', 'stadium']);

        // Filter by date range
        if ($request->has('date_range') && $request->date_range) {
            $today = Carbon::today();

            switch ($request->date_range) {
                case 'today':
                    $query->whereDate('start_date', $today->format('Y-m-d'));
                    break;
                case 'tomorrow':
                    $query->whereDate('start_date', $today->addDay()->format('Y-m-d'));
                    break;
                case 'this-week':
                    $query->whereDate('start_date', '>=', $today->startOfWeek()->format('Y-m-d'))
                        ->whereDate('start_date', '<=', $today->endOfWeek()->format('Y-m-d'));
                    break;
                case 'next-week':
                    $nextWeekStart = $today->addWeek()->startOfWeek();
                    $nextWeekEnd = $nextWeekStart->copy()->endOfWeek();
                    $query->whereDate('start_date', '>=', $nextWeekStart->format('Y-m-d'))
                        ->whereDate('start_date', '<=', $nextWeekEnd->format('Y-m-d'));
                    break;
                case 'this-month':
                    $query->whereDate('start_date', '>=', $today->startOfMonth()->format('Y-m-d'))
                        ->whereDate('start_date', '<=', $today->endOfMonth()->format('Y-m-d'));
                    break;
            }
        }

        // Filter by team
        if ($request->has('team_id') && $request->team_id) {
            $teamId = $request->team_id;
            $query->where(function ($q) use ($teamId) {
                $q->where('home_team_id', $teamId)
                    ->orWhere('away_team_id', $teamId);
            });
        }

        // Filter by stadium
        if ($request->has('stadium_id') && $request->stadium_id) {
            $query->where('stadium_id', $request->stadium_id);
        }

        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Search functionality
        if ($request->has('search') && $request->search) {
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

        $games = $query->paginate(12);
        $teams = Team::all();
        $stadiums = Stadium::all();

        return view('user.games', compact('games', 'teams', 'stadiums'));
    }


    public function visitorShow($id)
    {
        $game = Game::with(['homeTeam', 'awayTeam', 'stadium'])->findOrFail($id);

        return view('user.game', compact('game'));
    }


    public function teamGames($teamId)
    {
        $games = Game::with(['homeTeam', 'awayTeam', 'stadium'])
            ->where('home_team_id', $teamId)
            ->orWhere('away_team_id', $teamId)
            ->orderBy('start_date', 'asc')
            ->orderBy('start_hour', 'asc')
            ->get();

        $team = Team::findOrFail($teamId);

        return view('user.team-games', compact('games', 'team'));
    }

    public function gameTickets($gameId)
    {
        return view('user.tickets');
    }
}
