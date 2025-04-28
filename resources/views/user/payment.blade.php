@extends('user.layout')

@section('title', 'Payment - World Cup 2030')

@section('css')
    <style>
        /* Checkout Progress */
        .checkout-progress {
            display: flex;
            justify-content: space-between;
            margin-bottom: 40px;
            position: relative;
        }

        .checkout-progress::before {
            content: '';
            position: absolute;
            top: 15px;
            left: 0;
            width: 100%;
            height: 2px;
            background-color: var(--gray-300);
            z-index: 1;
        }

        .progress-step {
            position: relative;
            z-index: 2;
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 33.333%;
        }

        .step-number {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background-color: var(--gray-300);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .progress-step.active .step-number {
            background-color: var(--primary);
        }

        .progress-step.completed .step-number {
            background-color: var(--success);
        }

        .step-label {
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--gray-600);
        }

        .progress-step.active .step-label {
            color: var(--primary);
        }

        .progress-step.completed .step-label {
            color: var(--success);
        }

        /* Checkout Container */
        .checkout-container {
            display: flex;
            flex-wrap: wrap;
            gap: 30px;
            margin-bottom: 60px;
        }

        /* Payment Form */
        .payment-form-container {
            flex: 2;
            min-width: 300px;
        }

        .payment-form {
            background-color: white;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .form-section {
            margin-bottom: 30px;
        }

        .form-section:last-child {
            margin-bottom: 0;
        }

        .form-section-title {
            font-size: 1.2rem;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid var(--gray-300);
            display: flex;
            align-items: center;
        }

        .form-section-title i {
            margin-right: 10px;
            color: var(--primary);
        }

        .form-row {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin-bottom: 20px;
        }

        .form-row:last-child {
            margin-bottom: 0;
        }

        .form-group {
            flex: 1;
            min-width: 200px;
        }

        .form-group.col-half {
            flex: 0 0 calc(50% - 10px);
            min-width: 150px;
        }

        .form-group.col-third {
            flex: 0 0 calc(33.333% - 14px);
            min-width: 100px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            font-size: 0.9rem;
        }

        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid var(--gray-300);
            border-radius: 4px;
            font-family: 'Poppins', sans-serif;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(230, 57, 70, 0.1);
        }

        .form-control.is-invalid {
            border-color: var(--danger);
        }

        .invalid-feedback {
            display: none;
            color: var(--danger);
            font-size: 0.8rem;
            margin-top: 5px;
        }

        .is-invalid~.invalid-feedback {
            display: block;
        }

        /* Payment Methods */
        .payment-methods {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-bottom: 20px;
        }

        .payment-method {
            flex: 1;
            min-width: 120px;
        }

        .payment-method-input {
            display: none;
        }

        .payment-method-label {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 15px;
            border: 1px solid var(--gray-300);
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .payment-method-label:hover {
            border-color: var(--primary);
            background-color: var(--light);
        }

        .payment-method-input:checked+.payment-method-label {
            border-color: var(--primary);
            background-color: var(--light);
        }

        .payment-method-icon {
            font-size: 2rem;
            margin-bottom: 10px;
            color: var(--gray-700);
        }

        .payment-method-input:checked+.payment-method-label .payment-method-icon {
            color: var(--primary);
        }

        .payment-method-name {
            font-size: 0.9rem;
            font-weight: 600;
        }

        /* Credit Card Form */
        .credit-card-form {
            margin-top: 20px;
        }

        .card-icon {
            margin-left: 10px;
            font-size: 1.5rem;
            color: var(--gray-600);
        }

        /* Stripe Elements */
        .stripe-element {
            padding: 12px 15px;
            border: 1px solid var(--gray-300);
            border-radius: 4px;
            background-color: white;
            transition: all 0.3s ease;
        }

        .stripe-element.focused {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(230, 57, 70, 0.1);
        }

        .stripe-element.invalid {
            border-color: var(--danger);
        }

        #card-errors {
            color: var(--danger);
            font-size: 0.8rem;
            margin-top: 5px;
        }

        /* Terms and Conditions */
        .terms-checkbox {
            display: flex;
            align-items: flex-start;
            margin-bottom: 20px;
        }

        .terms-checkbox input {
            margin-top: 5px;
            margin-right: 10px;
        }

        .terms-checkbox label {
            font-size: 0.9rem;
            color: var(--gray-700);
        }

        /* Security Info */
        .security-info {
            display: flex;
            align-items: center;
            margin-top: 20px;
            padding: 15px;
            background-color: var(--gray-100);
            border-radius: 4px;
        }

        .security-icon {
            font-size: 2rem;
            color: var(--success);
            margin-right: 15px;
        }

        .security-text {
            font-size: 0.9rem;
            color: var(--gray-700);
        }

        /* Order Summary */
        .order-summary-container {
            flex: 1;
            min-width: 300px;
        }

        .order-summary {
            background-color: white;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            position: sticky;
            top: 100px;
        }

        .order-summary-title {
            font-size: 1.2rem;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid var(--gray-300);
        }

        .match-info-card {
            background-color: var(--gray-100);
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
        }

        .match-teams {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .match-team {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .team-flag {
            width: 40px;
            height: 30px;
            margin-bottom: 5px;
            background-size: cover;
            background-position: center;
            border-radius: 4px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .team-name {
            font-size: 0.9rem;
            font-weight: 600;
        }

        .match-vs {
            font-weight: 700;
            color: var(--gray-600);
        }

        .match-details {
            font-size: 0.9rem;
            color: var(--gray-700);
        }

        .match-details-item {
            display: flex;
            align-items: center;
            margin-bottom: 5px;
        }

        .match-details-item:last-child {
            margin-bottom: 0;
        }

        .match-details-item i {
            width: 20px;
            margin-right: 10px;
            color: var(--primary);
        }

        .tickets-list {
            margin-bottom: 20px;
        }

        .ticket-item {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid var(--gray-200);
        }

        .ticket-item:last-child {
            border-bottom: none;
        }

        .ticket-info {
            flex: 1;
        }

        .ticket-section {
            font-weight: 600;
            margin-bottom: 3px;
        }

        .ticket-seat {
            font-size: 0.8rem;
            color: var(--gray-600);
        }

        .ticket-price {
            font-weight: 600;
            color: var(--gray-800);
        }

        .order-totals {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid var(--gray-300);
        }

        .order-total-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .order-total-label {
            color: var(--gray-700);
        }

        .order-total-value {
            font-weight: 600;
        }

        .order-final-total {
            display: flex;
            justify-content: space-between;
            padding-top: 10px;
            margin-top: 10px;
            border-top: 1px solid var(--gray-300);
            font-size: 1.1rem;
        }

        .order-final-label {
            font-weight: 600;
        }

        .order-final-value {
            font-weight: 700;
            color: var(--primary);
        }

        .promo-code {
            margin-top: 20px;
        }

        .promo-code-title {
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .promo-code-form {
            display: flex;
        }

        .promo-code-input {
            flex: 1;
            padding: 10px 15px;
            border: 1px solid var(--gray-300);
            border-right: none;
            border-radius: 4px 0 0 4px;
            font-family: 'Poppins', sans-serif;
            font-size: 0.9rem;
        }

        .promo-code-input:focus {
            outline: none;
            border-color: var(--primary);
        }

        .promo-code-btn {
            padding: 10px 15px;
            background-color: var(--secondary);
            color: white;
            border: none;
            border-radius: 0 4px 4px 0;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .promo-code-btn:hover {
            background-color: #152a45;
        }

        /* Payment Success Modal */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }

        .modal.show {
            display: flex;
        }

        .modal-content {
            background-color: white;
            border-radius: 8px;
            padding: 30px;
            max-width: 500px;
            width: 90%;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            animation: modalFadeIn 0.3s ease;
        }

        @keyframes modalFadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .success-icon {
            font-size: 4rem;
            color: var(--success);
            margin-bottom: 20px;
        }

        .modal-title {
            font-size: 1.5rem;
            margin-bottom: 15px;
        }

        .modal-text {
            margin-bottom: 30px;
            color: var(--gray-700);
        }

        .modal-actions {
            display: flex;
            justify-content: center;
            gap: 15px;
        }

        /* Loading Spinner */
        .spinner-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }

        .spinner-overlay.show {
            display: flex;
        }

        .spinner {
            width: 50px;
            height: 50px;
            border: 5px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: var(--primary);
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        /* Responsive Styles */
        @media (max-width: 992px) {
            .checkout-container {
                flex-direction: column-reverse;
            }

            .order-summary {
                position: static;
                margin-bottom: 30px;
            }
        }

        @media (max-width: 768px) {
            .nav-links {
                display: none;
            }

            .mobile-menu {
                display: block;
            }

            .page-header h1 {
                font-size: 2rem;
            }

            .checkout-progress {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }

            .checkout-progress::before {
                display: none;
            }

            .progress-step {
                width: 100%;
                flex-direction: row;
                gap: 15px;
            }

            .payment-methods {
                flex-direction: column;
            }

            .payment-method {
                width: 100%;
            }

            .payment-method-label {
                flex-direction: row;
                justify-content: flex-start;
                gap: 15px;
            }

            .payment-method-icon {
                margin-bottom: 0;
            }
        }

        @media (max-width: 576px) {
            .form-row {
                flex-direction: column;
                gap: 15px;
            }

            .form-group.col-half,
            .form-group.col-third {
                flex: 1;
                width: 100%;
            }

            .match-teams {
                flex-direction: column;
                gap: 15px;
            }

            .match-vs {
                margin: 10px 0;
            }
        }
    </style>
@endsection

@section('content')
    <section class="page-header">
        <div class="container">
            <h1>Secure Checkout</h1>
            <ul class="breadcrumb">
                <li><a href="{{ url('/') }}">Home</a></li>
                <li><a href="{{ route('games') }}">Matches</a></li>
                <li>Payment</li>
            </ul>
        </div>
    </section>

    <main class="container">

        <div class="checkout-progress">
            <div class="progress-step completed">
                <div class="step-number">1</div>
                <div class="step-label">Select Tickets</div>
            </div>
            <div class="progress-step completed">
                <div class="step-number">2</div>
                <div class="step-label">Choose Seats</div>
            </div>
            <div class="progress-step active">
                <div class="step-number">3</div>
                <div class="step-label">Payment</div>
            </div>
        </div>

        <div class="checkout-container">

            <div class="payment-form-container">
                <form class="payment-form" id="payment-form" action="{{ route('tickets.process-payment') }}" method="POST">
                    @csrf
                    <input type="hidden" name="ticket_ids" value="{{ implode(',', $tickets->pluck('id')->toArray()) }}">
                    <input type="hidden" name="payment_intent_id" id="payment_intent_id">
                    <input type="hidden" name="payment_method_id" id="payment_method_id">

                    <div class="form-section">
                        <h3 class="form-section-title">
                            <i class="fas fa-credit-card"></i> Payment Method
                        </h3>

                        <div class="credit-card-form">
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="card-element" class="form-label">Credit or Debit Card</label>
                                    <div id="card-element" class="stripe-element">
                                        <!-- Stripe Card Element will be inserted here -->
                                    </div>
                                    <div id="card-errors" role="alert"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-section">

                        <h3 class="form-section-title">
                            <i class="fas fa-file-invoice"></i> Billing Information
                        </h3>

                        <div class="form-row">
                            <div class="form-group col-half">
                                <label for="first-name" class="form-label">First Name</label>
                                <input type="text" id="first-name" name="first_name" class="form-control"
                                    placeholder="John" required value="{{ auth()->user()->firstname ?? '' }}">
                            </div>
                            <div class="form-group col-half">
                                <label for="last-name" class="form-label">Last Name</label>
                                <input type="text" id="last-name" name="last_name" class="form-control" placeholder="Doe"
                                    required value="{{ auth()->user()->lastname ?? '' }}">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" id="email" name="email" class="form-control"
                                    placeholder="john.doe@example.com" required value="{{ auth()->user()->email ?? '' }}">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="phone" class="form-label">Phone Number</label>
                                <input type="tel" id="phone" name="phone" class="form-control"
                                    placeholder="+1 (123) 456-7890" required>
                            </div>

                        </div>
                    </div>

                    <div class="form-section">
                        <div class="terms-checkbox">
                            <input type="checkbox" id="terms" name="terms" required>
                            <label for="terms">
                                I agree to the <a href="#" target="_blank">Terms and Conditions</a>, <a href="#"
                                    target="_blank">Privacy Policy</a>, and <a href="#" target="_blank">Refund
                                    Policy</a>. I understand that my personal information will be
                                processed as described in the Privacy Policy.
                            </label>
                        </div>

                        <div class="security-info">
                            <i class="fas fa-shield-alt security-icon"></i>
                            <div class="security-text">
                                <strong>Secure Payment:</strong> Your payment information is encrypted and secure. We use
                                industry-standard security measures to protect your data.
                            </div>
                        </div>

                        <button type="submit" class="btn btn-lg btn-success btn-block" id="submit-payment">Complete
                            Purchase</button>
                    </div>
                </form>
            </div>

            <div class="order-summary-container">
                <div class="order-summary">
                    <h3 class="order-summary-title">Order Summary</h3>

                    @if ($tickets->isNotEmpty() && $tickets->first()->game)
                        <div class="match-info-card">
                            <div class="match-teams">

                                <div class="match-team">
                                    <div class="team-flag"
                                        style="background-image: url('{{ $tickets->first()->game->homeTeam->flag ?? 'https://via.placeholder.com/60x40/3498db/ffffff?text=' . substr($tickets->first()->game->homeTeam->name, 0, 3) }}')">
                                    </div>
                                    <div class="team-name">{{ $tickets->first()->game->homeTeam->name }}</div>
                                </div>

                                <div class="match-vs">VS</div>

                                <div class="match-team">
                                    <div class="team-flag"
                                        style="background-image: url('{{ $tickets->first()->game->awayTeam->flag ?? 'https://via.placeholder.com/60x40/e74c3c/ffffff?text=' . substr($tickets->first()->game->awayTeam->name, 0, 3) }}')">
                                    </div>
                                    <div class="team-name">{{ $tickets->first()->game->awayTeam->name }}</div>
                                </div>

                            </div>

                            <div class="match-details">

                                <div class="match-details-item">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>{{ $tickets->first()->game->start_date }}</span>
                                </div>

                                <div class="match-details-item">
                                    <i class="far fa-clock"></i>
                                    <span>{{ $tickets->first()->game->start_hour }}</span>
                                </div>

                                <div class="match-details-item">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <span>{{ $tickets->first()->game->stadium->name }},
                                        {{ $tickets->first()->game->stadium->city }}</span>
                                </div>

                            </div>
                        </div>
                    @endif

                    <div class="tickets-list">
                        @foreach ($tickets as $ticket)
                            <div class="ticket-item">
                                <div class="ticket-info">
                                    <div class="ticket-section">{{ $ticket->section }}</div>
                                    <div class="ticket-seat">Seat {{ $ticket->place_number }}</div>
                                </div>
                                <div class="ticket-price">${{ number_format($ticket->price, 2) }}</div>
                            </div>
                        @endforeach
                    </div>

                    <div class="order-totals">
                        @php
                            $subtotal = $tickets->sum('price');
                            $serviceFee = $subtotal * 0.1;
                            $total = $subtotal + $serviceFee;
                        @endphp
                        <div class="order-total-item">
                            <div class="order-total-label">Subtotal</div>
                            <div class="order-total-value">${{ number_format($subtotal, 2) }}</div>
                        </div>
                        <div class="order-total-item">
                            <div class="order-total-label">Service Fee</div>
                            <div class="order-total-value">${{ number_format($serviceFee, 2) }}</div>
                        </div>
                        <div class="order-final-total">
                            <div class="order-final-label">Total</div>
                            <div class="order-final-value">${{ number_format($total, 2) }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Loading Spinner -->
    <div class="spinner-overlay" id="loading-spinner">
        <div class="spinner"></div>
    </div>
@endsection

@section('js')
    <script src="https://js.stripe.com/v3/"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuBtn = document.querySelector('.mobile-menu');
            const navLinks = document.querySelector('.nav-links');

            if (mobileMenuBtn) {
                mobileMenuBtn.addEventListener('click', function() {
                    navLinks.classList.toggle('active');
                });

            }

            // Initialize Stripe
            const stripe = Stripe('{{ env('STRIPE_KEY') }}');
            const elements = stripe.elements();

            const cardElement = elements.create('card', {
                style: {
                    base: {
                        color: '#32325d',
                        fontFamily: '"Poppins", sans-serif',
                        fontSmoothing: 'antialiased',
                        fontSize: '16px',
                        '::placeholder': {
                            color: '#aab7c4'
                        }
                    },
                    invalid: {
                        color: '#fa755a',
                        iconColor: '#fa755a'
                    }
                }
            });

            cardElement.mount('#card-element');

            // Handle validation errors
            cardElement.addEventListener('change', function(event) {
                const displayError = document.getElementById('card-errors');
                if (event.error) {
                    displayError.textContent = event.error.message;
                } else {
                    displayError.textContent = '';
                }
            });

            // Handle form submission
            const form = document.getElementById('payment-form');
            const submitButton = document.getElementById('submit-payment');
            const loadingSpinner = document.getElementById('loading-spinner');

            form.addEventListener('submit', async function(event) {
                event.preventDefault();

                submitButton.disabled = true;
                loadingSpinner.classList.add('show');

                // Create payment method
                const {
                    paymentMethod,
                    error
                } = await stripe.createPaymentMethod({
                    type: 'card',
                    card: cardElement,
                    billing_details: {
                        name: document.getElementById('first-name').value + ' ' + document
                            .getElementById(
                                'last-name').value,
                        email: document.getElementById('email').value
                    }
                });

                if (error) {
                    const errorElement = document.getElementById('card-errors');
                    errorElement.textContent = error.message;

                    loadingSpinner.classList.remove('show');

                    submitButton.disabled = false;
                } else {
                    document.getElementById('payment_method_id').value = paymentMethod.id;
                    form.submit();
                }
            });
        });
    </script>
@endsection
