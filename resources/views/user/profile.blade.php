@extends('user.layout')

@section('title', 'My Profile - World Cup 2030')
@section('css')
    <style>
        .profile-container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .profile-header {
            display: flex;
            align-items: center;
            gap: 30px;
            margin-bottom: 40px;
            padding-bottom: 30px;
            border-bottom: 1px solid var(--gray-300);
        }

        .profile-avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            overflow: hidden;
            border: 4px solid var(--primary);
            box-shadow: var(--shadow-md);
        }

        .profile-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .profile-info {
            flex: 1;
        }

        .profile-name {
            font-size: 2rem;
            font-weight: 700;
            color: var(--secondary);
            margin-bottom: 5px;
        }

        .profile-email {
            font-size: 1rem;
            color: var(--gray-600);
            margin-bottom: 15px;
        }

        .profile-stats {
            display: flex;
            gap: 20px;
        }

        .stat-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 10px 15px;
            background-color: var(--gray-100);
            border-radius: var(--border-radius);
        }

        .stat-value {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary);
        }

        .stat-label {
            font-size: 0.8rem;
            color: var(--gray-600);
        }

        .profile-actions {
            display: flex;
            gap: 10px;
        }

        .profile-tabs {
            display: flex;
            border-bottom: 1px solid var(--gray-300);
            margin-bottom: 30px;
        }

        .profile-tab {
            padding: 15px 20px;
            font-weight: 600;
            color: var(--gray-600);
            cursor: pointer;
            border-bottom: 3px solid transparent;
            transition: var(--transition);
        }

        .profile-tab.active {
            color: var(--primary);
            border-bottom-color: var(--primary);
        }

        .profile-tab:hover:not(.active) {
            color: var(--secondary);
            border-bottom-color: var(--gray-300);
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }

        .profile-section {
            background-color: white;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            margin-bottom: 30px;
            overflow: hidden;
        }

        .section-header {
            padding: 20px;
            border-bottom: 1px solid var(--gray-200);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .section-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--secondary);
        }

        .section-content {
            padding: 20px;
        }

        .form-row {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
        }

        .form-group {
            flex: 1;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: var(--gray-700);
        }

        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid var(--gray-300);
            border-radius: var(--border-radius);
            font-family: inherit;
            font-size: 1rem;
            transition: var(--transition);
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(230, 57, 70, 0.1);
        }

        .ticket-card {
            display: flex;
            background-color: var(--gray-100);
            border-radius: var(--border-radius);
            overflow: hidden;
            margin-bottom: 15px;
            transition: var(--transition);
        }

        .ticket-card:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow);
        }

        .ticket-info {
            flex: 1;
            padding: 15px;
        }

        .ticket-match {
            font-weight: 600;
            color: var(--secondary);
            margin-bottom: 5px;
        }

        .ticket-details {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-top: 10px;
            font-size: 0.9rem;
        }

        .ticket-detail {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .ticket-detail i {
            color: var(--primary);
        }

        .ticket-actions {
            display: flex;
            align-items: center;
            padding: 15px;
            background-color: white;
        }

        .activity-item {
            display: flex;
            gap: 15px;
            padding: 15px 0;
            border-bottom: 1px solid var(--gray-200);
        }

        .activity-item:last-child {
            border-bottom: none;
        }

        .activity-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--primary-light);
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .activity-content {
            flex: 1;
        }

        .activity-title {
            font-weight: 600;
            color: var(--secondary);
            margin-bottom: 5px;
        }

        .activity-time {
            font-size: 0.8rem;
            color: var(--gray-600);
        }

        .team-card {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 15px;
            background-color: var(--gray-100);
            border-radius: var(--border-radius);
            margin-bottom: 15px;
            transition: var(--transition);
        }

        .team-card:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow);
        }

        .team-flag {
            width: 60px;
            height: 40px;
            background-size: cover;
            background-position: center;
            border-radius: 4px;
            box-shadow: var(--shadow-sm);
        }

        .team-info {
            flex: 1;
        }

        .team-name {
            font-weight: 600;
            color: var(--secondary);
        }

        .team-stats {
            font-size: 0.8rem;
            color: var(--gray-600);
            margin-top: 5px;
        }

        .team-actions {
            display: flex;
            gap: 10px;
        }

        @media (max-width: 768px) {
            .profile-header {
                flex-direction: column;
                text-align: center;
                gap: 15px;
            }

            .profile-stats {
                justify-content: center;
            }

            .profile-actions {
                justify-content: center;
            }

            .form-row {
                flex-direction: column;
                gap: 15px;
            }

            .ticket-card {
                flex-direction: column;
            }

            .ticket-actions {
                justify-content: flex-end;
            }
        }
    </style>
@endsection

