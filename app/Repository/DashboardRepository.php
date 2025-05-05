<?php

namespace App\Repository;

use App\Models\Game;
use App\Models\Post;
use App\Models\Stadium;
use App\Models\Ticket;
use App\Repository\Impl\IDashboardRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class DashboardRepository implements IDashboardRepository
{
    public function getStadiumCount(): int
    {
        return Stadium::count();
    }

    public function getForumPostCount(): int
    {
        return Post::count();
    }

    public function getTicketsSoldThisWeek(): int
    {
        return Ticket::whereBetween('created_at', [
            Carbon::now()->startOfWeek(),
            Carbon::now()->endOfWeek()
        ])->count();
    }

    public function getTicketSalesByMatch(int $limit = 4): Collection
    {
        return Game::withCount('tickets')
            ->orderBy('tickets_count', 'desc')
            ->take($limit)
            ->get();
    }

    public function getUpcomingMatches(int $limit = 10): Collection
    {
        return Game::with(['homeTeam', 'awayTeam', 'stadium'])
            ->where('start_date', '>=', Carbon::now()->toDateString())
            ->orderBy('start_date')
            ->take($limit)
            ->get();
    }

    public function getRecentForumActivity(int $limit = 4): Collection
    {
        return Post::with(['user'])
            ->latest()
            ->take($limit)
            ->get();
    }
}
