<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\Stadium;
use App\Models\Ticket;
use App\Repository\Impl\IGameRepository;
use Illuminate\Http\Request;

class GameController extends Controller
{
    private $gameRepository;

    public function __construct(IGameRepository $gameRepository)
    {
        $this->gameRepository = $gameRepository;
    }

    public function home()
    {
        $upcomingMatches = $this->gameRepository->home();
        return view('welcome', compact('upcomingMatches'));
    }

    public function index()
    {
        $games = $this->gameRepository->getAllWithRelations();
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

        $this->gameRepository->store($request->all());

        return redirect()->route('admin.games.index')
            ->with('success', 'Match created successfully.');
    }

    public function update(Request $request, $id)
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

        $this->gameRepository->update($id, $request->all());

        return redirect()->route('admin.games.index')
            ->with('success', 'Match updated successfully.');
    }

    public function destroy($id)
    {
        if ($this->gameRepository->hasTickets($id)) {
            return redirect()->route('admin.games.index')
                ->with('error', 'Cannot delete match with associated tickets.');
        }

        $this->gameRepository->delete($id);

        return redirect()->route('admin.games.index')
            ->with('success', 'Match deleted successfully.');
    }

    public function visitorIndex(Request $request)
    {
        $games = $this->gameRepository->getFilteredGames($request);
        $teams = Team::orderBy('name')->get();
        $stadiums = Stadium::orderBy('name')->get();

        return view('user.games', compact('games', 'teams', 'stadiums'));
    }

    public function visitorShow($id)
    {
        $game = $this->gameRepository->getGameWithRelations($id);
        return view('user.game', compact('game'));
    }

    public function buyTickets(Request $request, $gameId)
    {
        $request->validate([
            'section' => 'required|string',
            'quantity' => 'required|integer|min:1|max:10',
            'price' => 'required|numeric|min:0',
        ]);

        $section = $request->section;
        $quantity = $request->quantity;
        $price = $request->price;

        $userId = auth()->id();
        $tickets = [];

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

        return redirect()->route('tickets.checkout', ['tickets' => implode(',', array_column($tickets, 'id'))])
            ->with('success', 'Tickets reserved successfully. Please complete your payment.');
    }
}
