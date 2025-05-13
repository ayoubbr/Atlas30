<?php

namespace App\Repository;

use App\Models\Stadium;
use App\Repository\Impl\IStadiumRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class StadiumRepository implements IStadiumRepository
{
    public function getAllStadiums(): Collection
    {
        return Stadium::all();
    }

    public function getStadiumsWithGames(): Collection
    {
        return Stadium::with('games')->get();
    }

    public function getStadiumById(int $id): ?Stadium
    {
        return Stadium::find($id);
    }

    public function createStadium(array $data): Stadium
    {
        $stadium = new Stadium();
        $stadium->name = $data['name'];
        $stadium->city = $data['city'];
        $stadium->capacity = $data['capacity'];

        if (isset($data['image']) && $data['image']) {
            $imageName = Str::slug($data['name']) . '-' . time() . '.' . $data['image']->extension();
            $data['image']->storeAs('public/stadiums', $imageName);
            $stadium->image = 'storage/stadiums/' . $imageName;
        }

        $stadium->save();

        return $stadium;
    }

    public function updateStadium(int $id, array $data): bool
    {
        $stadium = $this->getStadiumById($id);

        if (!$stadium) {
            return false;
        }

        $stadium->name = $data['name'];
        $stadium->city = $data['city'];
        $stadium->capacity = $data['capacity'];

        if (isset($data['image']) && $data['image']) {
            if ($stadium->image && Storage::exists('public/' . str_replace('storage/', '', $stadium->image))) {
                Storage::delete('public/' . str_replace('storage/', '', $stadium->image));
            }

            $imageName = Str::slug($data['name']) . '-' . time() . '.' . $data['image']->extension();
            $data['image']->storeAs('public/stadiums', $imageName);
            $stadium->image = 'storage/stadiums/' . $imageName;
        }

        return $stadium->save();
    }

    public function deleteStadium(int $id): bool
    {
        $stadium = $this->getStadiumById($id);

        if (!$stadium) {
            return false;
        }

        if ($stadium->games()->count() > 0) {
            return false;
        }

        if ($stadium->image && Storage::exists('public/' . str_replace('storage/', '', $stadium->image))) {
            Storage::delete('public/' . str_replace('storage/', '', $stadium->image));
        }

        return $stadium->delete();
    }
}
