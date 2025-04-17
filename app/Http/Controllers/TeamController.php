<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\VarDumper\VarDumper;

class TeamController extends Controller
{

    public function index()
    {
        $teams = Team::paginate(8);
        return view('admin.teams', compact('teams'));
    }


    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:255|unique:teams',
            'code' => 'required|string|max:3|unique:teams',
            'flag' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $team = new Team();
        $team->name = $request->name;
        $team->code = strtoupper($request->code);

        if ($request->hasFile('flag')) {
            $flagName = Str::slug($request->name) . '-' . time() . '.' . $request->flag->extension();
            $request->flag->storeAs('public/flags', $flagName);
            $team->flag = 'storage/flags/' . $flagName;
        }

        $team->save();

        return redirect()->route('admin.teams.index')
            ->with('success', 'Team created successfully.');
    }


    public function update(Request $request,  $teamId)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:3',
            'flag' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $team = Team::find($teamId);
        $team->name = $request->name;
        $team->code = strtoupper($request->code);

        if ($request->hasFile('flag')) {
            if ($team->flag && Storage::exists('public/' . str_replace('storage/', '', $team->flag))) {
                Storage::delete('public/' . str_replace('storage/', '', $team->flag));
            }

            $flagName = Str::slug($request->name) . '-' . time() . '.' . $request->flag->extension();
            $request->flag->storeAs('public/flags', $flagName);
            $team->flag = 'storage/flags/' . $flagName;
        }

        $team->save();

        return redirect()->route('admin.teams.index')
            ->with('success', 'Team updated successfully.');
    }


    public function destroy($teamId)
    {
        $team = Team::find($teamId);
        if ($team->homeGames()->count() > 0 || $team->awayGames()->count() > 0) {
            return redirect()->route('admin.teams.index')
                ->with('error', 'Cannot delete team with associated games.');
        }

        if ($team->flag && Storage::exists('public/' . str_replace('storage/', '', $team->flag))) {
            Storage::delete('public/' . str_replace('storage/', '', $team->flag));
        }

        $team->delete();

        return redirect()->route('admin.teams.index')
            ->with('success', 'Team deleted successfully.');
    }
}
