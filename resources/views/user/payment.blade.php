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

        .progress-step.completed .step-number::after {
            content: '\f00c';
            font-family: 'Font Awesome 5 Free';
            font-weight: 900;
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

        .card-number-wrapper {
            position: relative;
        }

        .card-type-icon {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 1.5rem;
            color: var(--gray-600);
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
    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <h1>Secure Checkout</h1>
            <ul class="breadcrumb">
                <li><a href="#">Home</a></li>
                <li><a href="#">Matches</a></li>
                <li><a href="#">Tickets</a></li>
                <li><a href="#">Seat Selection</a></li>
                <li><a href="#">Payment</a></li>
            </ul>
        </div>
    </section>

    <!-- Main Content -->
    <main class="container">
        <!-- Checkout Progress -->
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

        <!-- Checkout Container -->
        <div class="checkout-container">
            <!-- Payment Form -->
            <div class="payment-form-container">
                <form class="payment-form" id="payment-form">
                    <!-- Payment Methods -->
                    <div class="form-section">
                        <h3 class="form-section-title">
                            <i class="fas fa-credit-card"></i> Payment Method
                        </h3>
                        <div class="payment-methods">
                            <div class="payment-method">
                                <input type="radio" name="payment_method" id="credit-card" value="credit-card"
                                    class="payment-method-input" checked>
                                <label for="credit-card" class="payment-method-label">
                                    <i class="far fa-credit-card payment-method-icon"></i>
                                    <span class="payment-method-name">Credit Card</span>
                                </label>
                            </div>
                            <div class="payment-method">
                                <input type="radio" name="payment_method" id="paypal" value="paypal"
                                    class="payment-method-input">
                                <label for="paypal" class="payment-method-label">
                                    <i class="fab fa-paypal payment-method-icon"></i>
                                    <span class="payment-method-name">PayPal</span>
                                </label>
                            </div>
                            <div class="payment-method">
                                <input type="radio" name="payment_method" id="apple-pay" value="apple-pay"
                                    class="payment-method-input">
                                <label for="apple-pay" class="payment-method-label">
                                    <i class="fab fa-apple-pay payment-method-icon"></i>
                                    <span class="payment-method-name">Apple Pay</span>
                                </label>
                            </div>
                            <div class="payment-method">
                                <input type="radio" name="payment_method" id="google-pay" value="google-pay"
                                    class="payment-method-input">
                                <label for="google-pay" class="payment-method-label">
                                    <i class="fab fa-google-pay payment-method-icon"></i>
                                    <span class="payment-method-name">Google Pay</span>
                                </label>
                            </div>
                        </div>

                        <!-- Credit Card Form -->
                        <div class="credit-card-form" id="credit-card-form">
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="card-number" class="form-label">Card Number</label>
                                    <div class="card-number-wrapper">
                                        <input type="text" id="card-number" class="form-control"
                                            placeholder="1234 5678 9012 3456" maxlength="19">
                                        <i class="fab fa-cc-visa card-type-icon" id="card-type-icon"></i>
                                    </div>
                                    <div class="invalid-feedback">Please enter a valid card number</div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-half">
                                    <label for="card-name" class="form-label">Cardholder Name</label>
                                    <input type="text" id="card-name" class="form-control" placeholder="John Doe">
                                    <div class="invalid-feedback">Please enter the cardholder name</div>
                                </div>
                                <div class="form-group col-half">
                                    <label for="expiry-date" class="form-label">Expiry Date</label>
                                    <input type="text" id="expiry-date" class="form-control" placeholder="MM/YY"
                                        maxlength="5">
                                    <div class="invalid-feedback">Please enter a valid expiry date</div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-third">
                                    <label for="cvv" class="form-label">CVV</label>
                                    <input type="text" id="cvv" class="form-control" placeholder="123"
                                        maxlength="4">
                                    <div class="invalid-feedback">Please enter a valid CVV</div>
                                </div>
                                <div class="form-group col-third">
                                    <label for="postal-code" class="form-label">Postal Code</label>
                                    <input type="text" id="postal-code" class="form-control" placeholder="12345">
                                    <div class="invalid-feedback">Please enter your postal code</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Billing Information -->
                    <div class="form-section">
                        <h3 class="form-section-title">
                            <i class="fas fa-file-invoice"></i> Billing Information
                        </h3>
                        <div class="form-row">
                            <div class="form-group col-half">
                                <label for="first-name" class="form-label">First Name</label>
                                <input type="text" id="first-name" class="form-control" placeholder="John">
                                <div class="invalid-feedback">Please enter your first name</div>
                            </div>
                            <div class="form-group col-half">
                                <label for="last-name" class="form-label">Last Name</label>
                                <input type="text" id="last-name" class="form-control" placeholder="Doe">
                                <div class="invalid-feedback">Please enter your last name</div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" id="email" class="form-control"
                                    placeholder="john.doe@example.com">
                                <div class="invalid-feedback">Please enter a valid email address</div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="address" class="form-label">Address</label>
                                <input type="text" id="address" class="form-control" placeholder="123 Main St">
                                <div class="invalid-feedback">Please enter your address</div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-half">
                                <label for="city" class="form-label">City</label>
                                <input type="text" id="city" class="form-control" placeholder="New York">
                                <div class="invalid-feedback">Please enter your city</div>
                            </div>
                            <div class="form-group col-half">
                                <label for="country" class="form-label">Country</label>
                                <select id="country" class="form-control">
                                    <option value="">Select Country</option>
                                    <option value="US">United States</option>
                                    <option value="CA">Canada</option>
                                    <option value="UK">United Kingdom</option>
                                    <option value="AU">Australia</option>
                                    <option value="FR">France</option>
                                    <option value="DE">Germany</option>
                                    <option value="BR">Brazil</option>
                                    <option value="JP">Japan</option>
                                </select>
                                <div class="invalid-feedback">Please select your country</div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-half">
                                <label for="state" class="form-label">State/Province</label>
                                <input type="text" id="state" class="form-control" placeholder="NY">
                                <div class="invalid-feedback">Please enter your state/province</div>
                            </div>
                            <div class="form-group col-half">
                                <label for="zip" class="form-label">ZIP/Postal Code</label>
                                <input type="text" id="zip" class="form-control" placeholder="10001">
                                <div class="invalid-feedback">Please enter your ZIP/postal code</div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="phone" class="form-label">Phone Number</label>
                                <input type="tel" id="phone" class="form-control"
                                    placeholder="+1 (123) 456-7890">
                                <div class="invalid-feedback">Please enter a valid phone number</div>
                            </div>
                        </div>
                    </div>

                    <!-- Terms and Conditions -->
                    <div class="form-section">
                        <div class="terms-checkbox">
                            <input type="checkbox" id="terms" required>
                            <label for="terms">
                                I agree to the <a href="#" target="_blank">Terms and Conditions</a>, <a
                                    href="#" target="_blank">Privacy Policy</a>, and <a href="#"
                                    target="_blank">Refund Policy</a>. I understand that my personal information will be
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

            <!-- Order Summary -->
            <div class="order-summary-container">
                <div class="order-summary">
                    <h3 class="order-summary-title">Order Summary</h3>

                    <div class="match-info-card">
                        <div class="match-teams">
                            <div class="match-team">
                                <div class="team-flag"
                                    style="background-image: url('https://via.placeholder.com/60x40/3498db/ffffff?text=BRA')">
                                </div>
                                <div class="team-name">Brazil</div>
                            </div>
                            <div class="match-vs">VS</div>
                            <div class="match-team">
                                <div class="team-flag"
                                    style="background-image: url('https://via.placeholder.com/60x40/e74c3c/ffffff?text=FRA')">
                                </div>
                                <div class="team-name">France</div>
                            </div>
                        </div>
                        <div class="match-details">
                            <div class="match-details-item">
                                <i class="far fa-calendar-alt"></i>
                                <span>June 15, 2030</span>
                            </div>
                            <div class="match-details-item">
                                <i class="far fa-clock"></i>
                                <span>18:00 GMT</span>
                            </div>
                            <div class="match-details-item">
                                <i class="fas fa-map-marker-alt"></i>
                                <span>Rio Stadium, Brazil</span>
                            </div>
                        </div>
                    </div>

                    <div class="tickets-list">
                        <div class="ticket-item">
                            <div class="ticket-info">
                                <div class="ticket-section">North Stand, Category 1</div>
                                <div class="ticket-seat">Row 12, Seat 5</div>
                            </div>
                            <div class="ticket-price">$250.00</div>
                        </div>
                        <div class="ticket-item">
                            <div class="ticket-info">
                                <div class="ticket-section">North Stand, Category 1</div>
                                <div class="ticket-seat">Row 12, Seat 6</div>
                            </div>
                            <div class="ticket-price">$250.00</div>
                        </div>
                    </div>

                    <div class="promo-code">
                        <h4 class="promo-code-title">Promo Code</h4>
                        <div class="promo-code-form">
                            <input type="text" class="promo-code-input" placeholder="Enter promo code">
                            <button class="promo-code-btn">Apply</button>
                        </div>
                    </div>

                    <div class="order-totals">
                        <div class="order-total-item">
                            <div class="order-total-label">Subtotal</div>
                            <div class="order-total-value">$500.00</div>
                        </div>
                        <div class="order-total-item">
                            <div class="order-total-label">Service Fee</div>
                            <div class="order-total-value">$50.00</div>
                        </div>
                        <div class="order-total-item">
                            <div class="order-total-label">Tax</div>
                            <div class="order-total-value">$25.00</div>
                        </div>
                        <div class="order-final-total">
                            <div class="order-final-label">Total</div>
                            <div class="order-final-value">$575.00</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Payment Success Modal -->
    <div class="modal" id="success-modal">
        <div class="modal-content">
            <i class="fas fa-check-circle success-icon"></i>
            <h2 class="modal-title">Payment Successful!</h2>
            <p class="modal-text">
                Thank you for your purchase. Your tickets have been confirmed and will be sent to your email shortly.
            </p>
            <div class="modal-actions">
                <a href="#" class="btn btn-success">View My Tickets</a>
                <a href="#" class="btn btn-outline">Back to Home</a>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <!-- JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Mobile menu toggle
            const mobileMenuBtn = document.querySelector('.mobile-menu');
            const navLinks = document.querySelector('.nav-links');

            if (mobileMenuBtn) {
                mobileMenuBtn.addEventListener('click', function() {
                    navLinks.classList.toggle('active');
                });
            }

            // Payment method toggle
            const paymentMethods = document.querySelectorAll('input[name="payment_method"]');
            const creditCardForm = document.getElementById('credit-card-form');

            paymentMethods.forEach(method => {
                method.addEventListener('change', function() {
                    if (this.value === 'credit-card') {
                        creditCardForm.style.display = 'block';
                    } else {
                        creditCardForm.style.display = 'none';
                    }
                });
            });

            // Credit card number formatting
            const cardNumberInput = document.getElementById('card-number');
            const cardTypeIcon = document.getElementById('card-type-icon');

            if (cardNumberInput) {
                cardNumberInput.addEventListener('input', function(e) {
                    // Remove non-digit characters
                    let value = this.value.replace(/\D/g, '');

                    // Add spaces after every 4 digits
                    value = value.replace(/(\d{4})(?=\d)/g, '$1 ');

                    // Update input value
                    this.value = value;

                    // Detect card type
                    const firstDigit = value.charAt(0);
                    const firstTwoDigits = value.substring(0, 2);

                    if (value.startsWith('4')) {
                        cardTypeIcon.className = 'fab fa-cc-visa card-type-icon';
                    } else if (value.startsWith('5')) {
                        cardTypeIcon.className = 'fab fa-cc-mastercard card-type-icon';
                    } else if (value.startsWith('3')) {
                        cardTypeIcon.className = 'fab fa-cc-amex card-type-icon';
                    } else if (value.startsWith('6')) {
                        cardTypeIcon.className = 'fab fa-cc-discover card-type-icon';
                    } else {
                        cardTypeIcon.className = 'far fa-credit-card card-type-icon';
                    }
                });
            }

            // Expiry date formatting
            const expiryDateInput = document.getElementById('expiry-date');

            if (expiryDateInput) {
                expiryDateInput.addEventListener('input', function(e) {
                    // Remove non-digit characters
                    let value = this.value.replace(/\D/g, '');

                    // Add slash after month
                    if (value.length > 2) {
                        value = value.substring(0, 2) + '/' + value.substring(2);
                    }

                    // Update input value
                    this.value = value;
                });
            }

            // Form validation
            const paymentForm = document.getElementById('payment-form');

            if (paymentForm) {
                paymentForm.addEventListener('submit', function(e) {
                    e.preventDefault();

                    // Simple validation
                    let isValid = true;

                    // Validate required fields
                    const requiredFields = [
                        'card-number', 'card-name', 'expiry-date', 'cvv',
                        'first-name', 'last-name', 'email', 'address',
                        'city', 'country', 'state', 'zip', 'phone'
                    ];

                    requiredFields.forEach(field => {
                        const input = document.getElementById(field);
                        if (input && !input.value.trim()) {
                            input.classList.add('is-invalid');
                            isValid = false;
                        } else if (input) {
                            input.classList.remove('is-invalid');
                        }
                    });

                    // Validate terms checkbox
                    const termsCheckbox = document.getElementById('terms');
                    if (termsCheckbox && !termsCheckbox.checked) {
                        isValid = false;
                        alert('Please agree to the Terms and Conditions');
                    }

                    // If form is valid, show success modal
                    if (isValid) {
                        const successModal = document.getElementById('success-modal');
                        if (successModal) {
                            successModal.classList.add('show');
                        }
                    }
                });
            }

            // Close modal when clicking outside
            const modal = document.getElementById('success-modal');

            if (modal) {
                window.addEventListener('click', function(e) {
                    if (e.target === modal) {
                        modal.classList.remove('show');
                    }
                });
            }
        });
    </script>
@endsection
