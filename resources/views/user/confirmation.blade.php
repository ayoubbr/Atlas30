@extends('user.layout')

@section('title', 'Payment Confirmation - World Cup 2030')

@section('css')
    <style>
        .confirmation-container {
            background-color: white;
            border-radius: 8px;
            padding: 40px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            text-align: center;
            margin-bottom: 40px;
        }

        .success-icon {
            font-size: 5rem;
            color: var(--success);
            margin-bottom: 20px;
        }

        .confirmation-title {
            font-size: 2rem;
            margin-bottom: 15px;
        }

        .confirmation-message {
            font-size: 1.1rem;
            color: var(--gray-700);
            margin-bottom: 30px;
        }

        .confirmation-details {
            background-color: var(--gray-100);
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 30px;
            text-align: left;
        }

        .confirmation-detail-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            padding-bottom: 10px;
            border-bottom: 1px solid var(--gray-300);
        }

        .confirmation-detail-item:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .confirmation-detail-label {
            font-weight: 600;
            color: var(--gray-700);
        }

        .confirmation-detail-value {
            font-weight: 600;
            color: var(--gray-900);
        }

        .confirmation-actions {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 20px;
        }

        .tickets-container {
            margin-top: 40px;
        }

        .tickets-title {
            font-size: 1.5rem;
            margin-bottom: 20px;
            text-align: center;
        }

        .fa-qrcode:before {
            color: black
        }

        .tickets-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
        }

        .ticket-card {
            background-color: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease;
        }

        .ticket-card:hover {
            transform: translateY(-5px);
        }

        .ticket-header {
            background-color: var(--primary);
            color: white;
            padding: 15px;
            position: relative;
        }

        .ticket-title {
            font-size: 1.2rem;
            margin-bottom: 5px;
        }

        .ticket-subtitle {
            font-size: 0.9rem;
            opacity: 0.8;
        }

        .ticket-qr {
            position: absolute;
            top: 15px;
            right: 15px;
            width: 50px;
            height: 50px;
            background-color: white;
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .ticket-body {
            padding: 20px;
        }

        .ticket-info-item {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .ticket-info-item i {
            width: 20px;
            margin-right: 10px;
            color: var(--primary);
        }

        .ticket-info-label {
            font-weight: 600;
            margin-right: 5px;
        }

        .ticket-actions {
            padding: 15px;
            border-top: 1px solid var(--gray-200);
            display: flex;
            justify-content: end;
            gap: 10px
        }

        @media (max-width: 768px) {
            .confirmation-actions {
                flex-direction: column;
            }

            .tickets-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endsection

@section('content')
    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <h1>Payment Confirmation</h1>
            <ul class="breadcrumb">
                <li><a href="{{ url('/') }}">Home</a></li>
                <li><a href="{{ route('games') }}">Matches</a></li>
                <li>Payment Confirmation</li>
            </ul>
        </div>
    </section>

    <!-- Main Content -->
    <main class="container">
        <div class="confirmation-container">
            <i class="fas fa-check-circle success-icon"></i>
            <h2 class="confirmation-title">Payment Successful!</h2>
            <p class="confirmation-message">
                Thank you for your purchase. Your tickets have been confirmed and are ready to use.
                You will also receive a confirmation email with your ticket details.
            </p>

            <div class="confirmation-actions">
                <a href="{{ route('profile') }}" class="btn btn-lg btn-primary">
                    <i class="fas fa-ticket-alt"></i> View My Tickets
                </a>
                <a href="{{ route('games') }}" class="btn btn-lg btn-outline">
                    <i class="fas fa-search"></i> Browse More Matches
                </a>
            </div>
        </div>

        @if ($recentTickets->isNotEmpty())
            <div class="tickets-container">
                <h3 class="tickets-title">Your Recent Tickets</h3>
                <div class="tickets-grid">
                    @foreach ($recentTickets as $ticket)
                        <div class="ticket-card">
                            <div class="ticket-header">
                                <h4 class="ticket-title">{{ $ticket->game->homeTeam->name }} vs
                                    {{ $ticket->game->awayTeam->name }}</h4>
                                <div class="ticket-subtitle">{{ $ticket->game->start_date }} -
                                    {{ $ticket->game->start_hour }}</div>
                                <div class="ticket-qr">
                                    <i class="fas fa-qrcode fa-2x"></i>
                                </div>
                            </div>
                            <div class="ticket-body">
                                <div class="ticket-info-item">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <span>{{ $ticket->game->stadium->name }}, {{ $ticket->game->stadium->city }}</span>
                                </div>
                                <div class="ticket-info-item">
                                    <i class="fas fa-couch"></i>
                                    <span><span class="ticket-info-label">Section:</span> {{ $ticket->section }}</span>
                                </div>
                                <div class="ticket-info-item">
                                    <i class="fas fa-chair"></i>
                                    <span><span class="ticket-info-label">Seat:</span> {{ $ticket->place_number }}</span>
                                </div>
                                <div class="ticket-info-item">
                                    <i class="fas fa-tag"></i>
                                    <span><span class="ticket-info-label">Price:</span>
                                        ${{ number_format($ticket->price, 2) }}</span>
                                </div>
                                <div class="ticket-info-item">
                                    <i class="fas fa-check-circle"></i>
                                    <span><span class="ticket-info-label">Status:</span>
                                        {{ ucfirst($ticket->status) }}</span>
                                </div>
                            </div>
                            <div class="ticket-actions">
                                <a href="{{ route('user.ticket.download', $ticket->id) }}" class="btn btn-sm btn-outline">
                                    <i class="fas fa-download"></i> Download
                                </a>
                                <a href="{{ route('user.ticket.view', $ticket->id) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-eye"></i> View
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </main>
@endsection
