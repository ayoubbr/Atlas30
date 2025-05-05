<?php

namespace App\Repository\Impl;

use Illuminate\Database\Eloquent\Collection;

interface IDashboardRepository
{
    public function getStadiumCount(): int;
    public function getForumPostCount(): int;
    public function getTicketsSoldThisWeek(): int;
    public function getTicketSalesByMatch(int $limit = 4): Collection;
    public function getUpcomingMatches(int $limit = 10): Collection;
    public function getRecentForumActivity(int $limit = 4): Collection;
}