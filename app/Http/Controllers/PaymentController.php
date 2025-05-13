<?php

namespace App\Http\Controllers;

use App\Repository\Impl\IPaymentRepository;
use Illuminate\Http\Request;
use Stripe\Exception\ApiErrorException;

class PaymentController extends Controller
{
    private $paymentRepository;

    public function __construct(IPaymentRepository $paymentRepository)
    {
        $this->paymentRepository = $paymentRepository;
    }

    public function processPayment(Request $request)
    {
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
        $tickets = $this->paymentRepository->getTicketsByIds($ticketIds);

        if ($tickets->isEmpty()) {
            return redirect()->back()->with('error', 'No tickets found.');
        }

        $subtotal = $tickets->sum('price');
        $serviceFee = $subtotal * 0.1;
        $totalAmount = $subtotal + $serviceFee;

        $amountInCents = (int) ($totalAmount * 100);

        try {
            $paymentIntent = $this->paymentRepository->createPaymentIntent([
                'payment_method_id' => $request->payment_method_id,
                'email' => $request->email,
                'user_id' => auth()->id(),
                'ticket_ids' => $request->ticket_ids,
                'game_id' => $tickets->first()->game_id
            ], $amountInCents);

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
                $this->paymentRepository->processSuccessfulPayment($tickets, $paymentIntent, $totalAmount);
                return redirect()->route('tickets.confirmation')->with('success', 'Payment successful! Your tickets have been confirmed.');
            } else {
                return redirect()->back()->with('error', 'Payment failed. Please try again.');
            }
        } catch (ApiErrorException $e) {
            return redirect()->back()->with('error', 'Payment error: ' . $e->getMessage());
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function confirmation()
    {
        $user = auth()->user();
        $recentTickets = $this->paymentRepository->getRecentConfirmedTickets($user->id);
        return view('user.confirmation', compact('recentTickets'));
    }
}
