<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Team;
use App\Models\Stadium;
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
}