<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Billet #{{ $ticket->id }} - World Cup 2030</title>
    <style>
        @page {
            margin: 0;
        }

        body {
            font-family: 'Poppins', 'DejaVu Sans', sans-serif;
            margin: 0;
            padding: 0;
            color: #4a5568;
            line-height: 1.5;
        }

        .ticket-container {
            position: relative;
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
        }

        .ticket {
            background-color: #ffffff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            border: 1px solid #e2e8f0;
        }

        .ticket-header {
            background-color: #1d3557;
            color: white;
            padding: 20px;
            position: relative;
        }

        .ticket-title {
            font-size: 24px;
            font-weight: bold;
            margin: 0;
            text-align: center;
        }

        .ticket-subtitle {
            font-size: 14px;
            text-align: center;
            opacity: 0.8;
            margin-top: 5px;
        }

        .logo {
            position: absolute;
            top: 20px;
            left: 20px;
            width: 80px;
            height: auto;
        }

        .ticket-number {
            position: absolute;
            top: 20px;
            right: 20px;
            background-color: #e63946;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            font-weight: bold;
            font-size: 14px;
        }

        .match-details {
            padding: 20px;
            background-color: #f8fafc;
            border-bottom: 1px dashed #e2e8f0;
        }

        .teams {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .team {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 40%;
        }

        .team-flag {
            width: 80px;
            height: 60px;
            object-fit: cover;
            border-radius: 5px;
            margin-bottom: 10px;
            border: 1px solid #e2e8f0;
        }

        .team-name {
            font-weight: bold;
            font-size: 16px;
            text-align: center;
            color: #1d3557;
        }

        .versus {
            font-size: 20px;
            font-weight: bold;
            color: #a0aec0;
        }

        .match-info {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            margin-top: 20px;
        }

        .match-info-item {
            display: flex;
            flex-direction: column;
            width: 30%;
            margin-bottom: 15px;
        }

        .match-info-label {
            font-size: 12px;
            color: #718096;
            margin-bottom: 5px;
        }

        .match-info-value {
            font-weight: bold;
            color: #1d3557;
        }

        .ticket-details {
            padding: 20px;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            border-bottom: 1px dashed #e2e8f0;
        }

        .ticket-detail-item {
            width: 30%;
            margin-bottom: 15px;
        }

        .ticket-detail-label {
            font-size: 12px;
            color: #718096;
            margin-bottom: 5px;
        }

        .ticket-detail-value {
            font-weight: bold;
            font-size: 16px;
            color: #1d3557;
        }

        .qr-section {
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .qr-code {
            width: 120px;
            height: 120px;
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .ticket-instructions {
            width: 65%;
        }

        .instructions-title {
            font-weight: bold;
            margin-bottom: 10px;
            color: #1d3557;
        }

        .instructions-text {
            font-size: 12px;
            color: #718096;
        }

        .ticket-footer {
            background-color: #f8fafc;
            padding: 15px 20px;
            text-align: center;
            font-size: 12px;
            color: #718096;
            border-top: 1px solid #e2e8f0;
        }

        .tear-line {
            border-top: 2px dashed #e2e8f0;
            margin: 0;
            position: relative;
        }

        .tear-icon {
            position: absolute;
            top: -10px;
            left: 50%;
            transform: translateX(-50%);
            background-color: white;
            padding: 0 10px;
            color: #a0aec0;
            font-size: 12px;
        }

        .stub {
            padding: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .stub-title {
            font-weight: bold;
            font-size: 14px;
            color: #1d3557;
        }

        .stub-details {
            font-size: 12px;
            color: #718096;
        }

        .barcode {
            height: 40px;
            width: 60%;
            background-image: url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAZAAAABkCAYAAACoy2Z3AAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyJpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuMy1jMDExIDY2LjE0NTY2MSwgMjAxMi8wMi8wNi0xNDo1NjoyNyAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENTNiAoV2luZG93cykiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6QzJCOTY3N0NFM0FCMTFFQTk0QkFBRDYwNzMyNjdBMEEiIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6QzJCOTY3N0RFM0FCMTFFQTk0QkFBRDYwNzMyNjdBMEEiPiA8eG1wTU06RGVyaXZlZEZyb20gc3RSZWY6aW5zdGFuY2VJRD0ieG1wLmlpZDpDMkI5Njc3QUUzQUIxMUVBOTRCQUFENjA3MzI2N0EwQSIgc3RSZWY6ZG9jdW1lbnRJRD0ieG1wLmRpZDpDMkI5Njc3QkUzQUIxMUVBOTRCQUFENjA3MzI2N0EwQSIvPiA8L3JkZjpEZXNjcmlwdGlvbj4gPC9yZGY6UkRGPiA8L3g6eG1wbWV0YT4gPD94cGFja2V0IGVuZD0iciI/PnH/10gAAAGzSURBVHja7NsxS8NAGMDxXJcKDg5uujiIOGRwEjfBD+Dn0sHRQRAnwUUQHBxcnBycFAQnQQQXl053wUHasQ7SJjkTWlsKFSl/+P/hRZqkuTRvuFxeX0qSJAEAVFUWIQAQEAAICAAEBAACAgABAYCAAEBAACAg+TRN0/LtV5ZlxXsA/kJA0jQtHh4eOp1OZ9jtdh+TJEkRE4D/EJDRaFTc3d3NHx8fZ7e3t0vn5+drjUZjgpgA1B2QJEkqNzc3C/1+f+n6+nrj9PR0dWlpaZaYANQZkDzPK71eb/n8/Hx9MBhsHh0drS8uLs4RE4C6ApJlWWU4HC4cHBxsXV1dbR8eHm4sLCzMExOAOgIyHo8rNzc3S/v7+9uDwWDn4OBgs9lsThETgKoDkud55ebmZnlvb2+n3+/v7u7ubjWbzWliAlBlQMbjcfH29jZ7fHy8c3l5ubu9vb3darWmiQlAVQEpv3ZcPD8/z11cXOycnJzstdvtGWICUFVAJt6/dkwdHx/vr6+vf3ztAICAAEBAACAg+fQhwADMCwEaOEHu9QAAAABJRU5ErkJggg==');
            background-repeat: no-repeat;
            background-size: contain;
            margin: 0 auto;
        }

        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 100px;
            color: rgba(226, 232, 240, 0.5);
            font-weight: bold;
            z-index: -1;
            white-space: nowrap;
        }

        .highlight {
            color: #e63946;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }
    </style>
</head>

<body>
    <div class="ticket-container">
        <div class="watermark">WORLD CUP 2030</div>

        <div class="ticket">
            <!-- Ticket Header -->
            <div class="ticket-header">
                <img src="{{ public_path('images/logo.png') }}" alt="World Cup 2030" class="logo">
                <h1 class="ticket-title">WORLD CUP 2030</h1>
                <p class="ticket-subtitle">OFFICIAL MATCH TICKET</p>
                <div class="ticket-number">TICKET #{{ $ticket->id }}</div>
            </div>

            <!-- Match Details -->
            <div class="match-details">
                <div class="teams">
                    <div class="team">
                        <img src="{{ public_path($ticket->game->homeTeam->flag) }}"
                            alt="{{ $ticket->game->homeTeam->name }}" class="team-flag">
                        <div class="team-name">{{ $ticket->game->homeTeam->name }}</div>
                    </div>
                    <div class="versus">VS</div>
                    <div class="team">
                        <img src="{{ public_path($ticket->game->awayTeam->flag) }}"
                            alt="{{ $ticket->game->awayTeam->name }}" class="team-flag">
                        <div class="team-name">{{ $ticket->game->awayTeam->name }}</div>
                    </div>
                </div>

                <div class="match-info">
                    <div class="match-info-item">
                        <div class="match-info-label">DATE</div>
                        <div class="match-info-value">
                            {{ \Carbon\Carbon::parse($ticket->game->start_date)->format('d M Y') }}</div>
                    </div>
                    <div class="match-info-item">
                        <div class="match-info-label">TIME</div>
                        <div class="match-info-value">{{ $ticket->game->start_hour }}</div>
                    </div>
                    <div class="match-info-item">
                        <div class="match-info-label">MATCH ID</div>
                        <div class="match-info-value">{{ $ticket->game_id }}</div>
                    </div>
                    <div class="match-info-item">
                        <div class="match-info-label">STADIUM</div>
                        <div class="match-info-value">{{ $ticket->game->stadium->name }}</div>
                    </div>
                    <div class="match-info-item">
                        <div class="match-info-label">CITY</div>
                        <div class="match-info-value">{{ $ticket->game->stadium->city }}</div>
                    </div>
                    <div class="match-info-item">
                        <div class="match-info-label">GATES OPEN</div>
                        <div class="match-info-value">
                            {{ \Carbon\Carbon::parse($ticket->game->start_hour)->subHours(2)->format('H:i') }}</div>
                    </div>
                </div>
            </div>

            <!-- Ticket Details -->
            <div class="ticket-details">
                <div class="ticket-detail-item">
                    <div class="ticket-detail-label">SECTION</div>
                    <div class="ticket-detail-value highlight">{{ $ticket->section }}</div>
                </div>
                <div class="ticket-detail-item">
                    <div class="ticket-detail-label">SEAT NUMBER</div>
                    <div class="ticket-detail-value highlight">{{ $ticket->place_number }}</div>
                </div>
                <div class="ticket-detail-item">
                    <div class="ticket-detail-label">PRICE</div>
                    <div class="ticket-detail-value">{{ number_format($ticket->price, 2) }} $</div>
                </div>
                <div class="ticket-detail-item">
                    <div class="ticket-detail-label">STATUS</div>
                    <div class="ticket-detail-value">{{ ucfirst($ticket->status) }}</div>
                </div>
                <div class="ticket-detail-item">
                    <div class="ticket-detail-label">PURCHASE DATE</div>
                    <div class="ticket-detail-value">{{ $ticket->created_at->format('d/m/Y') }}</div>
                </div>
                <div class="ticket-detail-item">
                    <div class="ticket-detail-label">TICKET HOLDER</div>
                    <div class="ticket-detail-value">{{ $ticket->user->name }}</div>
                </div>
            </div>

            <!-- QR Code Section -->
            <div class="qr-section">
                <div class="qr-code">
                    {!! QrCode::size(120)->generate(route('tickets.verify', $ticket->id)) !!}
                </div>
                <div class="ticket-instructions">
                    <div class="instructions-title">IMPORTANT INFORMATION</div>
                    <div class="instructions-text">
                        <p>This ticket is valid only with a valid ID matching the purchaser's name. Please arrive at
                            least 90 minutes before kick-off. Gates open 2 hours before the match.</p>
                        <p>This ticket cannot be duplicated, transferred or resold without authorization. Violation may
                            result in refusal of entry.</p>
                    </div>
                </div>
            </div>

            <!-- Tear Line -->
            <div class="tear-line">
                <div class="tear-icon">✂ - - - - - - - - - - - - - - - -</div>
            </div>

            <!-- Stub Section -->
            <div class="stub">
                <div>
                    <div class="stub-title">{{ $ticket->game->homeTeam->name }} vs {{ $ticket->game->awayTeam->name }}
                    </div>
                    <div class="stub-details">
                        {{ \Carbon\Carbon::parse($ticket->game->start_date)->format('d M Y') }} |
                        {{ $ticket->game->start_hour }}
                    </div>
                    <div class="stub-details">
                        Section: {{ $ticket->section }} | Seat: {{ $ticket->place_number }}
                    </div>
                </div>
                <div class="barcode"></div>
            </div>

            <!-- Ticket Footer -->
            <div class="ticket-footer">
                <p>This ticket is subject to the terms and conditions of World Cup 2030. Unauthorized reproduction is
                    prohibited. This ticket remains the property of World Cup 2030 and must be produced on demand. Entry
                    may be refused if ticket is damaged or defaced.</p>
                <p>&copy; {{ date('Y') }} World Cup 2030. All rights reserved.</p>
            </div>
        </div>
    </div>
</body>

</html>
