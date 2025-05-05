<?php

namespace App\Repository\Impl;

use App\Models\Payment;
use Illuminate\Database\Eloquent\Collection;
use Stripe\PaymentIntent;

interface IPaymentRepository
{
    public function getTicketsByIds(array $ticketIds): Collection;
    public function createPaymentIntent(array $data, int $amountInCents): PaymentIntent;
    public function processSuccessfulPayment(Collection $tickets, PaymentIntent $paymentIntent, float $totalAmount): void;
    public function getRecentConfirmedTickets(int $userId, int $limit = 10): Collection;
}
