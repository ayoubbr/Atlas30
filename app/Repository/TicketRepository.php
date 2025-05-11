<?php

namespace App\Repository;

use App\Models\Ticket;
use App\Repository\Impl\ITicketRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class TicketRepository implements ITicketRepository
{
    public function getAllTickets(int $perPage = 30): LengthAwarePaginator
    {
        return Ticket::with(['game.homeTeam', 'game.awayTeam', 'user'])->paginate($perPage);
    }

    public function getTicketById(int $id): ?Ticket
    {
        return Ticket::find($id);
    }

    public function getTicketsByIds(array $ids): Collection
    {
        return Ticket::whereIn('id', $ids)->get();
    }

    public function updateTicket(int $id, array $data): bool
    {
        $ticket = $this->getTicketById($id);

        if (!$ticket) {
            return false;
        }

        $ticket->game_id = $data['game_id'];
        $ticket->user_id = $data['user_id'] ?? $ticket->user_id;
        $ticket->price = $data['price'];
        $ticket->place_number = $data['place_number'];
        $ticket->status = $data['status'];
        $ticket->section = $data['section'] ?? $ticket->section;

        return $ticket->save();
    }

    public function deleteTicket(int $id): bool
    {
        $ticket = $this->getTicketById($id);

        if (!$ticket || $ticket->payment) {
            return false;
        }

        return $ticket->delete();
    }

    public function getTicketsByUser(int $userId): Collection
    {
        return Ticket::where('user_id', $userId)
            ->with(['game.homeTeam', 'game.awayTeam', 'game.stadium'])
            ->get();
    }

    public function getTicketStatistics(): array
    {
        return [
            'usedTickets' => Ticket::where('status', 'used')->count(),
            'paidTickets' => Ticket::where('status', 'paid')->count(),
            'soldTickets' => Ticket::where('status', 'sold')->count(),
            'totalRevenue' => Ticket::where('status', 'used')->orWhere('status', 'paid')->sum('price')
        ];
    }

    public function getTicketByIdAndUser(int $id, int $userId): ?Ticket
    {
        return Ticket::where('id', $id)
            ->where('user_id', $userId)
            ->first();
    }

    public function getTicketWithRelations(int $id): ?Ticket
    {
        return Ticket::with(['game.homeTeam', 'game.awayTeam', 'game.stadium', 'user'])
            ->find($id);
    }
}
