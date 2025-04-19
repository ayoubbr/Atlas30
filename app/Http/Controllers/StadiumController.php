<?php

namespace App\Http\Controllers;

use App\Models\Stadium;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class StadiumController extends Controller
{

    public function index()
    {
        $stadiums = Stadium::all();
        return view('admin.stadiums', compact('stadiums'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:stadiums',
            'city' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif',
        ]);

        $stadium = new Stadium();
        $stadium->name = $request->name;
        $stadium->city = $request->city;
        $stadium->capacity = $request->capacity;

        if ($request->hasFile('image')) {
            $imageName = Str::slug($request->name) . '-' . time() . '.' . $request->image->extension();
            $request->image->storeAs('public/stadiums', $imageName);
            $stadium->image = 'storage/stadiums/' . $imageName;
        }

        $stadium->save();

        return redirect()->route('admin.stadiums.index')
            ->with('success', 'Stadium created successfully.');
    }


    // public function show(Stadium $stadium)
    // {
    //     $stadium->load('games.homeTeam', 'games.awayTeam');
    //     return view('admin.stadiums', compact('stadium'));
    // }


    public function update(Request $request, $stadiumId)
    {
        $stadium = Stadium::find($stadiumId);

        $request->validate([
            'name' => 'required|string|max:255|unique:stadiums,name,' . $stadium->id,
            'city' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $stadium->name = $request->name;
        $stadium->city = $request->city;
        $stadium->capacity = $request->capacity;

        if ($request->hasFile('image')) {
            if ($stadium->image && Storage::exists('public/' . str_replace('storage/', '', $stadium->image))) {
                Storage::delete('public/' . str_replace('storage/', '', $stadium->image));
            }

            $imageName = Str::slug($request->name) . '-' . time() . '.' . $request->image->extension();
            $request->image->storeAs('public/stadiums', $imageName);
            $stadium->image = 'storage/stadiums/' . $imageName;
        }

        $stadium->save();

        return redirect()->route('admin.stadiums.index')
            ->with('success', 'Stadium updated successfully.');
    }


    public function destroy($stadiumId)
    {
        $stadium = Stadium::find($stadiumId);

        if ($stadium->games()->count() > 0) {
            return redirect()->route('admin.stadiums.index')
                ->with('error', 'Cannot delete stadium with associated games.');
        }

        if ($stadium->image && Storage::exists('public/' . str_replace('storage/', '', $stadium->image))) {
            Storage::delete('public/' . str_replace('storage/', '', $stadium->image));
        }

        $stadium->delete();

        return redirect()->route('admin.stadiums.index')
            ->with('success', 'Stadium deleted successfully.');
    }
}
