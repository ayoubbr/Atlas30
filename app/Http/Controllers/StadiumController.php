<?php

namespace App\Http\Controllers;

use App\Repository\Impl\IStadiumRepository;
use Illuminate\Http\Request;

class StadiumController extends Controller
{
    private $stadiumRepository;

    public function __construct(IStadiumRepository $stadiumRepository)
    {
        $this->stadiumRepository = $stadiumRepository;
    }

    public function index()
    {
        $stadiums = $this->stadiumRepository->getAllStadiums();
        return view('admin.stadiums', compact('stadiums'));
    }

    public function visitorIndex()
    {
        $stadiums = $this->stadiumRepository->getStadiumsWithGames();
        return view('user.stadiums', compact('stadiums'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:stadiums',
            'city' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif',
        ]);

        $this->stadiumRepository->createStadium($request->all());

        return redirect()->route('admin.stadiums.index')
            ->with('success', 'Stadium created successfully.');
    }

    public function update(Request $request, $stadiumId)
    {
        $stadium = $this->stadiumRepository->getStadiumById($stadiumId);

        if (!$stadium) {
            return redirect()->route('admin.stadiums.index')
                ->with('error', 'Stadium not found.');
        }

        $request->validate([
            'name' => 'required|string|max:255|unique:stadiums,name,' . $stadium->id,
            'city' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $result = $this->stadiumRepository->updateStadium($stadiumId, $request->all());

        if (!$result) {
            return redirect()->route('admin.stadiums.index')
                ->with('error', 'Failed to update stadium.');
        }

        return redirect()->route('admin.stadiums.index')
            ->with('success', 'Stadium updated successfully.');
    }

    public function destroy($stadiumId)
    {
        $result = $this->stadiumRepository->deleteStadium($stadiumId);

        if (!$result) {
            return redirect()->route('admin.stadiums.index')
                ->with('error', 'Cannot delete stadium with associated games.');
        }

        return redirect()->route('admin.stadiums.index')
            ->with('success', 'Stadium deleted successfully.');
    }
}
