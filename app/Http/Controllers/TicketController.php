<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Game;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;

class TicketController extends Controller
{

    public function index()
    {
        $tickets = Ticket::with(['game.homeTeam', 'game.awayTeam', 'user', 'category'])->paginate(30);
        $games = Game::with(['homeTeam', 'awayTeam'])->get();
        $categories = Category::all();
        $users = User::all();

        // Get ticket statistics
        $availableTickets = Ticket::where('status', 'available')->count();
        $soldTickets = Ticket::where('status', 'sold')->count();
        $reservedTickets = Ticket::where('status', 'reserved')->count();
        $totalRevenue = Ticket::where('status', 'sold')->sum('price');

        // Get category statistics
        $categoryStats = [];
        foreach ($categories as $category) {
            $categoryStats[$category->id] = [
                'available' => Ticket::where('category_id', $category->id)->where('status', 'available')->count(),
                'sold' => Ticket::where('category_id', $category->id)->where('status', 'sold')->count(),
                'reserved' => Ticket::where('category_id', $category->id)->where('status', 'reserved')->count()
            ];
        }


        return view('admin.tickets', compact(
            'tickets',
            'games',
            'categories',
            'users',
            'availableTickets',
            'soldTickets',
            'reservedTickets',
            'totalRevenue',
            'categoryStats',
        ));
    }


    public function store(Request $request)
    {
        $request->validate([
            'game_id' => 'required|exists:games,id',
            'price' => 'required|numeric|min:0',
            'place_number' => 'required|integer|min:1',
            'status' => 'required|string|in:available,sold,reserved,canceled',
            'category_id' => 'required|exists:categories,id',
        ]);

        $ticket = new Ticket();
        $ticket->game_id = $request->game_id;
        $ticket->user_id = $request->user_id;
        $ticket->price = $request->price;
        $ticket->place_number = $request->place_number;
        $ticket->status = $request->status;
        $ticket->category_id = $request->category_id;
        $ticket->save();

        return redirect()->route('admin.tickets.index')
            ->with('success', 'Ticket created successfully.');
    }


    public function update(Request $request, $id)
    {
        $ticket = Ticket::findOrFail($id);

        $request->validate([
            'game_id' => 'required|exists:games,id',
            'price' => 'required|numeric|min:0',
            'place_number' => 'required|integer|min:1',
            'status' => 'required|string|in:available,sold,reserved,canceled',
            'category_id' => 'required|exists:categories,id',
        ]);

        $ticket->game_id = $request->game_id;
        $ticket->user_id = $request->user_id;
        $ticket->price = $request->price;
        $ticket->place_number = $request->place_number;
        $ticket->status = $request->status;
        $ticket->category_id = $request->category_id;
        $ticket->save();

        return redirect()->route('admin.tickets.index')
            ->with('success', 'Ticket updated successfully.');
    }


    public function destroy($id)
    {
        $ticket = Ticket::findOrFail($id);

        // Check if ticket has a payment
        if ($ticket->payment) {
            return redirect()->route('admin.tickets.index')
                ->with('error', 'Cannot delete ticket with associated payment.');
        }

        $ticket->delete();

        return redirect()->route('admin.tickets.index')
            ->with('success', 'Ticket deleted successfully.');
    }
}
