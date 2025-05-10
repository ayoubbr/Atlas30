<?php

namespace App\Repository\Impl;

use App\Models\Ticket;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface ITicketRepository
{
    public function getAllTickets(int $perPage = 30): LengthAwarePaginator;
    public function getTicketById(int $id): ?Ticket;
    public function getTicketsByIds(array $ids): Collection;
    public function updateTicket(int $id, array $data): bool;
    public function deleteTicket(int $id): bool;
    public function getTicketsByUser(int $userId): Collection;
    public function getTicketStatistics(): array;
    public function getTicketByIdAndUser(int $id, int $userId): ?Ticket;
    public function getTicketWithRelations(int $id): ?Ticket;
}
