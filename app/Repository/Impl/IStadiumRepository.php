<?php

namespace App\Repository\Impl;

use App\Models\Stadium;
use Illuminate\Database\Eloquent\Collection;

interface IStadiumRepository
{
    public function getAllStadiums(): Collection;
    public function getStadiumsWithGames(): Collection;
    public function getStadiumById(int $id): ?Stadium;
    public function createStadium(array $data): Stadium;
    public function updateStadium(int $id, array $data): bool;
    public function deleteStadium(int $id): bool;
}
