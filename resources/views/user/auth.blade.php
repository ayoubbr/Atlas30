@extends('user.layout')

@section('title', 'Sign In / Register - World Cup 2030')

@section('css')
    <style>
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
    <section class="page-header">
        <div class="container">
            <h1>Join Our Community</h1>
            <p>Sign in or create an account to participate in discussions, purchase tickets, and connect with football
                fans from around the world.</p>
            <ul class="breadcrumb">
                <li><a href="{{ route('home') }}">Home</a></li>
                <li><a href="#">Account</a></li>
            </ul>
        </div>
    </section>

    <main class="container">
        <div class="auth-container">
            <div class="auth-content">
                <div class="auth-tabs">
                    <div class="auth-tab {{ request()->routeIs('login') ? 'active' : '' }}" data-tab="login">Sign In</div>
                    <div class="auth-tab {{ request()->routeIs('register') ? 'active' : '' }}" data-tab="register">Create
                        Account</div>
                </div>

                <div class="auth-form-container">
                    <!-- Login Form -->
                    <form class="auth-form {{ request()->routeIs('login') ? 'active' : '' }}" id="login-form"
                        action="{{ route('login') }}" method="POST">
                        @csrf
                        <h2 class="form-title">Sign In to Your Account</h2>

                        <div class="form-group">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" id="email" name="email" class="form-control"
                                placeholder="your.email@example.com" value="{{ old('email') }}" required>
                        </div>

                        <div class="form-group">
                            <label for="password" class="form-label">Password</label>
                            <div class="password-toggle">
                                <input type="password" id="password" name="password" class="form-control"
                                    placeholder="Enter your password" required>
                                <i class="far fa-eye toggle-password" data-target="password"></i>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg btn-block">Sign In</button>
                    </form>

                    <!-- Register Form -->
                    <form class="auth-form {{ request()->routeIs('register') ? 'active' : '' }}" id="register-form"
                        action="{{ route('register') }}" method="POST">
                        @csrf
                        <h2 class="form-title">Create a New Account</h2>

                        <div class="form-group">
                            <label for="firstname" class="form-label">First Name</label>
                            <input type="text" id="firstname" name="firstname" class="form-control"
                                placeholder="Enter your first name" value="{{ old('firstname') }}" required>
                            <div class="form-text">This will be displayed publicly in the forum</div>
                        </div>

                        <div class="form-group">
                            <label for="lastname" class="form-label">Last name</label>
                            <input type="text" id="lastname" name="lastname" class="form-control "
                                placeholder="Enter your last name" value="{{ old('lastname') }}" required>
                            <div class="form-text">This will be displayed publicly in the forum</div>
                        </div>

                        <div class="form-group">
                            <label for="register-email" class="form-label">Email Address</label>
                            <input type="email" id="register-email" name="email" class="form-control"
                                placeholder="your.email@example.com" value="{{ old('email') }}" required>
                        </div>

                        <div class="form-group">
                            <label for="register-password" class="form-label">Password</label>
                            <div class="password-toggle">
                                <input type="password" id="register-password" name="password" class="form-control"
                                    placeholder="Create a password" required>
                                <i class="far fa-eye toggle-password" data-target="register-password"></i>
                            </div>

                        </div>

                        <div class="form-group">
                            <label for="register-confirm-password" class="form-label">Confirm Password</label>
                            <div class="password-toggle">
                                <input type="password" id="register-confirm-password" name="password_confirmation"
                                    class="form-control" placeholder="Confirm your password" required>
                                <i class="far fa-eye toggle-password" data-target="register-confirm-password"></i>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-success btn-lg btn-block">Create Account</button>

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
                            <div class="benefits-text">Receive personalized match recommendations</div>
                        </li>
                    </ul>
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function validateEmail(email) {
                const re =
                    /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                return re.test(String(email).toLowerCase());
            }

            // Auth tabs 
            const authTabs = document.querySelectorAll('.auth-tab');
            const authForms = document.querySelectorAll('.auth-form');

            authTabs.forEach(tab => {
                tab.addEventListener('click', function() {
                    const tabId = this.getAttribute('data-tab');

                    authTabs.forEach(t => t.classList.remove('active'));
                    this.classList.add('active');

                    authForms.forEach(form => form.classList.remove('active'));

                    if (tabId === 'login') {
                        document.getElementById('login-form').classList.add('active');
                    } else if (tabId === 'register') {
                        document.getElementById('register-form').classList.add('active');
                    }
                });
            });

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

            // Simple validation
            const loginForm = document.getElementById('login-form');
            const registerForm = document.getElementById('register-form');

            if (loginForm) {
                loginForm.addEventListener('submit', function(e) {
                    const email = document.getElementById('email');
                    const password = document.getElementById('password');
                    let isValid = true;

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

                    if (!isValid) {
                        e.preventDefault();
                    }
                });
            }

            if (registerForm) {
                registerForm.addEventListener('submit', function(e) {
                    const firstname = document.getElementById('firstname');
                    const lastname = document.getElementById('lastname');
                    const email = document.getElementById('register-email');
                    const password = document.getElementById('register-password');
                    const confirmPassword = document.getElementById('register-confirm-password');

                    let isValid = true;

                    if (!firstname.value || firstname.value.length < 3 || firstname.value
                        .length > 50) {
                        firstname.classList.add('is-invalid');
                        isValid = false;
                    } else {
                        firstname.classList.remove('is-invalid');
                    }

                    if (!lastname.value || lastname.value.length < 3 || lastname.value.length >
                        50) {
                        lastname.classList.add('is-invalid');
                        isValid = false;
                    } else {
                        lastname.classList.remove('is-invalid');
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

                    if (!isValid) {
                        e.preventDefault();
                    }
                });
            }
        });
    </script>
@endsection
