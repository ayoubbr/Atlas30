<?php

namespace App\Http\Controllers;

use App\Repository\Impl\IDashboardRepository;

class DashboardController extends Controller
{
    private $dashboardRepository;

    public function __construct(IDashboardRepository $dashboardRepository)
    {
        $this->dashboardRepository = $dashboardRepository;
    }

    public function index()
    {
        $upcomingMatches = $this->dashboardRepository->getUpcomingMatches();
        $ticketsSoldThisWeek = $this->dashboardRepository->getTicketsSoldThisWeek();
        $stadiumCount = $this->dashboardRepository->getStadiumCount();
        $forumPostCount = $this->dashboardRepository->getForumPostCount();
        $ticketSalesByMatch = $this->dashboardRepository->getTicketSalesByMatch();
        $recentForumActivity = $this->dashboardRepository->getRecentForumActivity();

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