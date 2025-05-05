<?php

namespace App\Repository\Impl;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface IGameRepository
{
    public function home();
    public function getAllWithRelations();
    public function findById($id);
    public function store(array $data);
    public function update($id, array $data);
    public function updateScore($id, array $data);
    public function delete($id);
    public function getFilteredGames(Request $request);
    public function getGameWithRelations($id);
    public function getTeamGames($teamId);
    public function getUpcomingGames($limit = 5);
    public function getLiveGames();
    public function getRecentResults($limit = 5);
    public function hasTickets($id);
}
