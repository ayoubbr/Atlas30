<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Repository\Impl\ITeamRepository;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    private $teamRepository;

    public function __construct(ITeamRepository $teamRepository)
    {
        $this->teamRepository = $teamRepository;
    }

    public function index()
    {
        $teams = $this->teamRepository->getPaginatedTeams();
        $countTeams = $this->teamRepository->getTeamCount();
        $countMatches = Game::count();

        return view('admin.teams', compact('teams', 'countTeams', 'countMatches'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:teams',
            'code' => 'required|string|max:3|unique:teams',
            'flag' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $this->teamRepository->createTeam($request->all());

        return redirect()->route('admin.teams.index')
            ->with('success', 'Team created successfully.');
    }

    public function update(Request $request, $teamId)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:3',
            'flag' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $result = $this->teamRepository->updateTeam($teamId, $request->all());

        if (!$result) {
            return redirect()->route('admin.teams.index')
                ->with('error', 'Failed to update team.');
        }

        return redirect()->route('admin.teams.index')
            ->with('success', 'Team updated successfully.');
    }

    public function destroy($teamId)
    {
        $result = $this->teamRepository->deleteTeam($teamId);

        if (!$result) {
            return redirect()->route('admin.teams.index')
                ->with('error', 'Cannot delete team with associated games.');
        }

        return redirect()->route('admin.teams.index')
            ->with('success', 'Team deleted successfully.');
    }

    public function visitorIndex(Request $request)
    {
        $search = $request->input('search');
        $sort = $request->input('sort', 'name');
        $direction = $request->input('direction', 'asc');

        $teams = $this->teamRepository->searchTeams($search, $sort, $direction);
        $totalTeams = $this->teamRepository->getTeamCount();
        $totalMatches = Game::count();

        return view('user.teams', compact('teams', 'totalTeams', 'totalMatches', 'search', 'sort', 'direction'));
    }

    public function visitorShow($id)
    {
        $team = $this->teamRepository->getTeamById($id);

        if (!$team) {
            return redirect()->back()->with('error', 'Team not found.');
        }

        $stats = $this->teamRepository->getTeamStatistics($id);
        $totalMatches =  $this->teamRepository->getTeamGamesCount($id);
        $homeMatches =  $this->teamRepository->getHomeTeamGamesCount($id);
        $awayMatches =  $this->teamRepository->getAwayTeamGamesCount($id);
        $upcomingMatches =  $this->teamRepository->getTeamUpcomingGames($id);
        $recentMatches =  $this->teamRepository->getTeamRecentGames($id);
        // dd($upcomingMatches);
        return view('user.team-details', compact(
            'team',
            'stats',
            'totalMatches',
            'homeMatches',
            'awayMatches',
            'upcomingMatches',
            'recentMatches'
        ));
    }
}
