@extends('user.layout')

@section('title', 'Verify Ticket - World Cup 2030')

@section('css')
    <style>
        .verification-container {
            max-width: 600px;
            margin: 40px auto;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .verification-header {
            background-color: #1d3557;
            color: white;
            padding: 20px;
            text-align: center;
        }

        .verification-title {
            font-size: 24px;
            margin: 0;
        }

        .verification-body {
            padding: 30px;
        }

        .verification-status {
            text-align: center;
            margin-bottom: 30px;
        }

        .status-icon {
            font-size: 60px;
            margin-bottom: 15px;
        }

        .status-icon.valid {
            color: #2ecc71;
        }

        .status-icon.invalid {
            color: #e74c3c;
        }

        .status-message {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .status-description {
            color: #718096;
        }

        .ticket-details {
            background-color: #f8fafc;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .ticket-detail-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            padding-bottom: 10px;
            border-bottom: 1px solid #e2e8f0;
        }

        .ticket-detail-row:last-child {
            margin-bottom: 0;
            padding-bottom: 0;
            border-bottom: none;
        }

        .ticket-detail-label {
            font-weight: bold;
            color: #4a5568;
        }

        .ticket-detail-value {
            color: #1d3557;
        }

        .match-info {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .team {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 40%;
        }

        .team-flag {
            width: 60px;
            height: 40px;
            object-fit: cover;
            border-radius: 4px;
            margin-bottom: 8px;
        }

        .team-name {
            font-weight: bold;
            text-align: center;
            font-size: 14px;
        }

        .versus {
            font-weight: bold;
            color: #a0aec0;
        }

        .verification-actions {
            text-align: center;
            margin-top: 20px;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #1d3557;
            color: white;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: #152a45;
        }
    </style>
@endsection

@section('content')
    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <h1>Ticket Verification</h1>
            <ul class="breadcrumb">
                <li><a href="{{ url('/') }}">Home</a></li>
                <li>Ticket Verification</li>
            </ul>
        </div>
    </section>

    <div class="container">
        <div class="verification-container">
            <div class="verification-header">
                <h2 class="verification-title">Ticket Verification</h2>
            </div>
            <div class="verification-body">
                <div class="verification-status">
                    @if ($ticket->status === 'confirmed')
                        <div class="status-icon valid">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="status-message">Valid Ticket</div>
                        <div class="status-description">This ticket is valid and can be used for entry.</div>
                    @elseif($ticket->status === 'used')
                        <div class="status-icon invalid">
                            <i class="fas fa-times-circle"></i>
                        </div>
                        <div class="status-message">Ticket Already Used</div>
                        <div class="status-description">This ticket has already been used for entry.</div>
                    @else
                        <div class="status-icon invalid">
                            <i class="fas fa-exclamation-circle"></i>
                        </div>
                        <div class="status-message">Invalid Ticket</div>
                        <div class="status-description">This ticket is not valid for entry.</div>
                    @endif
                </div>

                <div class="match-info">
                    <div class="team">
                        <img src="{{ asset($ticket->game->homeTeam->flag) }}" alt="{{ $ticket->game->homeTeam->name }}"
                            class="team-flag">
                        <div class="team-name">{{ $ticket->game->homeTeam->name }}</div>
                    </div>
                    <div class="versus">VS</div>
                    <div class="team">
                        <img src="{{ asset($ticket->game->awayTeam->flag) }}" alt="{{ $ticket->game->awayTeam->name }}"
                            class="team-flag">
                        <div class="team-name">{{ $ticket->game->awayTeam->name }}</div>
                    </div>
                </div>

                <div class="ticket-details">
                    <div class="ticket-detail-row">
                        <div class="ticket-detail-label">Ticket ID</div>
                        <div class="ticket-detail-value">#{{ $ticket->id }}</div>
                    </div>
                    <div class="ticket-detail-row">
                        <div class="ticket-detail-label">Match Date</div>
                        <div class="ticket-detail-value">
                            {{ \Carbon\Carbon::parse($ticket->game->start_date)->format('d M Y') }}</div>
                    </div>
                    <div class="ticket-detail-row">
                        <div class="ticket-detail-label">Match Time</div>
                        <div class="ticket-detail-value">{{ $ticket->game->start_hour }}</div>
                    </div>
                    <div class="ticket-detail-row">
                        <div class="ticket-detail-label">Stadium</div>
                        <div class="ticket-detail-value">{{ $ticket->game->stadium->name }}</div>
                    </div>
                    <div class="ticket-detail-row">
                        <div class="ticket-detail-label">Section</div>
                        <div class="ticket-detail-value">{{ $ticket->section }}</div>
                    </div>
                    <div class="ticket-detail-row">
                        <div class="ticket-detail-label">Seat</div>
                        <div class="ticket-detail-value">{{ $ticket->place_number }}</div>
                    </div>
                    <div class="ticket-detail-row">
                        <div class="ticket-detail-label">Ticket Holder</div>
                        <div class="ticket-detail-value">{{ $ticket->user->name }}</div>
                    </div>
                </div>

                @if (auth()->check() && auth()->user()->isAdmin())
                    <div class="verification-actions">
                        <a href="{{ route('admin.tickets.mark-used', $ticket->id) }}" class="btn">Mark as Used</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
