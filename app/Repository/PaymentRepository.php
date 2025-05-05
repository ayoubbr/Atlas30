<?php

namespace App\Repository;

use App\Models\Payment;
use App\Models\Ticket;
use App\Models\User;
use App\Notifications\TicketPurchased;
use App\Repository\Impl\IPaymentRepository;
use Illuminate\Database\Eloquent\Collection;
use Stripe\PaymentIntent;
use Stripe\Stripe;

class PaymentRepository implements IPaymentRepository
{
    public function getTicketsByIds(array $ticketIds): Collection
    {
        return Ticket::whereIn('id', $ticketIds)->get();
    }

    public function createPaymentIntent(array $data, int $amountInCents): PaymentIntent
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        return PaymentIntent::create([
            'amount' => $amountInCents,
            'currency' => 'usd',
            'payment_method' => $data['payment_method_id'],
            'confirm' => true,
            'description' => 'World Cup 2030 Tickets - Game #' . $data['game_id'],
            'receipt_email' => $data['email'],
            'metadata' => [
                'user_id' => $data['user_id'],
                'ticket_ids' => $data['ticket_ids'],
                'game_id' => $data['game_id']
            ],
            'automatic_payment_methods' => [
                'enabled' => true,
                'allow_redirects' => 'never',
            ]
        ]);
    }

    public function processSuccessfulPayment(Collection $tickets, PaymentIntent $paymentIntent, float $totalAmount): void
    {
        foreach ($tickets as $ticket) {
            $ticket->status = 'confirmed';
            $ticket->save();
        }

        $payment = new Payment();
        $payment->user_id = auth()->id();
        $payment->amount = $totalAmount;
        $payment->payment_id = $paymentIntent->id;
        $payment->payment_method = 'stripe';
        $payment->status = 'completed';
        $payment->save();

        foreach ($tickets as $ticket) {
            $ticket->payment_id = $payment->id;
            $ticket->save();
        }

        $user = User::find(auth()->id());
        $user->notify(new TicketPurchased($tickets, $totalAmount));
    }

    public function getRecentConfirmedTickets(int $userId, int $limit = 10): Collection
    {
        return Ticket::where('user_id', $userId)
            ->where('status', 'confirmed')
            ->orderBy('created_at', 'desc')
            ->take($limit)
            ->get();
    }
}
