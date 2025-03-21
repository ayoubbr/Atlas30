@extends('admin.layout')

@section('title', 'Settings - World Cup 2030')

@section('css')
    <style>
        /* Settings-specific styles */
        .settings-container {
            display: flex;
            /* Make the container a flex container */
            flex-direction: row;
            /* Arrange items horizontally */
            background-color: white;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            overflow: hidden;
            margin-bottom: 30px;
        }

        .settings-sidebar {
            width: 250px;
            background-color: var(--gray-50);
            border-right: 1px solid var(--gray-200);
            padding: 20px 0;
            flex-shrink: 0;
        }

        .settings-content {
            flex: 1;
            padding: 30px;
            min-height: 600px;
        }

        .settings-nav {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .settings-nav-item {
            margin-bottom: 5px;
        }

        .settings-nav-link {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            color: var(--gray-700);
            text-decoration: none;
            border-left: 3px solid transparent;
            transition: var(--transition);
        }

        .settings-nav-link:hover {
            background-color: var(--gray-100);
            color: var(--primary);
        }

        .settings-nav-link.active {
            background-color: var(--gray-100);
            color: var(--primary);
            border-left-color: var(--primary);
            font-weight: 600;
        }

        .settings-nav-icon {
            margin-right: 12px;
            width: 20px;
            text-align: center;
        }

        .settings-section {
            margin-bottom: 30px;
        }

        .settings-section-title {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid var(--gray-200);
        }

        .settings-form-group {
            margin-bottom: 25px;
        }

        .settings-form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .settings-form-hint {
            display: block;
            margin-top: 5px;
            font-size: 0.8rem;
            color: var(--gray-500);
        }

        .settings-form-control {
            width: 100%;
            padding: 10px 15px;
            border: 1px solid var(--gray-300);
            border-radius: var(--border-radius);
            font-family: 'Poppins', sans-serif;
            font-size: 0.9rem;
            transition: var(--transition);
        }

        .settings-form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(230, 57, 70, 0.1);
        }

        .settings-form-row {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
        }

        .settings-form-col {
            flex: 1;
        }

        .settings-form-col-small {
            width: 120px;
        }

        .settings-form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid var(--gray-200);
        }

        .settings-card {
            background-color: white;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            overflow: hidden;
            margin-bottom: 20px;
        }

        .settings-card-header {
            padding: 15px 20px;
            border-bottom: 1px solid var(--gray-200);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .settings-card-title {
            font-weight: 600;
            font-size: 1rem;
            margin: 0;
        }

        .settings-card-body {
            padding: 20px;
        }

        .settings-card-footer {
            padding: 15px 20px;
            border-top: 1px solid var(--gray-200);
            background-color: var(--gray-50);
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }

        .settings-toggle {
            position: relative;
            display: inline-block;
            width: 50px;
            height: 24px;
        }

        .settings-toggle input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .settings-toggle-slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: var(--gray-300);
            transition: .4s;
            border-radius: 24px;
        }

        .settings-toggle-slider:before {
            position: absolute;
            content: "";
            height: 18px;
            width: 18px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }

        .settings-toggle input:checked+.settings-toggle-slider {
            background-color: var(--primary);
        }

        .settings-toggle input:checked+.settings-toggle-slider:before {
            transform: translateX(26px);
        }

        .settings-toggle-label {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .settings-toggle-text {
            margin-right: 10px;
            font-weight: 600;
        }

        .color-picker {
            display: flex;
            gap: 10px;
            margin-top: 10px;
        }

        .color-option {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            cursor: pointer;
            border: 2px solid transparent;
            transition: var(--transition);
        }

        .color-option.active {
            border-color: var(--gray-700);
        }

        .color-option:hover {
            transform: scale(1.1);
        }

        .image-upload {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-top: 10px;
        }

        .image-preview {
            width: 100px;
            height: 100px;
            border-radius: var(--border-radius);
            background-color: var(--gray-100);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .image-preview img {
            max-width: 100%;
            max-height: 100%;
        }

        .image-upload-btn {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .payment-gateway {
            display: flex;
            align-items: center;
            padding: 15px;
            border: 1px solid var(--gray-200);
            border-radius: var(--border-radius);
            margin-bottom: 15px;
        }

        .payment-gateway-logo {
            width: 60px;
            height: 40px;
            background-color: var(--gray-100);
            border-radius: var(--border-radius);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
        }

        .payment-gateway-info {
            flex: 1;
        }

        .payment-gateway-name {
            font-weight: 600;
            margin-bottom: 5px;
        }

        .payment-gateway-status {
            font-size: 0.8rem;
            color: var(--gray-500);
        }

        .payment-gateway-actions {
            display: flex;
            gap: 10px;
        }

        .api-key {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .api-key-value {
            flex: 1;
            font-family: monospace;
            background-color: var(--gray-100);
            padding: 8px 12px;
            border-radius: var(--border-radius);
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .cache-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .cache-stat-card {
            background-color: white;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .cache-stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background-color: var(--primary-light);
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 15px;
        }

        .cache-stat-value {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .cache-stat-label {
            font-size: 0.9rem;
            color: var(--gray-600);
        }

        .notification-template {
            padding: 15px;
            border: 1px solid var(--gray-200);
            border-radius: var(--border-radius);
            margin-bottom: 15px;
        }

        .notification-template-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .notification-template-title {
            font-weight: 600;
        }

        .notification-template-body {
            font-size: 0.9rem;
            color: var(--gray-600);
            margin-bottom: 10px;
        }

        .notification-template-footer {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }

        .tab-container {
            margin-bottom: 30px;
        }

        .tab-nav {
            display: flex;
            border-bottom: 1px solid var(--gray-300);
            margin-bottom: 20px;
        }

        .tab-btn {
            padding: 10px 20px;
            font-weight: 600;
            color: var(--gray-600);
            cursor: pointer;
            border-bottom: 3px solid transparent;
            transition: var(--transition);
        }

        .tab-btn:hover {
            color: var(--primary);
        }

        .tab-btn.active {
            color: var(--primary);
            border-bottom-color: var(--primary);
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }

        .modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .settings-container {
            display: flex;
            flex-direction: row;
            /* Ensure sidebar and content are side by side */
            background-color: white;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            overflow: hidden;
            margin-bottom: 30px;
        }

        .settings-sidebar {
            width: 250px;
            background-color: var(--gray-50);
            border-right: 1px solid var(--gray-200);
            padding: 20px 0;
            flex-shrink: 0;
            height: 100%;
            /* Ensure sidebar takes full height */
        }

        .settings-content {
            flex: 1;
            padding: 30px;
            min-height: 600px;
        }

        /* Fix the tab visibility */
        .settings-tab {
            display: none;
            /* Hide all tabs by default */
        }

        .settings-tab.active {
            display: block;
            /* Only show the active tab */
        }
    </style>
@endsection

@section('content')
    <!-- Header -->
    <header class="admin-header">
        <div class="header-left">
            <div class="menu-toggle" id="menu-toggle">
                <i class="fas fa-bars"></i>
            </div>
            <h1 class="page-title">Settings</h1>
        </div>

        <div class="header-right">
            <div class="header-search">
                <input type="text" class="search-input" placeholder="Search settings...">
                <i class="fas fa-search search-icon"></i>
            </div>

            <div class="header-actions">
                <div class="action-btn">
                    <i class="fas fa-bell"></i>
                    <span class="notification-badge">5</span>
                </div>
                <div class="action-btn">
                    <i class="fas fa-envelope"></i>
                    <span class="notification-badge">3</span>
                </div>
            </div>

            <div class="user-profile">
                <div class="user-avatar">
                    <img src="https://via.placeholder.com/40x40" alt="Admin Avatar">
                </div>
                <div class="user-info">
                    <div class="user-name">John Doe</div>
                    <div class="user-role">Administrator</div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="admin-main">
        <!-- Page Header -->
        <div class="page-header">
            <div>
                <h2 class="page-header-title">Application Settings</h2>
                <p class="page-header-description">Configure and customize the World Cup 2030 platform</p>
            </div>
            <div class="page-header-actions">
                <button class="btn btn-outline" id="exportSettingsBtn">
                    <i class="fas fa-file-export"></i> Export Settings
                </button>
                <button class="btn btn-primary" id="saveAllSettingsBtn">
                    <i class="fas fa-save"></i> Save All Changes
                </button>
            </div>
        </div>

        <!-- Settings Container -->
        <div class="settings-container d-flex">
            <!-- Settings Sidebar -->
            <div class="settings-sidebar">
                <ul class="settings-nav">
                    <li class="settings-nav-item">
                        <a href="#general" class="settings-nav-link active" data-tab="general">
                            <span class="settings-nav-icon"><i class="fas fa-cog"></i></span>
                            General
                        </a>
                    </li>
                    <li class="settings-nav-item">
                        <a href="#appearance" class="settings-nav-link" data-tab="appearance">
                            <span class="settings-nav-icon"><i class="fas fa-palette"></i></span>
                            Appearance
                        </a>
                    </li>
                    <li class="settings-nav-item">
                        <a href="#security" class="settings-nav-link" data-tab="security">
                            <span class="settings-nav-icon"><i class="fas fa-shield-alt"></i></span>
                            Security
                        </a>
                    </li>
                    <li class="settings-nav-item">
                        <a href="#email" class="settings-nav-link" data-tab="email">
                            <span class="settings-nav-icon"><i class="fas fa-envelope"></i></span>
                            Email
                        </a>
                    </li>
                    <li class="settings-nav-item">
                        <a href="#notifications" class="settings-nav-link" data-tab="notifications">
                            <span class="settings-nav-icon"><i class="fas fa-bell"></i></span>
                            Notifications
                        </a>
                    </li>
                    <li class="settings-nav-item">
                        <a href="#payment" class="settings-nav-link" data-tab="payment">
                            <span class="settings-nav-icon"><i class="fas fa-credit-card"></i></span>
                            Payment
                        </a>
                    </li>
                    <li class="settings-nav-item">
                        <a href="#social" class="settings-nav-link" data-tab="social">
                            <span class="settings-nav-icon"><i class="fas fa-share-alt"></i></span>
                            Social Media
                        </a>
                    </li>
                    <li class="settings-nav-item">
                        <a href="#api" class="settings-nav-link" data-tab="api">
                            <span class="settings-nav-icon"><i class="fas fa-code"></i></span>
                            API
                        </a>
                    </li>
                    <li class="settings-nav-item">
                        <a href="#cache" class="settings-nav-link" data-tab="cache">
                            <span class="settings-nav-icon"><i class="fas fa-database"></i></span>
                            Cache & Performance
                        </a>
                    </li>
                    <li class="settings-nav-item">
                        <a href="#backup" class="settings-nav-link" data-tab="backup">
                            <span class="settings-nav-icon"><i class="fas fa-hdd"></i></span>
                            Backup & Restore
                        </a>
                    </li>
                    <li class="settings-nav-item">
                        <a href="#logs" class="settings-nav-link" data-tab="logs">
                            <span class="settings-nav-icon"><i class="fas fa-list"></i></span>
                            Logs
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Settings Content -->
            <div class="settings-content">
                <!-- General Settings -->
                <div class="settings-tab active" id="general-tab">
                    <div class="settings-section">
                        <h3 class="settings-section-title">General Settings</h3>

                        <div class="settings-form-group">
                            <label class="settings-form-label" for="site_name">Site Name</label>
                            <input type="text" class="settings-form-control" id="site_name" value="World Cup 2030">
                            <span class="settings-form-hint">The name of your website as it appears to users</span>
                        </div>

                        <div class="settings-form-group">
                            <label class="settings-form-label" for="site_description">Site Description</label>
                            <textarea class="settings-form-control" id="site_description" rows="3">The official ticketing and fan engagement platform for the World Cup 2030.</textarea>
                            <span class="settings-form-hint">A brief description of your website for SEO purposes</span>
                        </div>

                        <div class="settings-form-row">
                            <div class="settings-form-col">
                                <div class="settings-form-group">
                                    <label class="settings-form-label" for="site_email">Contact Email</label>
                                    <input type="email" class="settings-form-control" id="site_email"
                                        value="contact@worldcup2030.com">
                                    <span class="settings-form-hint">Primary contact email for the website</span>
                                </div>
                            </div>
                            <div class="settings-form-col">
                                <div class="settings-form-group">
                                    <label class="settings-form-label" for="site_phone">Contact Phone</label>
                                    <input type="text" class="settings-form-control" id="site_phone"
                                        value="+1 (555) 123-4567">
                                    <span class="settings-form-hint">Primary contact phone for the website</span>
                                </div>
                            </div>
                        </div>

                        <div class="settings-form-group">
                            <label class="settings-form-label" for="site_address">Address</label>
                            <textarea class="settings-form-control" id="site_address" rows="3">123 Stadium Way, Sports City, SC 12345, United States</textarea>
                            <span class="settings-form-hint">Physical address for your organization</span>
                        </div>

                        <div class="settings-form-row">
                            <div class="settings-form-col">
                                <div class="settings-form-group">
                                    <label class="settings-form-label" for="timezone">Timezone</label>
                                    <select class="settings-form-control" id="timezone">
                                        <option value="UTC">UTC</option>
                                        <option value="America/New_York" selected>America/New_York (UTC-5)</option>
                                        <option value="America/Chicago">America/Chicago (UTC-6)</option>
                                        <option value="America/Denver">America/Denver (UTC-7)</option>
                                        <option value="America/Los_Angeles">America/Los_Angeles (UTC-8)</option>
                                        <option value="Europe/London">Europe/London (UTC+0)</option>
                                        <option value="Europe/Paris">Europe/Paris (UTC+1)</option>
                                        <option value="Asia/Tokyo">Asia/Tokyo (UTC+9)</option>
                                    </select>
                                    <span class="settings-form-hint">Default timezone for the application</span>
                                </div>
                            </div>
                            <div class="settings-form-col">
                                <div class="settings-form-group">
                                    <label class="settings-form-label" for="date_format">Date Format</label>
                                    <select class="settings-form-control" id="date_format">
                                        <option value="MM/DD/YYYY" selected>MM/DD/YYYY</option>
                                        <option value="DD/MM/YYYY">DD/MM/YYYY</option>
                                        <option value="YYYY-MM-DD">YYYY-MM-DD</option>
                                        <option value="MMMM D, YYYY">MMMM D, YYYY</option>
                                        <option value="D MMMM, YYYY">D MMMM, YYYY</option>
                                    </select>
                                    <span class="settings-form-hint">Default date format for the application</span>
                                </div>
                            </div>
                        </div>

                        <div class="settings-form-row">
                            <div class="settings-form-col">
                                <div class="settings-form-group">
                                    <label class="settings-form-label" for="currency">Default Currency</label>
                                    <select class="settings-form-control" id="currency">
                                        <option value="USD" selected>US Dollar (USD)</option>
                                        <option value="EUR">Euro (EUR)</option>
                                        <option value="GBP">British Pound (GBP)</option>
                                        <option value="JPY">Japanese Yen (JPY)</option>
                                        <option value="CAD">Canadian Dollar (CAD)</option>
                                        <option value="AUD">Australian Dollar (AUD)</option>
                                    </select>
                                    <span class="settings-form-hint">Default currency for transactions</span>
                                </div>
                            </div>
                            <div class="settings-form-col">
                                <div class="settings-form-group">
                                    <label class="settings-form-label" for="language">Default Language</label>
                                    <select class="settings-form-control" id="language">
                                        <option value="en" selected>English</option>
                                        <option value="es">Spanish</option>
                                        <option value="fr">French</option>
                                        <option value="de">German</option>
                                        <option value="pt">Portuguese</option>
                                        <option value="ar">Arabic</option>
                                        <option value="zh">Chinese</option>
                                    </select>
                                    <span class="settings-form-hint">Default language for the application</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="settings-section">
                        <h3 class="settings-section-title">Registration & User Settings</h3>

                        <div class="settings-form-group">
                            <label class="settings-toggle-label">
                                <span class="settings-toggle-text">Allow User Registration</span>
                                <label class="settings-toggle">
                                    <input type="checkbox" checked>
                                    <span class="settings-toggle-slider"></span>
                                </label>
                            </label>
                            <span class="settings-form-hint">Enable or disable new user registrations</span>
                        </div>

                        <div class="settings-form-group">
                            <label class="settings-toggle-label">
                                <span class="settings-toggle-text">Email Verification Required</span>
                                <label class="settings-toggle">
                                    <input type="checkbox" checked>
                                    <span class="settings-toggle-slider"></span>
                                </label>
                            </label>
                            <span class="settings-form-hint">Require users to verify their email address before accessing
                                the site</span>
                        </div>

                        <div class="settings-form-group">
                            <label class="settings-toggle-label">
                                <span class="settings-toggle-text">Allow Social Login</span>
                                <label class="settings-toggle">
                                    <input type="checkbox" checked>
                                    <span class="settings-toggle-slider"></span>
                                </label>
                            </label>
                            <span class="settings-form-hint">Allow users to login using social media accounts</span>
                        </div>

                        <div class="settings-form-group">
                            <label class="settings-form-label" for="default_user_role">Default User Role</label>
                            <select class="settings-form-control" id="default_user_role">
                                <option value="user" selected>Regular User</option>
                                <option value="contributor">Contributor</option>
                                <option value="editor">Editor</option>
                                <option value="moderator">Moderator</option>
                            </select>
                            <span class="settings-form-hint">Default role assigned to new users</span>
                        </div>
                    </div>

                    <div class="settings-form-actions">
                        <button class="btn btn-outline">Reset to Default</button>
                        <button class="btn btn-primary">Save Changes</button>
                    </div>
                </div>

                <!-- Appearance Settings -->
                <div class="settings-tab" id="appearance-tab">
                    <div class="settings-section">
                        <h3 class="settings-section-title">Theme Settings</h3>

                        <div class="settings-form-group">
                            <label class="settings-form-label">Theme Mode</label>
                            <div class="settings-form-row">
                                <div class="settings-form-col">
                                    <label class="radio-card">
                                        <input type="radio" name="theme_mode" value="light" checked>
                                        <div class="radio-card-content">
                                            <div class="radio-card-icon">
                                                <i class="fas fa-sun"></i>
                                            </div>
                                            <div class="radio-card-label">Light Mode</div>
                                        </div>
                                    </label>
                                </div>
                                <div class="settings-form-col">
                                    <label class="radio-card">
                                        <input type="radio" name="theme_mode" value="dark">
                                        <div class="radio-card-content">
                                            <div class="radio-card-icon">
                                                <i class="fas fa-moon"></i>
                                            </div>
                                            <div class="radio-card-label">Dark Mode</div>
                                        </div>
                                    </label>
                                </div>
                                <div class="settings-form-col">
                                    <label class="radio-card">
                                        <input type="radio" name="theme_mode" value="auto">
                                        <div class="radio-card-content">
                                            <div class="radio-card-icon">
                                                <i class="fas fa-adjust"></i>
                                            </div>
                                            <div class="radio-card-label">Auto (System)</div>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="settings-form-group">
                            <label class="settings-form-label">Primary Color</label>
                            <div class="color-picker">
                                <div class="color-option active" style="background-color: #e63946;"></div>
                                <div class="color-option" style="background-color: #2a9d8f;"></div>
                                <div class="color-option" style="background-color: #3a86ff;"></div>
                                <div class="color-option" style="background-color: #8338ec;"></div>
                                <div class="color-option" style="background-color: #fb8500;"></div>
                                <div class="color-option" style="background-color: #1d3557;"></div>
                            </div>
                            <span class="settings-form-hint">Primary color used throughout the application</span>
                        </div>

                        <div class="settings-form-group">
                            <label class="settings-form-label">Secondary Color</label>
                            <div class="color-picker">
                                <div class="color-option" style="background-color: #e63946;"></div>
                                <div class="color-option" style="background-color: #2a9d8f;"></div>
                                <div class="color-option active" style="background-color: #3a86ff;"></div>
                                <div class="color-option" style="background-color: #8338ec;"></div>
                                <div class="color-option" style="background-color: #fb8500;"></div>
                                <div class="color-option" style="background-color: #1d3557;"></div>
                            </div>
                            <span class="settings-form-hint">Secondary color used throughout the application</span>
                        </div>
                    </div>

                    <div class="settings-section">
                        <h3 class="settings-section-title">Logo & Favicon</h3>

                        <div class="settings-form-group">
                            <label class="settings-form-label">Site Logo</label>
                            <div class="image-upload">
                                <div class="image-preview">
                                    <img src="https://via.placeholder.com/100x100" alt="Site Logo">
                                </div>
                                <div class="image-upload-btn">
                                    <button class="btn btn-outline">
                                        <i class="fas fa-upload"></i> Upload New Logo
                                    </button>
                                    <button class="btn btn-sm btn-outline btn-danger">
                                        <i class="fas fa-trash"></i> Remove
                                    </button>
                                </div>
                            </div>
                            <span class="settings-form-hint">Recommended size: 200x60 pixels, PNG or SVG format</span>
                        </div>

                        <div class="settings-form-group">
                            <label class="settings-form-label">Site Favicon</label>
                            <div class="image-upload">
                                <div class="image-preview">
                                    <img src="https://via.placeholder.com/32x32" alt="Site Favicon">
                                </div>
                                <div class="image-upload-btn">
                                    <button class="btn btn-outline">
                                        <i class="fas fa-upload"></i> Upload New Favicon
                                    </button>
                                    <button class="btn btn-sm btn-outline btn-danger">
                                        <i class="fas fa-trash"></i> Remove
                                    </button>
                                </div>
                            </div>
                            <span class="settings-form-hint">Recommended size: 32x32 pixels, ICO or PNG format</span>
                        </div>
                    </div>

                    <div class="settings-section">
                        <h3 class="settings-section-title">Custom CSS & JavaScript</h3>

                        <div class="settings-form-group">
                            <label class="settings-form-label" for="custom_css">Custom CSS</label>
                            <textarea class="settings-form-control" id="custom_css" rows="5" style="font-family: monospace;"></textarea>
                            <span class="settings-form-hint">Custom CSS that will be applied to the entire site</span>
                        </div>

                        <div class="settings-form-group">
                            <label class="settings-form-label" for="custom_js">Custom JavaScript</label>
                            <textarea class="settings-form-control" id="custom_js" rows="5" style="font-family: monospace;"></textarea>
                            <span class="settings-form-hint">Custom JavaScript that will be applied to the entire
                                site</span>
                        </div>
                    </div>

                    <div class="settings-form-actions">
                        <button class="btn btn-outline">Reset to Default</button>
                        <button class="btn btn-primary">Save Changes</button>
                    </div>
                </div>

                <!-- Security Settings -->
                <div class="settings-tab" id="security-tab">
                    <div class="settings-section">
                        <h3 class="settings-section-title">Authentication Settings</h3>

                        <div class="settings-form-group">
                            <label class="settings-toggle-label">
                                <span class="settings-toggle-text">Two-Factor Authentication</span>
                                <label class="settings-toggle">
                                    <input type="checkbox" checked>
                                    <span class="settings-toggle-slider"></span>
                                </label>
                            </label>
                            <span class="settings-form-hint">Enable two-factor authentication for user accounts</span>
                        </div>

                        <div class="settings-form-group">
                            <label class="settings-form-label" for="password_min_length">Minimum Password Length</label>
                            <input type="number" class="settings-form-control" id="password_min_length" value="8"
                                min="6" max="32">
                            <span class="settings-form-hint">Minimum number of characters required for passwords</span>
                        </div>

                        <div class="settings-form-group">
                            <label class="settings-toggle-label">
                                <span class="settings-toggle-text">Require Special Characters</span>
                                <label class="settings-toggle">
                                    <input type="checkbox" checked>
                                    <span class="settings-toggle-slider"></span>
                                </label>
                            </label>
                            <span class="settings-form-hint">Require passwords to contain at least one special
                                character</span>
                        </div>

                        <div class="settings-form-group">
                            <label class="settings-toggle-label">
                                <span class="settings-toggle-text">Require Numbers</span>
                                <label class="settings-toggle">
                                    <input type="checkbox" checked>
                                    <span class="settings-toggle-slider"></span>
                                </label>
                            </label>
                            <span class="settings-form-hint">Require passwords to contain at least one number</span>
                        </div>

                        <div class="settings-form-group">
                            <label class="settings-toggle-label">
                                <span class="settings-toggle-text">Require Mixed Case</span>
                                <label class="settings-toggle">
                                    <input type="checkbox" checked>
                                    <span class="settings-toggle-slider"></span>
                                </label>
                            </label>
                            <span class="settings-form-hint">Require passwords to contain both uppercase and lowercase
                                letters</span>
                        </div>

                        <div class="settings-form-group">
                            <label class="settings-form-label" for="password_expiry">Password Expiry (Days)</label>
                            <input type="number" class="settings-form-control" id="password_expiry" value="90"
                                min="0" max="365">
                            <span class="settings-form-hint">Number of days before passwords expire (0 for never)</span>
                        </div>
                    </div>

                    <div class="settings-section">
                        <h3 class="settings-section-title">Session Settings</h3>

                        <div class="settings-form-group">
                            <label class="settings-form-label" for="session_timeout">Session Timeout (Minutes)</label>
                            <input type="number" class="settings-form-control" id="session_timeout" value="30"
                                min="5" max="1440">
                            <span class="settings-form-hint">Number of minutes of inactivity before a user is logged
                                out</span>
                        </div>

                        <div class="settings-form-group">
                            <label class="settings-toggle-label">
                                <span class="settings-toggle-text">Remember Me Functionality</span>
                                <label class="settings-toggle">
                                    <input type="checkbox" checked>
                                    <span class="settings-toggle-slider"></span>
                                </label>
                            </label>
                            <span class="settings-form-hint">Allow users to stay logged in across browser sessions</span>
                        </div>

                        <div class="settings-form-group">
                            <label class="settings-form-label" for="max_login_attempts">Max Login Attempts</label>
                            <input type="number" class="settings-form-control" id="max_login_attempts" value="5"
                                min="3" max="10">
                            <span class="settings-form-hint">Maximum number of failed login attempts before account
                                lockout</span>
                        </div>

                        <div class="settings-form-group">
                            <label class="settings-form-label" for="lockout_time">Account Lockout Time (Minutes)</label>
                            <input type="number" class="settings-form-control" id="lockout_time" value="15"
                                min="5" max="60">
                            <span class="settings-form-hint">Number of minutes an account is locked after too many failed
                                login attempts</span>
                        </div>
                    </div>

                    <div class="settings-section">
                        <h3 class="settings-section-title">Security Headers</h3>

                        <div class="settings-form-group">
                            <label class="settings-toggle-label">
                                <span class="settings-toggle-text">Content Security Policy (CSP)</span>
                                <label class="settings-toggle">
                                    <input type="checkbox" checked>
                                    <span class="settings-toggle-slider"></span>
                                </label>
                            </label>
                            <span class="settings-form-hint">Enable Content Security Policy headers to prevent XSS
                                attacks</span>
                        </div>

                        <div class="settings-form-group">
                            <label class="settings-toggle-label">
                                <span class="settings-toggle-text">X-XSS-Protection</span>
                                <label class="settings-toggle">
                                    <input type="checkbox" checked>
                                    <span class="settings-toggle-slider"></span>
                                </label>
                            </label>
                            <span class="settings-form-hint">Enable X-XSS-Protection header to prevent XSS attacks</span>
                        </div>

                        <div class="settings-form-group">
                            <label class="settings-toggle-label">
                                <span class="settings-toggle-text">X-Frame-Options</span>
                                <label class="settings-toggle">
                                    <input type="checkbox" checked>
                                    <span class="settings-toggle-slider"></span>
                                </label>
                            </label>
                            <span class="settings-form-hint">Enable X-Frame-Options header to prevent clickjacking</span>
                        </div>

                        <div class="settings-form-group">
                            <label class="settings-toggle-label">
                                <span class="settings-toggle-text">HTTP Strict Transport Security (HSTS)</span>
                                <label class="settings-toggle">
                                    <input type="checkbox" checked>
                                    <span class="settings-toggle-slider"></span>
                                </label>
                            </label>
                            <span class="settings-form-hint">Enable HSTS to enforce HTTPS connections</span>
                        </div>
                    </div>

                    <div class="settings-form-actions">
                        <button class="btn btn-outline">Reset to Default</button>
                        <button class="btn btn-primary">Save Changes</button>
                    </div>
                </div>

                <!-- Email Settings -->
                <div class="settings-tab" id="email-tab">
                    <div class="settings-section">
                        <h3 class="settings-section-title">SMTP Configuration</h3>

                        <div class="settings-form-group">
                            <label class="settings-form-label" for="mail_driver">Mail Driver</label>
                            <select class="settings-form-control" id="mail_driver">
                                <option value="smtp" selected>SMTP</option>
                                <option value="sendmail">Sendmail</option>
                                <option value="mailgun">Mailgun</option>
                                <option value="ses">Amazon SES</option>
                                <option value="postmark">Postmark</option>
                            </select>
                            <span class="settings-form-hint">Mail service to use for sending emails</span>
                        </div>

                        <div class="settings-form-group">
                            <label class="settings-form-label" for="mail_host">SMTP Host</label>
                            <input type="text" class="settings-form-control" id="mail_host" value="smtp.mailtrap.io">
                            <span class="settings-form-hint">SMTP server hostname</span>
                        </div>

                        <div class="settings-form-row">
                            <div class="settings-form-col">
                                <div class="settings-form-group">
                                    <label class="settings-form-label" for="mail_port">SMTP Port</label>
                                    <input type="number" class="settings-form-control" id="mail_port" value="2525">
                                    <span class="settings-form-hint">SMTP server port</span>
                                </div>
                            </div>
                            <div class="settings-form-col">
                                <div class="settings-form-group">
                                    <label class="settings-form-label" for="mail_encryption">Encryption</label>
                                    <select class="settings-form-control" id="mail_encryption">
                                        <option value="none">None</option>
                                        <option value="tls" selected>TLS</option>
                                        <option value="ssl">SSL</option>
                                    </select>
                                    <span class="settings-form-hint">Encryption protocol</span>
                                </div>
                            </div>
                        </div>

                        <div class="settings-form-row">
                            <div class="settings-form-col">
                                <div class="settings-form-group">
                                    <label class="settings-form-label" for="mail_username">SMTP Username</label>
                                    <input type="text" class="settings-form-control" id="mail_username"
                                        value="123456789">
                                    <span class="settings-form-hint">SMTP server username</span>
                                </div>
                            </div>
                            <div class="settings-form-col">
                                <div class="settings-form-group">
                                    <label class="settings-form-label" for="mail_password">SMTP Password</label>
                                    <input type="password" class="settings-form-control" id="mail_password"
                                        value="abcdef123456">
                                    <span class="settings-form-hint">SMTP server password</span>
                                </div>
                            </div>
                        </div>

                        <div class="settings-form-group">
                            <label class="settings-form-label" for="mail_from_address">From Address</label>
                            <input type="email" class="settings-form-control" id="mail_from_address"
                                value="noreply@worldcup2030.com">
                            <span class="settings-form-hint">Email address that will appear in the From field</span>
                        </div>

                        <div class="settings-form-group">
                            <label class="settings-form-label" for="mail_from_name">From Name</label>
                            <input type="text" class="settings-form-control" id="mail_from_name"
                                value="World Cup 2030">
                            <span class="settings-form-hint">Name that will appear in the From field</span>
                        </div>

                        <div class="settings-form-group">
                            <button class="btn btn-outline">
                                <i class="fas fa-paper-plane"></i> Send Test Email
                            </button>
                        </div>
                    </div>

                    <div class="settings-section">
                        <h3 class="settings-section-title">Email Templates</h3>

                        <div class="settings-card">
                            <div class="settings-card-header">
                                <h4 class="settings-card-title">Welcome Email</h4>
                                <button class="btn btn-sm btn-outline">
                                    <i class="fas fa-edit"></i> Edit Template
                                </button>
                            </div>
                            <div class="settings-card-body">
                                <p>Sent to new users after registration. Contains account activation link and welcome
                                    message.</p>
                            </div>
                        </div>

                        <div class="settings-card">
                            <div class="settings-card-header">
                                <h4 class="settings-card-title">Password Reset</h4>
                                <button class="btn btn-sm btn-outline">
                                    <i class="fas fa-edit"></i> Edit Template
                                </button>
                            </div>
                            <div class="settings-card-body">
                                <p>Sent to users who request a password reset. Contains password reset link.</p>
                            </div>
                        </div>

                        <div class="settings-card">
                            <div class="settings-card-header">
                                <h4 class="settings-card-title">Ticket Confirmation</h4>
                                <button class="btn btn-sm btn-outline">
                                    <i class="fas fa-edit"></i> Edit Template
                                </button>
                            </div>
                            <div class="settings-card-body">
                                <p>Sent to users after purchasing tickets. Contains ticket details and QR code.</p>
                            </div>
                        </div>

                        <div class="settings-card">
                            <div class="settings-card-header">
                                <h4 class="settings-card-title">Match Reminder</h4>
                                <button class="btn btn-sm btn-outline">
                                    <i class="fas fa-edit"></i> Edit Template
                                </button>
                            </div>
                            <div class="settings-card-body">
                                <p>Sent to ticket holders 24 hours before a match. Contains match details and venue
                                    information.</p>
                            </div>
                        </div>
                    </div>

                    <div class="settings-form-actions">
                        <button class="btn btn-outline">Reset to Default</button>
                        <button class="btn btn-primary">Save Changes</button>
                    </div>
                </div>

                <!-- Notifications Settings -->
                <div class="settings-tab" id="notifications-tab">
                    <div class="settings-section">
                        <h3 class="settings-section-title">Notification Channels</h3>

                        <div class="settings-form-group">
                            <label class="settings-toggle-label">
                                <span class="settings-toggle-text">Email Notifications</span>
                                <label class="settings-toggle">
                                    <input type="checkbox" checked>
                                    <span class="settings-toggle-slider"></span>
                                </label>
                            </label>
                            <span class="settings-form-hint">Send notifications via email</span>
                        </div>

                        <div class="settings-form-group">
                            <label class="settings-toggle-label">
                                <span class="settings-toggle-text">SMS Notifications</span>
                                <label class="settings-toggle">
                                    <input type="checkbox" checked>
                                    <span class="settings-toggle-slider"></span>
                                </label>
                            </label>
                            <span class="settings-form-hint">Send notifications via SMS</span>
                        </div>

                        <div class="settings-form-group">
                            <label class="settings-toggle-label">
                                <span class="settings-toggle-text">Push Notifications</span>
                                <label class="settings-toggle">
                                    <input type="checkbox" checked>
                                    <span class="settings-toggle-slider"></span>
                                </label>
                            </label>
                            <span class="settings-form-hint">Send push notifications to mobile devices</span>
                        </div>

                        <div class="settings-form-group">
                            <label class="settings-toggle-label">
                                <span class="settings-toggle-text">In-App Notifications</span>
                                <label class="settings-toggle">
                                    <input type="checkbox" checked>
                                    <span class="settings-toggle-slider"></span>
                                </label>
                            </label>
                            <span class="settings-form-hint">Show notifications within the application</span>
                        </div>
                    </div>

                    <div class="settings-section">
                        <h3 class="settings-section-title">Notification Types</h3>

                        <div class="notification-template">
                            <div class="notification-template-header">
                                <div class="notification-template-title">Account Notifications</div>
                                <button class="btn btn-sm btn-outline">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                            </div>
                            <div class="notification-template-body">
                                <div class="settings-form-group">
                                    <label class="settings-toggle-label">
                                        <span class="settings-toggle-text">New Account Registration</span>
                                        <label class="settings-toggle">
                                            <input type="checkbox" checked>
                                            <span class="settings-toggle-slider"></span>
                                        </label>
                                    </label>
                                </div>
                                <div class="settings-form-group">
                                    <label class="settings-toggle-label">
                                        <span class="settings-toggle-text">Password Changes</span>
                                        <label class="settings-toggle">
                                            <input type="checkbox" checked>
                                            <span class="settings-toggle-slider"></span>
                                        </label>
                                    </label>
                                </div>
                                <div class="settings-form-group">
                                    <label class="settings-toggle-label">
                                        <span class="settings-toggle-text">Profile Updates</span>
                                        <label class="settings-toggle">
                                            <input type="checkbox" checked>
                                            <span class="settings-toggle-slider"></span>
                                        </label>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="notification-template">
                            <div class="notification-template-header">
                                <div class="notification-template-title">Ticket Notifications</div>
                                <button class="btn btn-sm btn-outline">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                            </div>
                            <div class="notification-template-body">
                                <div class="settings-form-group">
                                    <label class="settings-toggle-label">
                                        <span class="settings-toggle-text">Ticket Purchase Confirmation</span>
                                        <label class="settings-toggle">
                                            <input type="checkbox" checked>
                                            <span class="settings-toggle-slider"></span>
                                        </label>
                                    </label>
                                </div>
                                <div class="settings-form-group">
                                    <label class="settings-toggle-label">
                                        <span class="settings-toggle-text">Match Reminders</span>
                                        <label class="settings-toggle">
                                            <input type="checkbox" checked>
                                            <span class="settings-toggle-slider"></span>
                                        </label>
                                    </label>
                                </div>
                                <div class="settings-form-group">
                                    <label class="settings-toggle-label">
                                        <span class="settings-toggle-text">Ticket Transfers</span>
                                        <label class="settings-toggle">
                                            <input type="checkbox" checked>
                                            <span class="settings-toggle-slider"></span>
                                        </label>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="notification-template">
                            <div class="notification-template-header">
                                <div class="notification-template-title">Forum Notifications</div>
                                <button class="btn btn-sm btn-outline">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                            </div>
                            <div class="notification-template-body">
                                <div class="settings-form-group">
                                    <label class="settings-toggle-label">
                                        <span class="settings-toggle-text">New Replies to Your Threads</span>
                                        <label class="settings-toggle">
                                            <input type="checkbox" checked>
                                            <span class="settings-toggle-slider"></span>
                                        </label>
                                    </label>
                                </div>
                                <div class="settings-form-group">
                                    <label class="settings-toggle-label">
                                        <span class="settings-toggle-text">Mentions</span>
                                        <label class="settings-toggle">
                                            <input type="checkbox" checked>
                                            <span class="settings-toggle-slider"></span>
                                        </label>
                                    </label>
                                </div>
                                <div class="settings-form-group">
                                    <label class="settings-toggle-label">
                                        <span class="settings-toggle-text">Thread Subscriptions</span>
                                        <label class="settings-toggle">
                                            <input type="checkbox" checked>
                                            <span class="settings-toggle-slider"></span>
                                        </label>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="settings-form-actions">
                        <button class="btn btn-outline">Reset to Default</button>
                        <button class="btn btn-primary">Save Changes</button>
                    </div>
                </div>

                <!-- Payment Settings -->
                <div class="settings-tab" id="payment-tab">
                    <div class="settings-section">
                        <h3 class="settings-section-title">Payment Gateways</h3>

                        <div class="payment-gateway">
                            <div class="payment-gateway-logo">
                                <i class="fab fa-stripe fa-2x"></i>
                            </div>
                            <div class="payment-gateway-info">
                                <div class="payment-gateway-name">Stripe</div>
                                <div class="payment-gateway-status">Active</div>
                            </div>
                            <div class="payment-gateway-actions">
                                <button class="btn btn-sm btn-outline">
                                    <i class="fas fa-cog"></i> Configure
                                </button>
                                <button class="btn btn-sm btn-outline btn-danger">
                                    <i class="fas fa-power-off"></i> Disable
                                </button>
                            </div>
                        </div>

                        <div class="payment-gateway">
                            <div class="payment-gateway-logo">
                                <i class="fab fa-paypal fa-2x"></i>
                            </div>
                            <div class="payment-gateway-info">
                                <div class="payment-gateway-name">PayPal</div>
                                <div class="payment-gateway-status">Active</div>
                            </div>
                            <div class="payment-gateway-actions">
                                <button class="btn btn-sm btn-outline">
                                    <i class="fas fa-cog"></i> Configure
                                </button>
                                <button class="btn btn-sm btn-outline btn-danger">
                                    <i class="fas fa-power-off"></i> Disable
                                </button>
                            </div>
                        </div>

                        <div class="payment-gateway">
                            <div class="payment-gateway-logo">
                                <i class="fas fa-credit-card fa-2x"></i>
                            </div>
                            <div class="payment-gateway-info">
                                <div class="payment-gateway-name">Square</div>
                                <div class="payment-gateway-status">Inactive</div>
                            </div>
                            <div class="payment-gateway-actions">
                                <button class="btn btn-sm btn-outline">
                                    <i class="fas fa-cog"></i> Configure
                                </button>
                                <button class="btn btn-sm btn-outline btn-success">
                                    <i class="fas fa-power-off"></i> Enable
                                </button>
                            </div>
                        </div>

                        <div class="payment-gateway">
                            <div class="payment-gateway-logo">
                                <i class="fab fa-apple-pay fa-2x"></i>
                            </div>
                            <div class="payment-gateway-info">
                                <div class="payment-gateway-name">Apple Pay</div>
                                <div class="payment-gateway-status">Inactive</div>
                            </div>
                            <div class="payment-gateway-actions">
                                <button class="btn btn-sm btn-outline">
                                    <i class="fas fa-cog"></i> Configure
                                </button>
                                <button class="btn btn-sm btn-outline btn-success">
                                    <i class="fas fa-power-off"></i> Enable
                                </button>
                            </div>
                        </div>

                        <div class="payment-gateway">
                            <div class="payment-gateway-logo">
                                <i class="fab fa-google-pay fa-2x"></i>
                            </div>
                            <div class="payment-gateway-info">
                                <div class="payment-gateway-name">Google Pay</div>
                                <div class="payment-gateway-status">Inactive</div>
                            </div>
                            <div class="payment-gateway-actions">
                                <button class="btn btn-sm btn-outline">
                                    <i class="fas fa-cog"></i> Configure
                                </button>
                                <button class="btn btn-sm btn-outline btn-success">
                                    <i class="fas fa-power-off"></i> Enable
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="settings-section">
                        <h3 class="settings-section-title">Payment Settings</h3>

                        <div class="settings-form-row">
                            <div class="settings-form-col">
                                <div class="settings-form-group">
                                    <label class="settings-form-label" for="default_currency">Default Currency</label>
                                    <select class="settings-form-control" id="default_currency">
                                        <option value="USD" selected>US Dollar (USD)</option>
                                        <option value="EUR">Euro (EUR)</option>
                                        <option value="GBP">British Pound (GBP)</option>
                                        <option value="JPY">Japanese Yen (JPY)</option>
                                        <option value="CAD">Canadian Dollar (CAD)</option>
                                        <option value="AUD">Australian Dollar (AUD)</option>
                                    </select>
                                    <span class="settings-form-hint">Default currency for transactions</span>
                                </div>
                            </div>
                            <div class="settings-form-col">
                                <div class="settings-form-group">
                                    <label class="settings-form-label" for="currency_symbol_position">Currency Symbol
                                        Position</label>
                                    <select class="settings-form-control" id="currency_symbol_position">
                                        <option value="before" selected>Before (e.g., $100)</option>
                                        <option value selected>Before (e.g., $100)</option>
                                        <option value="after">After (e.g., 100$)</option>
                                    </select>
                                    <span class="settings-form-hint">Position of the currency symbol relative to the
                                        amount</span>
                                </div>
                            </div>
                        </div>

                        <div class="settings-form-group">
                            <label class="settings-toggle-label">
                                <span class="settings-toggle-text">Enable Tax Calculation</span>
                                <label class="settings-toggle">
                                    <input type="checkbox" checked>
                                    <span class="settings-toggle-slider"></span>
                                </label>
                            </label>
                            <span class="settings-form-hint">Calculate and apply taxes to transactions</span>
                        </div>

                        <div class="settings-form-row">
                            <div class="settings-form-col">
                                <div class="settings-form-group">
                                    <label class="settings-form-label" for="tax_rate">Default Tax Rate (%)</label>
                                    <input type="number" class="settings-form-control" id="tax_rate" value="10"
                                        min="0" max="100" step="0.01">
                                    <span class="settings-form-hint">Default tax rate to apply to transactions</span>
                                </div>
                            </div>
                            <div class="settings-form-col">
                                <div class="settings-form-group">
                                    <label class="settings-form-label" for="tax_name">Tax Name</label>
                                    <input type="text" class="settings-form-control" id="tax_name"
                                        value="Sales Tax">
                                    <span class="settings-form-hint">Name of the tax as it appears on invoices</span>
                                </div>
                            </div>
                        </div>

                        <div class="settings-form-group">
                            <label class="settings-toggle-label">
                                <span class="settings-toggle-text">Enable Invoicing</span>
                                <label class="settings-toggle">
                                    <input type="checkbox" checked>
                                    <span class="settings-toggle-slider"></span>
                                </label>
                            </label>
                            <span class="settings-form-hint">Generate invoices for transactions</span>
                        </div>

                        <div class="settings-form-group">
                            <label class="settings-form-label" for="invoice_prefix">Invoice Number Prefix</label>
                            <input type="text" class="settings-form-control" id="invoice_prefix" value="WC2030-">
                            <span class="settings-form-hint">Prefix for invoice numbers</span>
                        </div>
                    </div>

                    <div class="settings-form-actions">
                        <button class="btn btn-outline">Reset to Default</button>
                        <button class="btn btn-primary">Save Changes</button>
                    </div>
                </div>

                <!-- Social Media Settings -->
                <div class="settings-tab" id="social-tab">
                    <div class="settings-section">
                        <h3 class="settings-section-title">Social Media Accounts</h3>

                        <div class="settings-form-group">
                            <label class="settings-form-label" for="facebook_url">Facebook</label>
                            <input type="url" class="settings-form-control" id="facebook_url"
                                value="https://facebook.com/worldcup2030">
                            <span class="settings-form-hint">URL to your Facebook page</span>
                        </div>

                        <div class="settings-form-group">
                            <label class="settings-form-label" for="twitter_url">Twitter</label>
                            <input type="url" class="settings-form-control" id="twitter_url"
                                value="https://twitter.com/worldcup2030">
                            <span class="settings-form-hint">URL to your Twitter profile</span>
                        </div>

                        <div class="settings-form-group">
                            <label class="settings-form-label" for="instagram_url">Instagram</label>
                            <input type="url" class="settings-form-control" id="instagram_url"
                                value="https://instagram.com/worldcup2030">
                            <span class="settings-form-hint">URL to your Instagram profile</span>
                        </div>

                        <div class="settings-form-group">
                            <label class="settings-form-label" for="youtube_url">YouTube</label>
                            <input type="url" class="settings-form-control" id="youtube_url"
                                value="https://youtube.com/worldcup2030">
                            <span class="settings-form-hint">URL to your YouTube channel</span>
                        </div>

                        <div class="settings-form-group">
                            <label class="settings-form-label" for="linkedin_url">LinkedIn</label>
                            <input type="url" class="settings-form-control" id="linkedin_url"
                                value="https://linkedin.com/company/worldcup2030">
                            <span class="settings-form-hint">URL to your LinkedIn page</span>
                        </div>
                    </div>

                    <div class="settings-section">
                        <h3 class="settings-section-title">Social Login</h3>

                        <div class="settings-form-group">
                            <label class="settings-toggle-label">
                                <span class="settings-toggle-text">Enable Facebook Login</span>
                                <label class="settings-toggle">
                                    <input type="checkbox" checked>
                                    <span class="settings-toggle-slider"></span>
                                </label>
                            </label>
                            <span class="settings-form-hint">Allow users to login with Facebook</span>
                        </div>

                        <div class="settings-form-row">
                            <div class="settings-form-col">
                                <div class="settings-form-group">
                                    <label class="settings-form-label" for="facebook_app_id">Facebook App ID</label>
                                    <input type="text" class="settings-form-control" id="facebook_app_id"
                                        value="123456789012345">
                                    <span class="settings-form-hint">Your Facebook App ID</span>
                                </div>
                            </div>
                            <div class="settings-form-col">
                                <div class="settings-form-group">
                                    <label class="settings-form-label" for="facebook_app_secret">Facebook App
                                        Secret</label>
                                    <input type="password" class="settings-form-control" id="facebook_app_secret"
                                        value="abcdef123456789">
                                    <span class="settings-form-hint">Your Facebook App Secret</span>
                                </div>
                            </div>
                        </div>

                        <div class="settings-form-group">
                            <label class="settings-toggle-label">
                                <span class="settings-toggle-text">Enable Google Login</span>
                                <label class="settings-toggle">
                                    <input type="checkbox" checked>
                                    <span class="settings-toggle-slider"></span>
                                </label>
                            </label>
                            <span class="settings-form-hint">Allow users to login with Google</span>
                        </div>

                        <div class="settings-form-row">
                            <div class="settings-form-col">
                                <div class="settings-form-group">
                                    <label class="settings-form-label" for="google_client_id">Google Client ID</label>
                                    <input type="text" class="settings-form-control" id="google_client_id"
                                        value="123456789012-abcdefghijklmnopqrstuvwxyz123456.apps.googleusercontent.com">
                                    <span class="settings-form-hint">Your Google Client ID</span>
                                </div>
                            </div>
                            <div class="settings-form-col">
                                <div class="settings-form-group">
                                    <label class="settings-form-label" for="google_client_secret">Google Client
                                        Secret</label>
                                    <input type="password" class="settings-form-control" id="google_client_secret"
                                        value="abcdef123456789">
                                    <span class="settings-form-hint">Your Google Client Secret</span>
                                </div>
                            </div>
                        </div>

                        <div class="settings-form-group">
                            <label class="settings-toggle-label">
                                <span class="settings-toggle-text">Enable Twitter Login</span>
                                <label class="settings-toggle">
                                    <input type="checkbox">
                                    <span class="settings-toggle-slider"></span>
                                </label>
                            </label>
                            <span class="settings-form-hint">Allow users to login with Twitter</span>
                        </div>

                        <div class="settings-form-group">
                            <label class="settings-toggle-label">
                                <span class="settings-toggle-text">Enable Apple Login</span>
                                <label class="settings-toggle">
                                    <input type="checkbox">
                                    <span class="settings-toggle-slider"></span>
                                </label>
                            </label>
                            <span class="settings-form-hint">Allow users to login with Apple</span>
                        </div>
                    </div>

                    <div class="settings-section">
                        <h3 class="settings-section-title">Social Sharing</h3>

                        <div class="settings-form-group">
                            <label class="settings-toggle-label">
                                <span class="settings-toggle-text">Enable Social Sharing Buttons</span>
                                <label class="settings-toggle">
                                    <input type="checkbox" checked>
                                    <span class="settings-toggle-slider"></span>
                                </label>
                            </label>
                            <span class="settings-form-hint">Display social sharing buttons on pages</span>
                        </div>

                        <div class="settings-form-group">
                            <label class="settings-form-label">Select Social Networks for Sharing</label>
                            <div class="settings-form-group">
                                <label class="settings-toggle-label">
                                    <span class="settings-toggle-text">Facebook</span>
                                    <label class="settings-toggle">
                                        <input type="checkbox" checked>
                                        <span class="settings-toggle-slider"></span>
                                    </label>
                                </label>
                            </div>
                            <div class="settings-form-group">
                                <label class="settings-toggle-label">
                                    <span class="settings-toggle-text">Twitter</span>
                                    <label class="settings-toggle">
                                        <input type="checkbox" checked>
                                        <span class="settings-toggle-slider"></span>
                                    </label>
                                </label>
                            </div>
                            <div class="settings-form-group">
                                <label class="settings-toggle-label">
                                    <span class="settings-toggle-text">LinkedIn</span>
                                    <label class="settings-toggle">
                                        <input type="checkbox" checked>
                                        <span class="settings-toggle-slider"></span>
                                    </label>
                                </label>
                            </div>
                            <div class="settings-form-group">
                                <label class="settings-toggle-label">
                                    <span class="settings-toggle-text">WhatsApp</span>
                                    <label class="settings-toggle">
                                        <input type="checkbox" checked>
                                        <span class="settings-toggle-slider"></span>
                                    </label>
                                </label>
                            </div>
                            <div class="settings-form-group">
                                <label class="settings-toggle-label">
                                    <span class="settings-toggle-text">Email</span>
                                    <label class="settings-toggle">
                                        <input type="checkbox" checked>
                                        <span class="settings-toggle-slider"></span>
                                    </label>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="settings-form-actions">
                        <button class="btn btn-outline">Reset to Default</button>
                        <button class="btn btn-primary">Save Changes</button>
                    </div>
                </div>

                <!-- API Settings -->
                <div class="settings-tab" id="api-tab">
                    <div class="settings-section">
                        <h3 class="settings-section-title">API Configuration</h3>

                        <div class="settings-form-group">
                            <label class="settings-toggle-label">
                                <span class="settings-toggle-text">Enable API Access</span>
                                <label class="settings-toggle">
                                    <input type="checkbox" checked>
                                    <span class="settings-toggle-slider"></span>
                                </label>
                            </label>
                            <span class="settings-form-hint">Allow external applications to access the API</span>
                        </div>

                        <div class="settings-form-group">
                            <label class="settings-form-label" for="api_rate_limit">API Rate Limit (requests per
                                minute)</label>
                            <input type="number" class="settings-form-control" id="api_rate_limit" value="60"
                                min="10" max="1000">
                            <span class="settings-form-hint">Maximum number of API requests allowed per minute</span>
                        </div>

                        <div class="settings-form-group">
                            <label class="settings-toggle-label">
                                <span class="settings-toggle-text">Require API Authentication</span>
                                <label class="settings-toggle">
                                    <input type="checkbox" checked>
                                    <span class="settings-toggle-slider"></span>
                                </label>
                            </label>
                            <span class="settings-form-hint">Require API keys for all API requests</span>
                        </div>
                    </div>

                    <div class="settings-section">
                        <h3 class="settings-section-title">API Keys</h3>

                        <div class="settings-card">
                            <div class="settings-card-header">
                                <h4 class="settings-card-title">Mobile App</h4>
                                <button class="btn btn-sm btn-outline btn-danger">
                                    <i class="fas fa-sync-alt"></i> Regenerate
                                </button>
                            </div>
                            <div class="settings-card-body">
                                <div class="api-key">
                                    <div class="api-key-value">wc2030_api_key_123456789abcdef0123456789abcdef0123456789
                                    </div>
                                    <button class="btn btn-sm btn-outline">
                                        <i class="fas fa-copy"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="settings-card">
                            <div class="settings-card-header">
                                <h4 class="settings-card-title">Partner Integration</h4>
                                <button class="btn btn-sm btn-outline btn-danger">
                                    <i class="fas fa-sync-alt"></i> Regenerate
                                </button>
                            </div>
                            <div class="settings-card-body">
                                <div class="api-key">
                                    <div class="api-key-value">wc2030_api_key_abcdef0123456789abcdef0123456789abcdef01
                                    </div>
                                    <button class="btn btn-sm btn-outline">
                                        <i class="fas fa-copy"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="settings-card">
                            <div class="settings-card-header">
                                <h4 class="settings-card-title">Website Integration</h4>
                                <button class="btn btn-sm btn-outline btn-danger">
                                    <i class="fas fa-sync-alt"></i> Regenerate
                                </button>
                            </div>
                            <div class="settings-card-body">
                                <div class="api-key">
                                    <div class="api-key-value">wc2030_api_key_0123456789abcdef0123456789abcdef01234567
                                    </div>
                                    <button class="btn btn-sm btn-outline">
                                        <i class="fas fa-copy"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="settings-form-group">
                            <button class="btn btn-outline">
                                <i class="fas fa-plus"></i> Create New API Key
                            </button>
                        </div>
                    </div>

                    <div class="settings-section">
                        <h3 class="settings-section-title">Webhooks</h3>

                        <div class="settings-card">
                            <div class="settings-card-header">
                                <h4 class="settings-card-title">Ticket Purchase Webhook</h4>
                                <button class="btn btn-sm btn-outline">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                            </div>
                            <div class="settings-card-body">
                                <div class="settings-form-group">
                                    <label class="settings-form-label">Endpoint URL</label>
                                    <div class="api-key">
                                        <div class="api-key-value">https://partner-site.com/webhooks/ticket-purchase</div>
                                    </div>
                                </div>
                                <div class="settings-form-group">
                                    <label class="settings-toggle-label">
                                        <span class="settings-toggle-text">Active</span>
                                        <label class="settings-toggle">
                                            <input type="checkbox" checked>
                                            <span class="settings-toggle-slider"></span>
                                        </label>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="settings-card">
                            <div class="settings-card-header">
                                <h4 class="settings-card-title">User Registration Webhook</h4>
                                <button class="btn btn-sm btn-outline">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                            </div>
                            <div class="settings-card-body">
                                <div class="settings-form-group">
                                    <label class="settings-form-label">Endpoint URL</label>
                                    <div class="api-key">
                                        <div class="api-key-value">https://partner-site.com/webhooks/user-registration
                                        </div>
                                    </div>
                                </div>
                                <div class="settings-form-group">
                                    <label class="settings-toggle-label">
                                        <span class="settings-toggle-text">Active</span>
                                        <label class="settings-toggle">
                                            <input type="checkbox" checked>
                                            <span class="settings-toggle-slider"></span>
                                        </label>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="settings-form-group">
                            <button class="btn btn-outline">
                                <i class="fas fa-plus"></i> Add New Webhook
                            </button>
                        </div>
                    </div>

                    <div class="settings-form-actions">
                        <button class="btn btn-outline">Reset to Default</button>
                        <button class="btn btn-primary">Save Changes</button>
                    </div>
                </div>

                <!-- Cache & Performance Settings -->
                <div class="settings-tab" id="cache-tab">
                    <div class="settings-section">
                        <h3 class="settings-section-title">Cache Statistics</h3>

                        <div class="cache-stats">
                            <div class="cache-stat-card">
                                <div class="cache-stat-icon">
                                    <i class="fas fa-database"></i>
                                </div>
                                <div class="cache-stat-value">256 MB</div>
                                <div class="cache-stat-label">Cache Size</div>
                            </div>

                            <div class="cache-stat-card">
                                <div class="cache-stat-icon">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <div class="cache-stat-value">24 hours</div>
                                <div class="cache-stat-label">Cache Lifetime</div>
                            </div>

                            <div class="cache-stat-card">
                                <div class="cache-stat-icon">
                                    <i class="fas fa-tachometer-alt"></i>
                                </div>
                                <div class="cache-stat-value">98%</div>
                                <div class="cache-stat-label">Hit Rate</div>
                            </div>

                            <div class="cache-stat-card">
                                <div class="cache-stat-icon">
                                    <i class="fas fa-calendar-alt"></i>
                                </div>
                                <div class="cache-stat-value">2 hours ago</div>
                                <div class="cache-stat-label">Last Cleared</div>
                            </div>
                        </div>

                        <div class="settings-form-group">
                            <div class="settings-form-row">
                                <div class="settings-form-col">
                                    <button class="btn btn-outline">
                                        <i class="fas fa-sync-alt"></i> Clear Cache
                                    </button>
                                </div>
                                <div class="settings-form-col">
                                    <button class="btn btn-outline">
                                        <i class="fas fa-chart-line"></i> View Detailed Stats
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="settings-section">
                        <h3 class="settings-section-title">Cache Configuration</h3>

                        <div class="settings-form-group">
                            <label class="settings-toggle-label">
                                <span class="settings-toggle-text">Enable Page Caching</span>
                                <label class="settings-toggle">
                                    <input type="checkbox" checked>
                                    <span class="settings-toggle-slider"></span>
                                </label>
                            </label>
                            <span class="settings-form-hint">Cache entire pages for faster loading</span>
                        </div>

                        <div class="settings-form-group">
                            <label class="settings-toggle-label">
                                <span class="settings-toggle-text">Enable Database Query Caching</span>
                                <label class="settings-toggle">
                                    <input type="checkbox" checked>
                                    <span class="settings-toggle-slider"></span>
                                </label>
                            </label>
                            <span class="settings-form-hint">Cache database query results</span>
                        </div>

                        <div class="settings-form-group">
                            <label class="settings-toggle-label">
                                <span class="settings-toggle-text">Enable API Response Caching</span>
                                <label class="settings-toggle">
                                    <input type="checkbox" checked>
                                    <span class="settings-toggle-slider"></span>
                                </label>
                            </label>
                            <span class="settings-form-hint">Cache API responses</span>
                        </div>

                        <div class="settings-form-group">
                            <label class="settings-form-label" for="cache_lifetime">Cache Lifetime (hours)</label>
                            <input type="number" class="settings-form-control" id="cache_lifetime" value="24"
                                min="1" max="168">
                            <span class="settings-form-hint">How long items should remain in the cache</span>
                        </div>

                        <div class="settings-form-group">
                            <label class="settings-form-label" for="cache_driver">Cache Driver</label>
                            <select class="settings-form-control" id="cache_driver">
                                <option value="file">File</option>
                                <option value="redis" selected>Redis</option>
                                <option value="memcached">Memcached</option>
                                <option value="database">Database</option>
                            </select>
                            <span class="settings-form-hint">Storage mechanism for the cache</span>
                        </div>
                    </div>

                    <div class="settings-section">
                        <h3 class="settings-section-title">Performance Optimization</h3>

                        <div class="settings-form-group">
                            <label class="settings-toggle-label">
                                <span class="settings-toggle-text">Minify HTML</span>
                                <label class="settings-toggle">
                                    <input type="checkbox" checked>
                                    <span class="settings-toggle-slider"></span>
                                </label>
                            </label>
                            <span class="settings-form-hint">Remove whitespace and comments from HTML</span>
                        </div>

                        <div class="settings-form-group">
                            <label class="settings-toggle-label">
                                <span class="settings-toggle-text">Minify CSS</span>
                                <label class="settings-toggle">
                                    <input type="checkbox" checked>
                                    <span class="settings-toggle-slider"></span>
                                </label>
                            </label>
                            <span class="settings-form-hint">Compress CSS files</span>
                        </div>

                        <div class="settings-form-group">
                            <label class="settings-toggle-label">
                                <span class="settings-toggle-text">Minify JavaScript</span>
                                <label class="settings-toggle">
                                    <input type="checkbox" checked>
                                    <span class="settings-toggle-slider"></span>
                                </label>
                            </label>
                            <span class="settings-form-hint">Compress JavaScript files</span>
                        </div>

                        <div class="settings-form-group">
                            <label class="settings-toggle-label">
                                <span class="settings-toggle-text">Optimize Images</span>
                                <label class="settings-toggle">
                                    <input type="checkbox" checked>
                                    <span class="settings-toggle-slider"></span>
                                </label>
                            </label>
                            <span class="settings-form-hint">Automatically compress and optimize images</span>
                        </div>

                        <div class="settings-form-group">
                            <label class="settings-toggle-label">
                                <span class="settings-toggle-text">Enable Lazy Loading</span>
                                <label class="settings-toggle">
                                    <input type="checkbox" checked>
                                    <span class="settings-toggle-slider"></span>
                                </label>
                            </label>
                            <span class="settings-form-hint">Load images and videos only when they enter the
                                viewport</span>
                        </div>

                        <div class="settings-form-group">
                            <label class="settings-toggle-label">
                                <span class="settings-toggle-text">Enable Browser Caching</span>
                                <label class="settings-toggle">
                                    <input type="checkbox" checked>
                                    <span class="settings-toggle-slider"></span>
                                </label>
                            </label>
                            <span class="settings-form-hint">Set appropriate cache headers for browser caching</span>
                        </div>
                    </div>

                    <div class="settings-form-actions">
                        <button class="btn btn-outline">Reset to Default</button>
                        <button class="btn btn-primary">Save Changes</button>
                    </div>
                </div>

                <!-- Backup & Restore Settings -->
                <div class="settings-tab" id="backup-tab">
                    <div class="settings-section">
                        <h3 class="settings-section-title">Backup Configuration</h3>

                        <div class="settings-form-group">
                            <label class="settings-toggle-label">
                                <span class="settings-toggle-text">Enable Automatic Backups</span>
                                <label class="settings-toggle">
                                    <input type="checkbox" checked>
                                    <span class="settings-toggle-slider"></span>
                                </label>
                            </label>
                            <span class="settings-form-hint">Automatically create backups on a schedule</span>
                        </div>

                        <div class="settings-form-group">
                            <label class="settings-form-label" for="backup_frequency">Backup Frequency</label>
                            <select class="settings-form-control" id="backup_frequency">
                                <option value="daily" selected>Daily</option>
                                <option value="weekly">Weekly</option>
                                <option value="monthly">Monthly</option>
                            </select>
                            <span class="settings-form-hint">How often automatic backups should be created</span>
                        </div>

                        <div class="settings-form-group">
                            <label class="settings-form-label" for="backup_retention">Backup Retention (days)</label>
                            <input type="number" class="settings-form-control" id="backup_retention" value="30"
                                min="1" max="365">
                            <span class="settings-form-hint">How long backups should be kept before being deleted</span>
                        </div>

                        <div class="settings-form-group">
                            <label class="settings-form-label" for="backup_storage">Backup Storage</label>
                            <select class="settings-form-control" id="backup_storage">
                                <option value="local" selected>Local Storage</option>
                                <option value="s3">Amazon S3</option>
                                <option value="dropbox">Dropbox</option>
                                <option value="google">Google Drive</option>
                            </select>
                            <span class="settings-form-hint">Where backups should be stored</span>
                        </div>

                        <div class="settings-form-group">
                            <button class="btn btn-primary">
                                <i class="fas fa-download"></i> Create Backup Now
                            </button>
                        </div>
                    </div>

                    <div class="settings-section">
                        <h3 class="settings-section-title">Available Backups</h3>

                        <div class="settings-card">
                            <div class="settings-card-header">
                                <h4 class="settings-card-title">Backup - March 14, 2025 (10:30 AM)</h4>
                                <div>
                                    <span class="badge badge-success">Complete</span>
                                </div>
                            </div>
                            <div class="settings-card-body">
                                <div class="settings-form-row">
                                    <div class="settings-form-col">
                                        <div class="settings-form-group">
                                            <label class="settings-form-label">Size</label>
                                            <div>256 MB</div>
                                        </div>
                                    </div>
                                    <div class="settings-form-col">
                                        <div class="settings-form-group">
                                            <label class="settings-form-label">Type</label>
                                            <div>Full Backup</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="settings-card-footer">
                                <button class="btn btn-sm btn-outline">
                                    <i class="fas fa-download"></i> Download
                                </button>
                                <button class="btn btn-sm btn-outline">
                                    <i class="fas fa-undo"></i> Restore
                                </button>
                                <button class="btn btn-sm btn-outline btn-danger">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </div>
                        </div>

                        <div class="settings-card">
                            <div class="settings-card-header">
                                <h4 class="settings-card-title">Backup - March 13, 2025 (10:30 AM)</h4>
                                <div>
                                    <span class="badge badge-success">Complete</span>
                                </div>
                            </div>
                            <div class="settings-card-body">
                                <div class="settings-form-row">
                                    <div class="settings-form-col">
                                        <div class="settings-form-group">
                                            <label class="settings-form-label">Size</label>
                                            <div>254 MB</div>
                                        </div>
                                    </div>
                                    <div class="settings-form-col">
                                        <div class="settings-form-group">
                                            <label class="settings-form-label">Type</label>
                                            <div>Full Backup</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="settings-card-footer">
                                <button class="btn btn-sm btn-outline">
                                    <i class="fas fa-download"></i> Download
                                </button>
                                <button class="btn btn-sm btn-outline">
                                    <i class="fas fa-undo"></i> Restore
                                </button>
                                <button class="btn btn-sm btn-outline btn-danger">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </div>
                        </div>

                        <div class="settings-card">
                            <div class="settings-card-header">
                                <h4 class="settings-card-title">Backup - March 12, 2025 (10:30 AM)</h4>
                                <div>
                                    <span class="badge badge-success">Complete</span>
                                </div>
                            </div>
                            <div class="settings-card-body">
                                <div class="settings-form-row">
                                    <div class="settings-form-col">
                                        <div class="settings-form-group">
                                            <label class="settings-form-label">Size</label>
                                            <div>252 MB</div>
                                        </div>
                                    </div>
                                    <div class="settings-form-col">
                                        <div class="settings-form-group">
                                            <label class="settings-form-label">Type</label>
                                            <div>Full Backup</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="settings-card-footer">
                                <button class="btn btn-sm btn-outline">
                                    <i class="fas fa-download"></i> Download
                                </button>
                                <button class="btn btn-sm btn-outline">
                                    <i class="fas fa-undo"></i> Restore
                                </button>
                                <button class="btn btn-sm btn-outline btn-danger">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="settings-section">
                        <h3 class="settings-section-title">Restore</h3>

                        <div class="settings-form-group">
                            <label class="settings-form-label">Upload Backup File</label>
                            <div class="settings-form-row">
                                <div class="settings-form-col">
                                    <input type="file" class="settings-form-control" id="backup_file">
                                </div>
                                <div class="settings-form-col-small">
                                    <button class="btn btn-outline">
                                        <i class="fas fa-upload"></i> Upload
                                    </button>
                                </div>
                            </div>
                            <span class="settings-form-hint">Upload a backup file to restore</span>
                        </div>
                    </div>

                    <div class="settings-form-actions">
                        <button class="btn btn-outline">Reset to Default</button>
                        <button class="btn btn-primary">Save Changes</button>
                    </div>
                </div>

                <!-- Logs Settings -->
                <div class="settings-tab" id="logs-tab">
                    <div class="settings-section">
                        <h3 class="settings-section-title">Log Configuration</h3>

                        <div class="settings-form-group">
                            <label class="settings-form-label" for="log_level">Log Level</label>
                            <select class="settings-form-control" id="log_level">
                                <option value="debug">Debug</option>
                                <option value="info" selected>Info</option>
                                <option value="warning">Warning</option>
                                <option value="error">Error</option>
                                <option value="critical">Critical</option>
                            </select>
                            <span class="settings-form-hint">Minimum severity level of events to log</span>
                        </div>

                        <div class="settings-form-group">
                            <label class="settings-form-label" for="log_retention">Log Retention (days)</label>
                            <input type="number" class="settings-form-control" id="log_retention" value="30"
                                min="1" max="365">
                            <span class="settings-form-hint">How long logs should be kept before being deleted</span>
                        </div>

                        <div class="settings-form-group">
                            <label class="settings-toggle-label">
                                <span class="settings-toggle-text">Log Database Queries</span>
                                <label class="settings-toggle">
                                    <input type="checkbox">
                                    <span class="settings-toggle-slider"></span>
                                </label>
                            </label>
                            <span class="settings-form-hint">Log all database queries (reduces performance)</span>
                        </div>

                        <div class="settings-form-group">
                            <label class="settings-toggle-label">
                                <span class="settings-toggle-text">Log API Requests</span>
                                <label class="settings-toggle">
                                    <input type="checkbox" checked>
                                    <span class="settings-toggle-slider"></span>
                                </label>
                            </label>
                            <span class="settings-form-hint">Log all API requests</span>
                        </div>

                        <div class="settings-form-group">
                            <label class="settings-toggle-label">
                                <span class="settings-toggle-text">Log Authentication Events</span>
                                <label class="settings-toggle">
                                    <input type="checkbox" checked>
                                    <span class="settings-toggle-slider"></span>
                                </label>
                            </label>
                            <span class="settings-form-hint">Log all login attempts and authentication events</span>
                        </div>
                    </div>

                    <div class="settings-section">
                        <h3 class="settings-section-title">Recent Logs</h3>

                        <div class="settings-form-group">
                            <label class="settings-form-label" for="log_filter">Filter Logs</label>
                            <div class="settings-form-row">
                                <div class="settings-form-col">
                                    <select class="settings-form-control" id="log_filter">
                                        <option value="all" selected>All Logs</option>
                                        <option value="error">Errors Only</option>
                                        <option value="auth">Authentication Only</option>
                                        <option value="api">API Only</option>
                                    </select>
                                </div>
                                <div class="settings-form-col-small">
                                    <button class="btn btn-outline">
                                        <i class="fas fa-filter"></i> Filter
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="settings-card">
                            <div class="settings-card-body">
                                <div class="log-viewer"
                                    style="height: 400px; overflow-y: auto; font-family: monospace; font-size: 0.85rem; background-color: #f8f9fa; padding: 15px; border-radius: var(--border-radius);">
                                    <div class="log-entry"
                                        style="margin-bottom: 10px; padding-bottom: 10px; border-bottom: 1px solid #e9ecef;">
                                        <div style="color: #dc3545;">[ERROR] [2025-03-14 10:45:23] Failed login attempt
                                            for user john.doe@example.com from IP 192.168.1.1</div>
                                    </div>
                                    <div class="log-entry"
                                        style="margin-bottom: 10px; padding-bottom: 10px; border-bottom: 1px solid #e9ecef;">
                                        <div style="color: #28a745;">[INFO] [2025-03-14 10:44:12] User
                                            john.doe@example.com logged in successfully</div>
                                    </div>
                                    <div class="log-entry"
                                        style="margin-bottom: 10px; padding-bottom: 10px; border-bottom: 1px solid #e9ecef;">
                                        <div style="color: #17a2b8;">[INFO] [2025-03-14 10:43:45] API request to
                                            /api/matches from 192.168.1.1</div>
                                    </div>
                                    <div class="log-entry"
                                        style="margin-bottom: 10px; padding-bottom: 10px; border-bottom: 1px solid #e9ecef;">
                                        <div style="color: #ffc107;">[WARNING] [2025-03-14 10:42:30] High server load
                                            detected: CPU usage at 85%</div>
                                    </div>
                                    <div class="log-entry"
                                        style="margin-bottom: 10px; padding-bottom: 10px; border-bottom: 1px solid #e9ecef;">
                                        <div style="color: #17a2b8;">[INFO] [2025-03-14 10:41:15] Ticket purchase
                                            successful for user jane.smith@example.com</div>
                                    </div>
                                    <div class="log-entry"
                                        style="margin-bottom: 10px; padding-bottom: 10px; border-bottom: 1px solid #e9ecef;">
                                        <div style="color: #17a2b8;">[INFO] [2025-03-14 10:40:22] New user registration:
                                            jane.smith@example.com</div>
                                    </div>
                                    <div class="log-entry"
                                        style="margin-bottom: 10px; padding-bottom: 10px; border-bottom: 1px solid #e9ecef;">
                                        <div style="color: #dc3545;">[ERROR] [2025-03-14 10:39:10] Payment gateway error:
                                            Transaction declined</div>
                                    </div>
                                    <div class="log-entry"
                                        style="margin-bottom: 10px; padding-bottom: 10px; border-bottom: 1px solid #e9ecef;">
                                        <div style="color: #17a2b8;">[INFO] [2025-03-14 10:38:45] API request to
                                            /api/tickets from 192.168.1.2</div>
                                    </div>
                                </div>
                            </div>
                            <div class="settings-card-footer">
                                <button class="btn btn-outline">
                                    <i class="fas fa-download"></i> Download Logs
                                </button>
                                <button class="btn btn-outline btn-danger">
                                    <i class="fas fa-trash"></i> Clear Logs
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="settings-form-actions">
                        <button class="btn btn-outline">Reset to Default</button>
                        <button class="btn btn-primary">Save Changes</button>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('modal')
    <!-- Edit Email Template Modal -->
    <div class="modal" id="emailTemplateModal">
        <div class="modal-content modal-lg">
            <div class="modal-header">
                <h3 class="modal-title" id="emailTemplateModalTitle">Edit Email Template</h3>
                <button class="modal-close" id="closeEmailTemplateModal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="settings-form-group">
                    <label class="settings-form-label" for="template_name">Template Name</label>
                    <input type="text" class="settings-form-control" id="template_name" value="Welcome Email">
                </div>

                <div class="settings-form-group">
                    <label class="settings-form-label" for="template_subject">Email Subject</label>
                    <input type="text" class="settings-form-control" id="template_subject"
                        value="Welcome to World Cup 2030!">
                </div>

                <div class="settings-form-group">
                    <label class="settings-form-label" for="template_content">Email Content</label>
                    <textarea class="settings-form-control" id="template_content" rows="15" style="font-family: monospace;">

                </textarea>
                </div>

                <div class="settings-form-group">
                    <label class="settings-form-label">Available Variables</label>
                    <div class="settings-form-row">
                        <div class="settings-form-col">
                            <div class="badge badge-secondary" style="margin-right: 5px; margin-bottom: 5px;">user_name
                            </div>
                            <div class="badge badge-secondary" style="margin-right: 5px; margin-bottom: 5px;">user_email
                            </div>
                            <div class="badge badge-secondary" style="margin-right: 5px; margin-bottom: 5px;">
                                verification_link</div>
                        </div>
                        <div class="settings-form-col">
                            <div class="badge badge-secondary" style="margin-right: 5px; margin-bottom: 5px;">site_name
                            </div>
                            <div class="badge badge-secondary" style="margin-right: 5px; margin-bottom: 5px;">site_url
                            </div>
                            <div class="badge badge-secondary" style="margin-right: 5px; margin-bottom: 5px;">
                                current_date</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-outline">
                    <i class="fas fa-paper-plane"></i> Send Test Email
                </button>
                <button class="btn btn-outline">Cancel</button>
                <button class="btn btn-primary">Save Template</button>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Mobile menu toggle
            const menuToggle = document.getElementById('menu-toggle');
            const sidebar = document.querySelector('.admin-sidebar');

            if (menuToggle && sidebar) {
                menuToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('show');
                });
            }

            // Settings navigation
            const settingsNavLinks = document.querySelectorAll('.settings-nav-link');
            const settingsTabs = document.querySelectorAll('.settings-tab');

            // First, hide all tabs except the first one
            settingsTabs.forEach((tab, index) => {
                if (index === 0) {
                    tab.classList.add('active');
                } else {
                    tab.classList.remove('active');
                }
            });

            if (settingsNavLinks.length) {
                settingsNavLinks.forEach(link => {
                    link.addEventListener('click', function(e) {
                        e.preventDefault();

                        const tabId = this.getAttribute('data-tab');

                        // Remove active class from all links and tabs
                        settingsNavLinks.forEach(l => l.classList.remove('active'));
                        settingsTabs.forEach(t => t.classList.remove('active'));

                        // Add active class to current link and tab
                        this.classList.add('active');

                        const activeTab = document.getElementById(`${tabId}-tab`);
                        if (activeTab) {
                            activeTab.classList.add('active');
                            console.log(`Activated tab: ${tabId}-tab`);
                        } else {
                            console.error(`Tab with ID ${tabId}-tab not found`);
                        }
                    });
                });
            }

            // Color picker
            const colorOptions = document.querySelectorAll('.color-option');

            if (colorOptions.length) {
                colorOptions.forEach(option => {
                    option.addEventListener('click', function() {
                        // Remove active class from all options in the same color picker
                        const colorPicker = this.closest('.color-picker');
                        colorPicker.querySelectorAll('.color-option').forEach(o => o.classList
                            .remove('active'));

                        // Add active class to clicked option
                        this.classList.add('active');
                    });
                });
            }

            // Email Template Modal
            const emailTemplateModal = document.getElementById('emailTemplateModal');
            const editTemplateButtons = document.querySelectorAll('.btn-sm.btn-outline');
            const closeEmailTemplateModal = document.getElementById('closeEmailTemplateModal');

            if (editTemplateButtons.length && emailTemplateModal) {
                editTemplateButtons.forEach(btn => {
                    if (btn.querySelector('.fas.fa-edit')) {
                        btn.addEventListener('click', function() {
                            emailTemplateModal.style.display = 'flex';
                        });
                    }
                });
            }

            if (closeEmailTemplateModal && emailTemplateModal) {
                closeEmailTemplateModal.addEventListener('click', function() {
                    emailTemplateModal.style.display = 'none';
                });
            }

            // Save All Settings Button
            const saveAllSettingsBtn = document.getElementById('saveAllSettingsBtn');

            if (saveAllSettingsBtn) {
                saveAllSettingsBtn.addEventListener('click', function() {
                    // Show success message
                    alert('All settings have been saved successfully!');
                });
            }
        });
    </script>
@endsection
