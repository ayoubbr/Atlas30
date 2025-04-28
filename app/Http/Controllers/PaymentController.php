<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Ticket;
use App\Notifications\TicketPurchased;
use Illuminate\Http\Request;
use Stripe\PaymentIntent;
use Stripe\Stripe;

class PaymentController extends Controller
{

    public function processPayment(Request $request)
    {
        // dd($request);
        $request->validate([
            'ticket_ids' => 'required',
            'payment_method_id' => 'required',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
            'terms' => 'required|accepted',
        ]);



        $ticketIds = explode(',', $request->ticket_ids);
        $tickets = Ticket::whereIn('id', $ticketIds)->get();



        if ($tickets->isEmpty()) {
            return redirect()->back()->with('error', 'No tickets found.');
        }

        $subtotal = $tickets->sum('price');
        $serviceFee = $subtotal * 0.1;
        $totalAmount = $subtotal + $serviceFee;


        // Convert to cents for Stripe
        $amountInCents = (int) ($totalAmount * 100);

        try {
            Stripe::setApiKey(env('STRIPE_SECRET'));

            $paymentIntent = PaymentIntent::create([
                'amount' => $amountInCents,
                'currency' => 'usd',
                'payment_method' => $request->payment_method_id,
                'confirm' => true,
                'description' => 'World Cup 2030 Tickets - Game #' . $tickets->first()->game_id,
                'receipt_email' => $request->email,
                'metadata' => [
                    'user_id' => auth()->id(),
                    'ticket_ids' => $request->ticket_ids,
                    'game_id' => $tickets->first()->game_id
                ],
                'automatic_payment_methods' => [
                    'enabled' => true,
                    'allow_redirects' => 'never',
                ]
            ]);

            // Check if payment requires additional action
            if ($paymentIntent->status === 'requires_action' && $paymentIntent->next_action->type === 'use_stripe_sdk') {
                session([
                    'payment_intent_id' => $paymentIntent->id,
                    'ticket_ids' => $request->ticket_ids
                ]);

                return response()->json([
                    'requires_action' => true,
                    'payment_intent_client_secret' => $paymentIntent->client_secret
                ]);
            } else if ($paymentIntent->status === 'succeeded') {
                // dd('ssss');
                // Payment succeeded, update tickets and create payment record
                $this->processSuccessfulPayment($tickets, $paymentIntent, $totalAmount);
                // dd('yes');
                return redirect()->route('tickets.confirmation')->with('success', 'Payment successful! Your tickets have been confirmed.');
            } else {
                // Payment failed
                return redirect()->back()->with('error', 'Payment failed. Please try again.');
            }
        } catch (ApiErrorException $e) {
            // Handle Stripe API errors
            return redirect()->back()->with('error', 'Payment error: ' . $e->getMessage());
        } catch (\Exception $e) {
            // Handle other errors
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }


    private function processSuccessfulPayment($tickets, $paymentIntent, $totalAmount)
    {
        // dd($totalAmount);
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

        $user = auth()->user();
        $user->notify(new TicketPurchased($tickets, $totalAmount));
    }


    public function confirmation()
    {
        $user = auth()->user();
        $recentTickets = Ticket::where('user_id', $user->id)
            ->where('status', 'confirmed')
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        return view('user.confirmation', compact('recentTickets'));
    }
}
