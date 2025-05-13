<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\User;
use App\Repository\Impl\ITicketRepository;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    private $ticketRepository;

    public function __construct(ITicketRepository $ticketRepository)
    {
        $this->ticketRepository = $ticketRepository;
    }

    public function index()
    {
        $tickets = $this->ticketRepository->getAllTickets();
        $games = Game::with(['homeTeam', 'awayTeam'])->get();
        $users = User::all();

        $statistics = $this->ticketRepository->getTicketStatistics();
        $categories = ['regular', 'premium', 'standard', 'vip'];

        return view('admin.tickets', compact(
            'tickets',
            'games',
            'users',
            'categories',
            'statistics'
        ));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'game_id' => 'required|exists:games,id',
            'price' => 'required|numeric|min:0',
            'place_number' => 'required|integer|min:1',
            'status' => 'required|string|in:used,paid,sold,canceled'
        ]);

        $result = $this->ticketRepository->updateTicket($id, $request->all());

        if (!$result) {
            return redirect()->route('admin.tickets.index')
                ->with('error', 'Failed to update ticket.');
        }

        return redirect()->route('admin.tickets.index')
            ->with('success', 'Ticket updated successfully.');
    }

    public function destroy($id)
    {
        $result = $this->ticketRepository->deleteTicket($id);

        if (!$result) {
            return redirect()->route('admin.tickets.index')
                ->with('error', 'Cannot delete ticket with associated payment.');
        }

        return redirect()->route('admin.tickets.index')
            ->with('success', 'Ticket deleted successfully.');
    }

    public function checkout(Request $request)
    {
        $ticketIds = explode(',', $request->query('tickets'));
        $success = session('success');

        $tickets = $this->ticketRepository->getTicketsByIds($ticketIds);

        if ($tickets->isEmpty()) {
            return redirect()->route('games')->with('error', 'No tickets found.');
        }

        return view('user.payment', compact('tickets', 'success'));
    }

    public function downloadPdf($ticketId)
    {
        $ticket = $this->ticketRepository->getTicketByIdAndUser($ticketId, auth()->id());

        if (!$ticket) {
            return redirect()->back()->with('error', 'Ticket not found.');
        }

        $pdf = Pdf::loadView('user.ticket-pdf', compact('ticket'));
        $pdf->setPaper('a4', 'portrait');
        $pdf->setOptions([
            'dpi' => 150,
            'defaultFont' => 'sans-serif',
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true
        ]);

        return $pdf->download('ticket_' . $ticket->id . '.pdf');
    }
}
