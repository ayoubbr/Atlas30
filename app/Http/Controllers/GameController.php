<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Team;
use App\Models\Stadium;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;

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

        // Sorting
        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'date-asc':
                    $query->orderBy('start_date', 'asc')->orderBy('start_hour', 'asc');
                    break;
                case 'date-desc':
                    $query->orderBy('start_date', 'desc')->orderBy('start_hour', 'desc');
                    break;
                case 'status':
                    $query->orderByRaw("FIELD(status, 'live', 'scheduled', 'completed', 'postponed', 'cancelled')")
                        ->orderBy('start_date', 'asc');
                    break;
                default:
                    $query->orderBy('start_date', 'asc')->orderBy('start_hour', 'asc');
            }
        } else {
            // Default sorting by date ascending
            $query->orderBy('start_date', 'asc')->orderBy('start_hour', 'asc');
        }

        // Paginate the results
        $games = $query->paginate(12)->withQueryString();

        // Get all teams and stadiums for filter dropdowns
        $teams = Team::orderBy('name')->get();
        $stadiums = Stadium::orderBy('name')->get();


        return view('user.games', compact('games', 'teams', 'stadiums'));
    }



    public function visitorShow($id)
    {
        $game = Game::with(['homeTeam', 'awayTeam', 'stadium'])->findOrFail($id);

        return view('user.game', compact('game'));
    }


    public function buyTickets(Request $request, $gameId)
    {

        $game = Game::findOrFail($gameId);

        $request->validate([
            'section' => 'required|string',
            'quantity' => 'required|integer|min:1|max:10',
            'price' => 'required|numeric|min:0',
        ]);

        $section = $request->section;
        $quantity = $request->quantity;
        $price = $request->price;

        // $userId = auth()->id();
        $userId = 5;
        $tickets = [];

        // Create tickets for the requested quantity
        for ($i = 0; $i < $quantity; $i++) {
            $placeNumber = rand(1, 100) + ($i * 3); // different seat numbers

            $ticket = new Ticket();
            $ticket->game_id = $gameId;
            $ticket->user_id = $userId;
            $ticket->price = $price;
            $ticket->place_number = $placeNumber;
            $ticket->status = 'pending';
            $ticket->section = $section;
            $ticket->save();

            $tickets[] = $ticket;
        }

        // dd($tickets);

        return redirect()->route('tickets.checkout', ['tickets' => array_column($tickets, 'id')])
            ->with('success', 'Tickets reserved successfully. Please complete your payment.');
    }

    public function teamGames($teamId)
    {
        $team = Team::findOrFail($teamId);

        $games = Game::with(['homeTeam', 'awayTeam', 'stadium'])
            ->where('home_team_id', $teamId)
            ->orWhere('away_team_id', $teamId)
            ->orderBy('start_date', 'asc')
            ->orderBy('start_hour', 'asc')
            ->paginate(12);

        return view('user.team-games', compact('games', 'team'));
    }


    public function upcomingGames($limit = 5)
    {
        $games = Game::with(['homeTeam', 'awayTeam', 'stadium'])
            ->where('status', 'scheduled')
            ->orderBy('start_date', 'asc')
            ->orderBy('start_hour', 'asc')
            ->limit($limit)
            ->get();

        return response()->json($games);
    }


    public function liveGames()
    {
        $games = Game::with(['homeTeam', 'awayTeam', 'stadium'])
            ->where('status', 'live')
            ->get();

        return response()->json($games);
    }


    public function recentResults($limit = 5)
    {
        $games = Game::with(['homeTeam', 'awayTeam', 'stadium'])
            ->where('status', 'completed')
            ->orderBy('start_date', 'desc')
            ->orderBy('start_hour', 'desc')
            ->limit($limit)
            ->get();

        return response()->json($games);
    }
}
