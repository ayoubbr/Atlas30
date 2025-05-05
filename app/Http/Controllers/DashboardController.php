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
        $stadiumCount = $this->dashboardRepository->getStadiumCount();
        $forumPostCount = $this->dashboardRepository->getForumPostCount();
        $ticketsSoldThisWeek = $this->dashboardRepository->getTicketsSoldThisWeek();
        $ticketSalesByMatch = $this->dashboardRepository->getTicketSalesByMatch();
        $upcomingMatches = $this->dashboardRepository->getUpcomingMatches();
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