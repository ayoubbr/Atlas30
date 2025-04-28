<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Post;
use App\Models\Stadium;
use App\Models\Ticket;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $stadiumCount = Stadium::count();

        $forumPostCount = Post::count();

        $ticketsSoldThisWeek = Ticket::whereBetween('created_at', [
            Carbon::now()->startOfWeek(),
            Carbon::now()->endOfWeek()
        ])->count();


        $ticketSalesByMatch = Game::withCount('tickets')
            ->orderBy('tickets_count', 'desc')
            ->take(4)
            ->get();

        $upcomingMatches = Game::with(['homeTeam', 'awayTeam', 'stadium'])
            ->where('start_date', '>=', Carbon::now()->toDateString())
            ->orderBy('start_date')
            ->take(10)
            ->get();

        $recentForumActivity = Post::with(['user'])
            ->latest()
            ->take(4)
            ->get();

        return view('admin.dashboard', compact(
            'stadiumCount',
            'forumPostCount',
            'ticketsSoldThisWeek',
            'ticketSalesByMatch',
            'upcomingMatches',
            'recentForumActivity'
        ));
    }
}