@section('content')
    <div class="profile-container">
        <!-- Profile Header -->
        <div class="profile-header">
            <div class="profile-avatar">
                <img src="https://cdn-icons-png.flaticon.com/128/3177/3177465.png" alt="{{ $user->firstname }} Avatar">
            </div>
            <div class="profile-info">
                <h1 class="profile-name">{{ $user->firstname }} {{ $user->lastname }}</h1>
                <div class="profile-email">{{ $user->email }}</div>
                <div class="profile-stats">
                    <div class="stat-item">
                        <div class="stat-value">{{ $tickets->count() }}</div>
                        <div class="stat-label">Tickets</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value">{{ $postCount }}</div>
                        <div class="stat-label">Forum Posts</div>
                    </div>
                </div>
            </div>
            <div class="profile-actions">
                <a href="#account-tab" class="btn btn-outline tab-link" data-tab="account">
                    <i class="fas fa-cog"></i> Settings
                </a>
                <a href="" class="btn btn-primary">
                    <i class="fas fa-ticket-alt"></i> Buy Tickets
                </a>
            </div>
        </div>

        <!-- Profile Tabs -->
        <div class="profile-tabs">
            <div class="profile-tab active" data-tab="tickets">My Tickets</div>
            <div class="profile-tab" data-tab="account">Account Settings</div>
            <div class="profile-tab" data-tab="activity">Activity</div>
        </div>

        <!-- Tickets Tab -->
        <div class="tab-content active" id="tickets-tab">
            <div class="profile-section">
                <div class="section-header">
                    <div class="section-title">My Tickets</div>
                    <button class="btn btn-sm btn-outline">
                        <i class="fas fa-filter"></i> Filter
                    </button>
                </div>
                <div class="section-content">
                    @if ($tickets->isEmpty())
                        <div class="empty-state">
                            <div class="empty-state-icon">
                                <i class="fas fa-ticket-alt"></i>
                            </div>
                            <h3>No Tickets Yet</h3>
                            <p>You haven't purchased any tickets for the World Cup 2030 matches.</p>
                            <a href="" class="btn btn-primary">Browse Tickets</a>
                        </div>
                    @else
                        @foreach ($tickets as $ticket)
                            <!-- Ticket Item -->
                            <div class="ticket-card">
                                <div class="ticket-info">
                                    <div class="ticket-match">{{ $ticket->game->homeTeam->name }} vs
                                        {{ $ticket->game->awayTeam->name }}</div>
                                    <div class="ticket-venue">{{ $ticket->game->stadium->name }},
                                        {{ $ticket->game->stadium->city }}</div>
                                    <div class="ticket-details">
                                        <div class="ticket-detail">
                                            <i class="far fa-calendar-alt"></i> {{ $ticket->game->date->format('F j, Y') }}
                                        </div>
                                        <div class="ticket-detail">
                                            <i class="far fa-clock"></i> {{ $ticket->game->time->format('H:i') }}
                                        </div>
                                        <div class="ticket-detail">
                                            <i class="fas fa-ticket-alt"></i> {{ $ticket->category->name }}
                                        </div>
                                        <div class="ticket-detail">
                                            <i class="fas fa-chair"></i> Seat: {{ $ticket->seat_number }}
                                        </div>
                                    </div>
                                </div>
                                <div class="ticket-actions">
                                    <a href="{{ route('tickets.download', $ticket->id) }}" class="btn btn-sm btn-outline">
                                        <i class="fas fa-download"></i> Download
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>



        <!-- Account Settings Tab -->
        <div class="tab-content" id="account-tab">
            <div class="profile-section">
                <div class="section-header">
                    <div class="section-title">Personal Information</div>
                </div>
                <div class="section-content">
                    <form id="profile-form" action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        <div class="form-row">
                            <div class="form-group">
                                <label for="firstname">First Name</label>
                                <input type="text" id="firstname" name="firstname"
                                    class="form-control @error('firstname') is-invalid @enderror"
                                    value="{{ old('firstname', $user->firstname) }}">
                                @error('firstname')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="lastname">Last Name</label>
                                <input type="text" id="lastname" name="lastname"
                                    class="form-control @error('lastname') is-invalid @enderror"
                                    value="{{ old('lastname', $user->lastname) }}">
                                @error('lastname')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="email">Email Address</label>
                                <input type="email" id="email" name="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    value="{{ old('email', $user->email) }}">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="phone">Phone Number</label>
                                <input type="tel" id="phone" name="phone"
                                    class="form-control @error('phone') is-invalid @enderror"
                                    value="{{ old('phone', $user->phone) }}">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="country">Country</label>
                                <select id="country" name="country"
                                    class="form-control @error('country') is-invalid @enderror">
                                    <option value="">Select a country</option>
                                    <option value="us" {{ old('country', $user->country) == 'us' ? 'selected' : '' }}>
                                        United States</option>
                                    <option value="ca" {{ old('country', $user->country) == 'ca' ? 'selected' : '' }}>
                                        Canada</option>
                                    <option value="uk" {{ old('country', $user->country) == 'uk' ? 'selected' : '' }}>
                                        United Kingdom</option>
                                    <option value="au" {{ old('country', $user->country) == 'au' ? 'selected' : '' }}>
                                        Australia</option>
                                    <option value="br" {{ old('country', $user->country) == 'br' ? 'selected' : '' }}>
                                        Brazil</option>
                                    <option value="fr" {{ old('country', $user->country) == 'fr' ? 'selected' : '' }}>
                                        France</option>
                                    <option value="de" {{ old('country', $user->country) == 'de' ? 'selected' : '' }}>
                                        Germany</option>
                                    <option value="es" {{ old('country', $user->country) == 'es' ? 'selected' : '' }}>
                                        Spain</option>
                                </select>
                                @error('country')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="language">Preferred Language</label>
                                <select id="language" name="language"
                                    class="form-control @error('language') is-invalid @enderror">
                                    <option value="">Select a language</option>
                                    <option value="en"
                                        {{ old('language', $user->language) == 'en' ? 'selected' : '' }}>English</option>
                                    <option value="es"
                                        {{ old('language', $user->language) == 'es' ? 'selected' : '' }}>Spanish</option>
                                    <option value="fr"
                                        {{ old('language', $user->language) == 'fr' ? 'selected' : '' }}>French</option>
                                    <option value="de"
                                        {{ old('language', $user->language) == 'de' ? 'selected' : '' }}>German</option>
                                    <option value="pt"
                                        {{ old('language', $user->language) == 'pt' ? 'selected' : '' }}>Portuguese
                                    </option>
                                </select>
                                @error('language')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="bio">Bio</label>
                            <textarea id="bio" name="bio" class="form-control @error('bio') is-invalid @enderror" rows="4">{{ old('bio', $user->bio) }}</textarea>
                            @error('bio')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-actions" style="text-align: right; margin-top: 20px;">
                            <button type="button" class="btn btn-outline"
                                onclick="resetForm('profile-form')">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="profile-section">
                <div class="section-header">
                    <div class="section-title">Change Password</div>
                </div>
                <div class="section-content">
                    <form id="password-form" action="{{ route('profile.password') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="current_password">Current Password</label>
                            <input type="password" id="current_password" name="current_password"
                                class="form-control @error('current_password') is-invalid @enderror">
                            @error('current_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="new_password">New Password</label>
                                <input type="password" id="new_password" name="new_password"
                                    class="form-control @error('new_password') is-invalid @enderror">
                                @error('new_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="new_password_confirmation">Confirm New Password</label>
                                <input type="password" id="new_password_confirmation" name="new_password_confirmation"
                                    class="form-control">
                            </div>
                        </div>
                        <div class="form-actions" style="text-align: right; margin-top: 20px;">
                            <button type="button" class="btn btn-outline"
                                onclick="resetForm('password-form')">Cancel</button>
                            <button type="submit" class="btn btn-primary">Update Password</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="profile-section">
                <div class="section-header">
                    <div class="section-title">Notification Settings</div>
                </div>
                <div class="section-content">
                    <form id="notification-form" action="{{ route('profile.notifications') }}" method="POST">
                        @csrf
                        <div class="notification-settings">
                            <div class="notification-item"
                                style="display: flex; justify-content: space-between; margin-bottom: 15px; padding-bottom: 15px; border-bottom: 1px solid var(--gray-200);">
                                <div>
                                    <h4 style="margin: 0 0 5px 0;">Email Notifications</h4>
                                    <p style="margin: 0; color: var(--gray-600); font-size: 0.9rem;">Receive updates about
                                        matches, tickets, and special offers</p>
                                </div>
                                <label class="switch"
                                    style="position: relative; display: inline-block; width: 50px; height: 24px;">
                                    <input type="checkbox" name="email_notifications"
                                        {{ $user->email_notifications ? 'checked' : '' }}
                                        style="opacity: 0; width: 0; height: 0;">
                                    <span
                                        style="position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: {{ $user->email_notifications ? 'var(--primary)' : 'var(--gray-300)' }}; border-radius: 34px; transition: .4s;"></span>
                                </label>
                            </div>
                            <div class="notification-item"
                                style="display: flex; justify-content: space-between; margin-bottom: 15px; padding-bottom: 15px; border-bottom: 1px solid var(--gray-200);">
                                <div>
                                    <h4 style="margin: 0 0 5px 0;">SMS Notifications</h4>
                                    <p style="margin: 0; color: var(--gray-600); font-size: 0.9rem;">Receive text messages
                                        for important updates</p>
                                </div>
                                <label class="switch"
                                    style="position: relative; display: inline-block; width: 50px; height: 24px;">
                                    <input type="checkbox" name="sms_notifications"
                                        {{ $user->sms_notifications ? 'checked' : '' }}
                                        style="opacity: 0; width: 0; height: 0;">
                                    <span
                                        style="position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: {{ $user->sms_notifications ? 'var(--primary)' : 'var(--gray-300)' }}; border-radius: 34px; transition: .4s;"></span>
                                </label>
                            </div>
                            <div class="notification-item"
                                style="display: flex; justify-content: space-between; margin-bottom: 15px; padding-bottom: 15px; border-bottom: 1px solid var(--gray-200);">
                                <div>
                                    <h4 style="margin: 0 0 5px 0;">Match Reminders</h4>
                                    <p style="margin: 0; color: var(--gray-600); font-size: 0.9rem;">Get notified before
                                        matches of your favorite teams</p>
                                </div>
                                <label class="switch"
                                    style="position: relative; display: inline-block; width: 50px; height: 24px;">
                                    <input type="checkbox" name="match_reminders"
                                        {{ $user->match_reminders ? 'checked' : '' }}
                                        style="opacity: 0; width: 0; height: 0;">
                                    <span
                                        style="position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: {{ $user->match_reminders ? 'var(--primary)' : 'var(--gray-300)' }}; border-radius: 34px; transition: .4s;"></span>
                                </label>
                            </div>
                            <div class="notification-item" style="display: flex; justify-content: space-between;">
                                <div>
                                    <h4 style="margin: 0 0 5px 0;">Forum Activity</h4>
                                    <p style="margin: 0; color: var(--gray-600); font-size: 0.9rem;">Get notified about
                                        replies to your posts</p>
                                </div>
                                <label class="switch"
                                    style="position: relative; display: inline-block; width: 50px; height: 24px;">
                                    <input type="checkbox" name="forum_notifications"
                                        {{ $user->forum_notifications ? 'checked' : '' }}
                                        style="opacity: 0; width: 0; height: 0;">
                                    <span
                                        style="position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: {{ $user->forum_notifications ? 'var(--primary)' : 'var(--gray-300)' }}; border-radius: 34px; transition: .4s;"></span>
                                </label>
                            </div>
                        </div>
                        <div class="form-actions" style="text-align: right; margin-top: 20px;">
                            <button type="submit" class="btn btn-primary">Save Notification Settings</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Activity Tab -->
        <div class="tab-content" id="activity-tab">
            <div class="profile-section">
                <div class="section-header">
                    <div class="section-title">Recent Activity</div>
                </div>
                <div class="section-content">
                    @if ($activities->isEmpty())
                        <div class="empty-state">
                            <div class="empty-state-icon">
                                <i class="fas fa-history"></i>
                            </div>
                            <h3>No Recent Activity</h3>
                            <p>Your recent activities will appear here.</p>
                        </div>
                    @else
                        @foreach ($activities as $activity)
                            <!-- Activity Item -->
                            <div class="activity-item">
                                <div class="activity-icon">
                                    <i class="fas fa-{{ $activity['icon'] }}"></i>
                                </div>
                                <div class="activity-content">
                                    <div class="activity-title">{{ $activity['title'] }}</div>
                                    <div class="activity-time">{{ $activity['time']->diffForHumans() }}</div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Tab switching functionality
            const tabs = document.querySelectorAll('.profile-tab');
            const tabContents = document.querySelectorAll('.tab-content');
            const tabLinks = document.querySelectorAll('.tab-link');

            function activateTab(tabId) {
                // Hide all tab contents
                tabContents.forEach(content => {
                    content.classList.remove('active');
                });

                // Show the selected tab content
                document.getElementById(tabId + '-tab').classList.add('active');

                // Update active tab
                tabs.forEach(tab => {
                    if (tab.getAttribute('data-tab') === tabId) {
                        tab.classList.add('active');
                    } else {
                        tab.classList.remove('active');
                    }
                });
            }

            tabs.forEach(tab => {
                tab.addEventListener('click', function() {
                    const tabId = this.getAttribute('data-tab');
                    activateTab(tabId);
                });
            });

            tabLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const tabId = this.getAttribute('data-tab');
                    activateTab(tabId);
                });
            });

            // Form reset function
            window.resetForm = function(formId) {
                document.getElementById(formId).reset();
            };

            // Check for hash in URL to activate specific tab
            if (window.location.hash) {
                const tabId = window.location.hash.substring(1).replace('-tab', '');
                activateTab(tabId);
            }
        });
    </script>
@endsection
