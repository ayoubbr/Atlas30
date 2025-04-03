@extends('user.layout')

@section('title', 'Sign In / Register - World Cup 2030')

@section('css')
    <style>
        /* Auth Container */
        .auth-container {
            max-width: 900px;
            margin: 0 auto 60px;
            display: flex;
            flex-wrap: wrap;
            gap: 30px;
        }

        .auth-content {
            flex: 1;
            min-width: 300px;
        }

        .auth-sidebar {
            flex: 0 0 300px;
        }

        /* Auth Tabs */
        .auth-tabs {
            display: flex;
            margin-bottom: 20px;
            border-bottom: 1px solid var(--gray-300);
        }

        .auth-tab {
            padding: 15px 30px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            border-bottom: 2px solid transparent;
            color: var(--gray-600);
        }

        .auth-tab:hover {
            color: var(--primary);
        }

        .auth-tab.active {
            color: var(--primary);
            border-bottom-color: var(--primary);
        }

        /* Auth Forms */
        .auth-form-container {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            padding: 30px;
        }

        .auth-form {
            display: none;
        }

        .auth-form.active {
            display: block;
        }

        .form-title {
            font-size: 1.5rem;
            margin-bottom: 20px;
            text-align: center;
        }

        .form-group {
            margin-bottom: 20px;
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

        .form-text {
            font-size: 0.8rem;
            color: var(--gray-600);
            margin-top: 5px;
        }

        .form-check {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .form-check-input {
            margin-right: 10px;
        }

        .form-check-label {
            font-size: 0.9rem;
            color: var(--gray-700);
        }

        .form-divider {
            display: flex;
            align-items: center;
            margin: 20px 0;
            color: var(--gray-500);
            font-size: 0.9rem;
        }

        .form-divider::before,
        .form-divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background-color: var(--gray-300);
        }

        .form-divider::before {
            margin-right: 15px;
        }

        .form-divider::after {
            margin-left: 15px;
        }

        .form-footer {
            text-align: center;
            margin-top: 20px;
            font-size: 0.9rem;
            color: var(--gray-600);
        }

        /* Password Strength Meter */
        .password-strength {
            margin-top: 10px;
        }

        .strength-meter {
            height: 5px;
            background-color: var(--gray-200);
            border-radius: 3px;
            margin-bottom: 5px;
            overflow: hidden;
        }

        .strength-meter-fill {
            height: 100%;
            width: 0;
            transition: width 0.3s ease;
        }

        .strength-text {
            font-size: 0.8rem;
        }

        .strength-weak .strength-meter-fill {
            width: 25%;
            background-color: var(--danger);
        }

        .strength-medium .strength-meter-fill {
            width: 50%;
            background-color: var(--warning);
        }

        .strength-good .strength-meter-fill {
            width: 75%;
            background-color: var(--info);
        }

        .strength-strong .strength-meter-fill {
            width: 100%;
            background-color: var(--success);
        }

        /* Password Toggle */
        .password-toggle {
            position: relative;
        }

        .password-toggle .form-control {
            padding-right: 40px;
        }

        .toggle-password {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: var(--gray-500);
            transition: all 0.3s ease;
        }

        .toggle-password:hover {
            color: var(--gray-700);
        }

        /* Auth Sidebar */
        .auth-sidebar-content {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            padding: 30px;
            margin-bottom: 30px;
        }

        .sidebar-title {
            font-size: 1.2rem;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid var(--gray-200);
        }

        .benefits-list {
            list-style: none;
            margin-bottom: 20px;
        }

        .benefits-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 15px;
        }

        .benefits-icon {
            color: var(--success);
            margin-right: 10px;
            font-size: 1.1rem;
            margin-top: 2px;
        }

        .benefits-text {
            font-size: 0.9rem;
            color: var(--gray-700);
        }

        .testimonial {
            background-color: var(--light);
            border-radius: 8px;
            padding: 20px;
            margin-top: 20px;
        }

        .testimonial-text {
            font-style: italic;
            margin-bottom: 15px;
            font-size: 0.9rem;
            color: var(--gray-700);
        }

        .testimonial-author {
            display: flex;
            align-items: center;
        }

        .author-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--gray-300);
            overflow: hidden;
            margin-right: 10px;
        }

        .author-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .author-info {
            font-size: 0.9rem;
        }

        .author-name {
            font-weight: 600;
            color: var(--gray-800);
        }

        .author-role {
            font-size: 0.8rem;
            color: var(--gray-600);
        }

        /* Alert Messages */
        .alert {
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 20px;
            display: flex;
            align-items: flex-start;
        }

        .alert-icon {
            margin-right: 10px;
            font-size: 1.1rem;
        }

        .alert-content {
            flex: 1;
        }

        .alert-title {
            font-weight: 600;
            margin-bottom: 5px;
        }

        .alert-text {
            font-size: 0.9rem;
        }

        .alert-success {
            background-color: rgba(46, 204, 113, 0.1);
            border: 1px solid rgba(46, 204, 113, 0.2);
            color: var(--success);
        }

        .alert-danger {
            background-color: rgba(231, 76, 60, 0.1);
            border: 1px solid rgba(231, 76, 60, 0.2);
            color: var(--danger);
        }

        .alert-info {
            background-color: rgba(52, 152, 219, 0.1);
            border: 1px solid rgba(52, 152, 219, 0.2);
            color: var(--info);
        }

        /* Responsive Styles */
        @media (max-width: 992px) {
            .auth-container {
                flex-direction: column;
            }

            .auth-sidebar {
                flex: 1;
                width: 100%;
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

            .auth-tabs {
                flex-direction: column;
                border-bottom: none;
            }

            .auth-tab {
                border: 1px solid var(--gray-300);
                border-radius: 4px;
                margin-bottom: 10px;
                text-align: center;
            }

            .auth-tab.active {
                border-color: var(--primary);
                background-color: var(--light);
            }
        }

        @media (max-width: 576px) {
            .auth-form-container {
                padding: 20px;
            }

            .form-title {
                font-size: 1.3rem;
            }
        }
    </style>
@endsection

@section('content')
    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <h1>Join Our Community</h1>
            <p>Sign in or create an account to participate in discussions, purchase tickets, and connect with football
                fans from around the world.</p>
            <ul class="breadcrumb">
                <li><a href="#">Home</a></li>
                <li><a href="#">Account</a></li>
            </ul>
        </div>
    </section>

    <!-- Main Content -->
    <main class="container">
        <!-- Auth Container -->
        <div class="auth-container">
            <!-- Auth Content -->
            <div class="auth-content">
                <!-- Success Alert (Hidden by default) -->
                <div class="alert alert-success" id="success-alert" style="display: none;">
                    <div class="alert-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="alert-content">
                        <div class="alert-title">Success!</div>
                        <div class="alert-text">Your account has been created successfully. You can now log in.</div>
                    </div>
                </div>

                <!-- Error Alert (Hidden by default) -->
                <div class="alert alert-danger" id="error-alert" style="display: none;">
                    <div class="alert-icon">
                        <i class="fas fa-exclamation-circle"></i>
                    </div>
                    <div class="alert-content">
                        <div class="alert-title">Error!</div>
                        <div class="alert-text">There was a problem with your submission. Please check your information
                            and try again.</div>
                    </div>
                </div>

                <!-- Auth Tabs -->
                <div class="auth-tabs">
                    <div class="auth-tab active" data-tab="login">Sign In</div>
                    <div class="auth-tab" data-tab="register">Create Account</div>
                </div>

                <!-- Auth Forms Container -->
                <div class="auth-form-container">
                    <!-- Login Form -->
                    <form class="auth-form active" id="login-form">
                        <h2 class="form-title">Sign In to Your Account</h2>

                        <div class="form-group">
                            <label for="login-email" class="form-label">Email Address</label>
                            <input type="email" id="login-email" class="form-control" placeholder="your.email@example.com"
                                required>
                            <div class="invalid-feedback">Please enter a valid email address</div>
                        </div>

                        <div class="form-group">
                            <label for="login-password" class="form-label">Password</label>
                            <div class="password-toggle">
                                <input type="password" id="login-password" class="form-control"
                                    placeholder="Enter your password" required>
                                <i class="far fa-eye toggle-password" data-target="login-password"></i>
                            </div>
                            <div class="invalid-feedback">Please enter your password</div>
                        </div>

                        <div class="form-check">
                            <input type="checkbox" id="remember-me" class="form-check-input">
                            <label for="remember-me" class="form-check-label">Remember me</label>
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg btn-block">Sign In</button>

                        <div class="form-footer">
                            <a href="#" id="forgot-password-link">Forgot your password?</a>
                        </div>

                        <div class="form-divider">or sign in with</div>

                        <div class="social-login">
                            <a href="#" class="btn-social btn-facebook">
                                <i class="fab fa-facebook-f"></i> Facebook
                            </a>
                            <a href="#" class="btn-social btn-google">
                                <i class="fab fa-google"></i> Google
                            </a>
                            <a href="#" class="btn-social btn-twitter">
                                <i class="fab fa-twitter"></i> Twitter
                            </a>
                        </div>
                    </form>

                    <!-- Register Form -->
                    <form class="auth-form" id="register-form">
                        <h2 class="form-title">Create a New Account</h2>

                        <div class="form-group">
                            <label for="register-username" class="form-label">Username</label>
                            <input type="text" id="register-username" class="form-control"
                                placeholder="Choose a username" required>
                            <div class="invalid-feedback">Please choose a username (3-20 characters)</div>
                            <div class="form-text">This will be displayed publicly in the forum</div>
                        </div>

                        <div class="form-group">
                            <label for="register-email" class="form-label">Email Address</label>
                            <input type="email" id="register-email" class="form-control"
                                placeholder="your.email@example.com" required>
                            <div class="invalid-feedback">Please enter a valid email address</div>
                        </div>

                        <div class="form-group">
                            <label for="register-password" class="form-label">Password</label>
                            <div class="password-toggle">
                                <input type="password" id="register-password" class="form-control"
                                    placeholder="Create a password" required>
                                <i class="far fa-eye toggle-password" data-target="register-password"></i>
                            </div>
                            <div class="invalid-feedback">Password must be at least 8 characters</div>

                            <div class="password-strength">
                                <div class="strength-meter">
                                    <div class="strength-meter-fill"></div>
                                </div>
                                <div class="strength-text">Password strength: <span id="strength-value">Type a
                                        password</span></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="register-confirm-password" class="form-label">Confirm Password</label>
                            <div class="password-toggle">
                                <input type="password" id="register-confirm-password" class="form-control"
                                    placeholder="Confirm your password" required>
                                <i class="far fa-eye toggle-password" data-target="register-confirm-password"></i>
                            </div>
                            <div class="invalid-feedback">Passwords do not match</div>
                        </div>

                        <div class="form-check">
                            <input type="checkbox" id="terms-agree" class="form-check-input" required>
                            <label for="terms-agree" class="form-check-label">
                                I agree to the <a href="#" target="_blank">Terms of Service</a> and <a
                                    href="#" target="_blank">Privacy Policy</a>
                            </label>
                        </div>

                        <div class="form-check">
                            <input type="checkbox" id="newsletter-subscribe" class="form-check-input">
                            <label for="newsletter-subscribe" class="form-check-label">
                                Subscribe to our newsletter for updates about matches, tickets, and special offers
                            </label>
                        </div>

                        <button type="submit" class="btn btn-success btn-lg btn-block">Create Account</button>

                        <div class="form-footer">
                            Already have an account? <a href="#" id="login-link">Sign in</a>
                        </div>
                    </form>

                    <!-- Forgot Password Form -->
                    <form class="auth-form" id="forgot-password-form">
                        <h2 class="form-title">Reset Your Password</h2>

                        <div class="alert alert-info">
                            <div class="alert-icon">
                                <i class="fas fa-info-circle"></i>
                            </div>
                            <div class="alert-content">
                                <div class="alert-text">Enter your email address below and we'll send you instructions
                                    to reset your password.</div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="reset-email" class="form-label">Email Address</label>
                            <input type="email" id="reset-email" class="form-control"
                                placeholder="your.email@example.com" required>
                            <div class="invalid-feedback">Please enter a valid email address</div>
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg btn-block">Send Reset Link</button>

                        <div class="form-footer">
                            <a href="#" id="back-to-login">Back to Sign In</a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Auth Sidebar -->
            <div class="auth-sidebar">
                <div class="auth-sidebar-content">
                    <h3 class="sidebar-title">Benefits of Joining</h3>

                    <ul class="benefits-list">
                        <li class="benefits-item">
                            <i class="fas fa-check-circle benefits-icon"></i>
                            <div class="benefits-text">Participate in forum discussions with fans from around the world
                            </div>
                        </li>
                        <li class="benefits-item">
                            <i class="fas fa-check-circle benefits-icon"></i>
                            <div class="benefits-text">Get early access to ticket sales for World Cup matches</div>
                        </li>
                        <li class="benefits-item">
                            <i class="fas fa-check-circle benefits-icon"></i>
                            <div class="benefits-text">Save your favorite teams and matches for quick access</div>
                        </li>
                        <li class="benefits-item">
                            <i class="fas fa-check-circle benefits-icon"></i>
                            <div class="benefits-text">Receive personalized match recommendations</div>
                        </li>
                        <li class="benefits-item">
                            <i class="fas fa-check-circle benefits-icon"></i>
                            <div class="benefits-text">Access exclusive content and behind-the-scenes footage</div>
                        </li>
                    </ul>

                    <div class="testimonial">
                        <div class="testimonial-text">
                            "The World Cup 2030 community has been amazing! I've connected with fans from all over the
                            world and made some great friends. The forum discussions are always insightful and
                            respectful."
                        </div>
                        <div class="testimonial-author">
                            <div class="author-avatar">
                                <img src="https://via.placeholder.com/40x40" alt="User Avatar">
                            </div>
                            <div class="author-info">
                                <div class="author-name">Maria Rodriguez</div>
                                <div class="author-role">Football Fan from Spain</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="auth-sidebar-content">
                    <h3 class="sidebar-title">Need Help?</h3>
                    <p>If you're having trouble signing in or creating an account, please contact our support team:</p>
                    <ul class="benefits-list">
                        <li class="benefits-item">
                            <i class="fas fa-envelope benefits-icon"></i>
                            <div class="benefits-text">support@worldcup2030.com</div>
                        </li>
                        <li class="benefits-item">
                            <i class="fas fa-phone benefits-icon"></i>
                            <div class="benefits-text">+1 (234) 567-8900</div>
                        </li>
                        <li class="benefits-item">
                            <i class="fas fa-comment benefits-icon"></i>
                            <div class="benefits-text">Live chat available 24/7</div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </main>
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

            // Auth tabs functionality
            const authTabs = document.querySelectorAll('.auth-tab');
            const authForms = document.querySelectorAll('.auth-form');

            authTabs.forEach(tab => {
                tab.addEventListener('click', function() {
                    const tabId = this.getAttribute('data-tab');

                    // Update active tab
                    authTabs.forEach(t => t.classList.remove('active'));
                    this.classList.add('active');

                    // Show corresponding form
                    authForms.forEach(form => form.classList.remove('active'));

                    if (tabId === 'login') {
                        document.getElementById('login-form').classList.add('active');
                    } else if (tabId === 'register') {
                        document.getElementById('register-form').classList.add('active');
                    }
                });
            });

            // Forgot password link
            const forgotPasswordLink = document.getElementById('forgot-password-link');
            const backToLoginLink = document.getElementById('back-to-login');
            const loginLink = document.getElementById('login-link');

            if (forgotPasswordLink) {
                forgotPasswordLink.addEventListener('click', function(e) {
                    e.preventDefault();
                    authForms.forEach(form => form.classList.remove('active'));
                    document.getElementById('forgot-password-form').classList.add('active');
                });
            }

            if (backToLoginLink) {
                backToLoginLink.addEventListener('click', function(e) {
                    e.preventDefault();
                    authForms.forEach(form => form.classList.remove('active'));
                    document.getElementById('login-form').classList.add('active');
                });
            }

            if (loginLink) {
                loginLink.addEventListener('click', function(e) {
                    e.preventDefault();
                    authTabs.forEach(t => t.classList.remove('active'));
                    authTabs[0].classList.add('active');
                    authForms.forEach(form => form.classList.remove('active'));
                    document.getElementById('login-form').classList.add('active');
                });
            }

            // Password toggle
            const togglePasswordBtns = document.querySelectorAll('.toggle-password');

            togglePasswordBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    const targetId = this.getAttribute('data-target');
                    const passwordInput = document.getElementById(targetId);

                    if (passwordInput.type === 'password') {
                        passwordInput.type = 'text';
                        this.classList.remove('fa-eye');
                        this.classList.add('fa-eye-slash');
                    } else {
                        passwordInput.type = 'password';
                        this.classList.remove('fa-eye-slash');
                        this.classList.add('fa-eye');
                    }
                });
            });

            // Password strength meter
            const passwordInput = document.getElementById('register-password');
            const strengthMeter = document.querySelector('.strength-meter-fill');
            const strengthText = document.getElementById('strength-value');

            if (passwordInput) {
                passwordInput.addEventListener('input', function() {
                    const password = this.value;
                    let strength = 0;
                    let strengthClass = '';
                    let strengthLabel = '';

                    if (password.length === 0) {
                        strengthClass = '';
                        strengthLabel = 'Type a password';
                    } else if (password.length < 6) {
                        strength = 1;
                        strengthClass = 'strength-weak';
                        strengthLabel = 'Weak';
                    } else if (password.length < 8) {
                        strength = 2;
                        strengthClass = 'strength-medium';
                        strengthLabel = 'Medium';
                    } else if (password.length < 10) {
                        strength = 3;
                        strengthClass = 'strength-good';
                        strengthLabel = 'Good';
                    } else {
                        strength = 4;
                        strengthClass = 'strength-strong';
                        strengthLabel = 'Strong';
                    }

                    // Additional checks for stronger passwords
                    if (password.match(/[A-Z]/) && strength < 4) strength += 1;
                    if (password.match(/[0-9]/) && strength < 4) strength += 1;
                    if (password.match(/[^A-Za-z0-9]/) && strength < 4) strength += 1;

                    // Update strength meter
                    strengthMeter.className = 'strength-meter-fill';

                    if (strength === 0) {
                        strengthClass = '';
                    } else if (strength <= 2) {
                        strengthClass = 'strength-weak';
                        strengthLabel = 'Weak';
                    } else if (strength <= 4) {
                        strengthClass = 'strength-medium';
                        strengthLabel = 'Medium';
                    } else if (strength <= 6) {
                        strengthClass = 'strength-good';
                        strengthLabel = 'Good';
                    } else {
                        strengthClass = 'strength-strong';
                        strengthLabel = 'Strong';
                    }

                    strengthMeter.classList.add(strengthClass);
                    strengthText.textContent = strengthLabel;
                });
            }

            // Form validation
            const loginForm = document.getElementById('login-form');
            const registerForm = document.getElementById('register-form');
            const forgotPasswordForm = document.getElementById('forgot-password-form');

            if (loginForm) {
                loginForm.addEventListener('submit', function(e) {
                    e.preventDefault();

                    const email = document.getElementById('login-email');
                    const password = document.getElementById('login-password');
                    let isValid = true;

                    // Simple validation
                    if (!email.value || !validateEmail(email.value)) {
                        email.classList.add('is-invalid');
                        isValid = false;
                    } else {
                        email.classList.remove('is-invalid');
                    }

                    if (!password.value) {
                        password.classList.add('is-invalid');
                        isValid = false;
                    } else {
                        password.classList.remove('is-invalid');
                    }

                    if (isValid) {
                        // Simulate successful login
                        // In a real application, this would send data to the server
                        window.location.href = 'forum.html';
                    }
                });
            }

            if (registerForm) {
                registerForm.addEventListener('submit', function(e) {
                    e.preventDefault();

                    const username = document.getElementById('register-username');
                    const email = document.getElementById('register-email');
                    const password = document.getElementById('register-password');
                    const confirmPassword = document.getElementById('register-confirm-password');
                    const termsAgree = document.getElementById('terms-agree');
                    let isValid = true;

                    // Simple validation
                    if (!username.value || username.value.length < 3 || username.value.length > 20) {
                        username.classList.add('is-invalid');
                        isValid = false;
                    } else {
                        username.classList.remove('is-invalid');
                    }

                    if (!email.value || !validateEmail(email.value)) {
                        email.classList.add('is-invalid');
                        isValid = false;
                    } else {
                        email.classList.remove('is-invalid');
                    }

                    if (!password.value || password.value.length < 8) {
                        password.classList.add('is-invalid');
                        isValid = false;
                    } else {
                        password.classList.remove('is-invalid');
                    }

                    if (!confirmPassword.value || confirmPassword.value !== password.value) {
                        confirmPassword.classList.add('is-invalid');
                        isValid = false;
                    } else {
                        confirmPassword.classList.remove('is-invalid');
                    }

                    if (!termsAgree.checked) {
                        isValid = false;
                        alert('You must agree to the Terms of Service and Privacy Policy');
                    }

                    if (isValid) {
                        // Simulate successful registration
                        // In a real application, this would send data to the server
                        document.getElementById('success-alert').style.display = 'flex';
                        registerForm.reset();

                        // Switch to login tab after successful registration
                        setTimeout(function() {
                            authTabs.forEach(t => t.classList.remove('active'));
                            authTabs[0].classList.add('active');
                            authForms.forEach(form => form.classList.remove('active'));
                            document.getElementById('login-form').classList.add('active');
                            document.getElementById('success-alert').style.display = 'none';
                        }, 3000);
                    }
                });
            }

            if (forgotPasswordForm) {
                forgotPasswordForm.addEventListener('submit', function(e) {
                    e.preventDefault();

                    const email = document.getElementById('reset-email');
                    let isValid = true;

                    if (!email.value || !validateEmail(email.value)) {
                        email.classList.add('is-invalid');
                        isValid = false;
                    } else {
                        email.classList.remove('is-invalid');
                    }

                    if (isValid) {
                        // Simulate successful password reset request
                        // In a real application, this would send data to the server
                        alert('Password reset instructions have been sent to your email address.');
                        forgotPasswordForm.reset();

                        // Switch back to login form
                        authForms.forEach(form => form.classList.remove('active'));
                        document.getElementById('login-form').classList.add('active');
                    }
                });
            }

            // Email validation helper function
            function validateEmail(email) {
                const re =
                    /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                return re.test(String(email).toLowerCase());
            }
        });
    </script>
@endsection
