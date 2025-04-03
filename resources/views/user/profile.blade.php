@extends('user.layout')

@section('title', 'User Profile - World Cup 2030')

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
                <img src="https://via.placeholder.com/120x120" alt="User Avatar">
            </div>
            <div class="profile-info">
                <h1 class="profile-name">John Doe</h1>
                <div class="profile-email">johndoe@example.com</div>
                <div class="profile-stats">
                    <div class="stat-item">
                        <div class="stat-value">5</div>
                        <div class="stat-label">Tickets</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value">3</div>
                        <div class="stat-label">Favorite Teams</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value">8</div>
                        <div class="stat-label">Forum Posts</div>
                    </div>
                </div>
            </div>
            <div class="profile-actions">
                <button class="btn btn-outline">
                    <i class="fas fa-cog"></i> Settings
                </button>
                <button class="btn btn-primary">
                    <i class="fas fa-ticket-alt"></i> Buy Tickets
                </button>
            </div>
        </div>

        <!-- Profile Tabs -->
        <div class="profile-tabs">
            <div class="profile-tab active" data-tab="tickets">My Tickets</div>
            <div class="profile-tab" data-tab="teams">Favorite Teams</div>
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
                    <!-- Ticket Item -->
                    <div class="ticket-card">
                        <div class="ticket-info">
                            <div class="ticket-match">Brazil vs Germany</div>
                            <div class="ticket-venue">Rio Stadium, Brazil</div>
                            <div class="ticket-details">
                                <div class="ticket-detail">
                                    <i class="far fa-calendar-alt"></i> June 12, 2030
                                </div>
                                <div class="ticket-detail">
                                    <i class="far fa-clock"></i> 15:00
                                </div>
                                <div class="ticket-detail">
                                    <i class="fas fa-ticket-alt"></i> Category A
                                </div>
                                <div class="ticket-detail">
                                    <i class="fas fa-chair"></i> Seat: A-123
                                </div>
                            </div>
                        </div>
                        <div class="ticket-actions">
                            <button class="btn btn-sm btn-outline">
                                <i class="fas fa-download"></i> Download
                            </button>
                        </div>
                    </div>

                    <!-- Ticket Item -->
                    <div class="ticket-card">
                        <div class="ticket-info">
                            <div class="ticket-match">Spain vs Portugal</div>
                            <div class="ticket-venue">Madrid Stadium, Spain</div>
                            <div class="ticket-details">
                                <div class="ticket-detail">
                                    <i class="far fa-calendar-alt"></i> June 13, 2030
                                </div>
                                <div class="ticket-detail">
                                    <i class="far fa-clock"></i> 12:00
                                </div>
                                <div class="ticket-detail">
                                    <i class="fas fa-ticket-alt"></i> Category B
                                </div>
                                <div class="ticket-detail">
                                    <i class="fas fa-chair"></i> Seat: B-456
                                </div>
                            </div>
                        </div>
                        <div class="ticket-actions">
                            <button class="btn btn-sm btn-outline">
                                <i class="fas fa-download"></i> Download
                            </button>
                        </div>
                    </div>

                    <!-- Ticket Item -->
                    <div class="ticket-card">
                        <div class="ticket-info">
                            <div class="ticket-match">France vs Netherlands</div>
                            <div class="ticket-venue">Paris Stadium, France</div>
                            <div class="ticket-details">
                                <div class="ticket-detail">
                                    <i class="far fa-calendar-alt"></i> June 13, 2030
                                </div>
                                <div class="ticket-detail">
                                    <i class="far fa-clock"></i> 18:00
                                </div>
                                <div class="ticket-detail">
                                    <i class="fas fa-ticket-alt"></i> Category A
                                </div>
                                <div class="ticket-detail">
                                    <i class="fas fa-chair"></i> Seat: A-789
                                </div>
                            </div>
                        </div>
                        <div class="ticket-actions">
                            <button class="btn btn-sm btn-outline">
                                <i class="fas fa-download"></i> Download
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Favorite Teams Tab -->
        <div class="tab-content" id="teams-tab">
            <div class="profile-section">
                <div class="section-header">
                    <div class="section-title">Favorite Teams</div>
                    <button class="btn btn-sm btn-primary">
                        <i class="fas fa-plus"></i> Add Team
                    </button>
                </div>
                <div class="section-content">
                    <!-- Team Item -->
                    <div class="team-card">
                        <div class="team-flag"
                            style="background-image: url('https://via.placeholder.com/60x40/3498db/ffffff?text=BRA')"></div>
                        <div class="team-info">
                            <div class="team-name">Brazil</div>
                            <div class="team-stats">Group A • 5-time World Cup Champions</div>
                        </div>
                        <div class="team-actions">
                            <button class="btn btn-sm btn-outline">
                                <i class="fas fa-calendar-alt"></i> Matches
                            </button>
                            <button class="btn btn-sm btn-outline">
                                <i class="fas fa-star"></i> Following
                            </button>
                        </div>
                    </div>

                    <!-- Team Item -->
                    <div class="team-card">
                        <div class="team-flag"
                            style="background-image: url('https://via.placeholder.com/60x40/e74c3c/ffffff?text=GER')">
                        </div>
                        <div class="team-info">
                            <div class="team-name">Germany</div>
                            <div class="team-stats">Group B • 4-time World Cup Champions</div>
                        </div>
                        <div class="team-actions">
                            <button class="btn btn-sm btn-outline">
                                <i class="fas fa-calendar-alt"></i> Matches
                            </button>
                            <button class="btn btn-sm btn-outline">
                                <i class="fas fa-star"></i> Following
                            </button>
                        </div>
                    </div>

                    <!-- Team Item -->
                    <div class="team-card">
                        <div class="team-flag"
                            style="background-image: url('https://via.placeholder.com/60x40/f39c12/ffffff?text=ESP')">
                        </div>
                        <div class="team-info">
                            <div class="team-name">Spain</div>
                            <div class="team-stats">Group C • 1-time World Cup Champions</div>
                        </div>
                        <div class="team-actions">
                            <button class="btn btn-sm btn-outline">
                                <i class="fas fa-calendar-alt"></i> Matches
                            </button>
                            <button class="btn btn-sm btn-outline">
                                <i class="fas fa-star"></i> Following
                            </button>
                        </div>
                    </div>
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
                    <form id="profile-form">
                        <div class="form-row">
                            <div class="form-group">
                                <label for="first-name">First Name</label>
                                <input type="text" id="first-name" class="form-control" value="John">
                            </div>
                            <div class="form-group">
                                <label for="last-name">Last Name</label>
                                <input type="text" id="last-name" class="form-control" value="Doe">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="email">Email Address</label>
                                <input type="email" id="email" class="form-control" value="johndoe@example.com">
                            </div>
                            <div class="form-group">
                                <label for="phone">Phone Number</label>
                                <input type="tel" id="phone" class="form-control" value="+1 (555) 123-4567">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="country">Country</label>
                                <select id="country" class="form-control">
                                    <option value="us">United States</option>
                                    <option value="ca">Canada</option>
                                    <option value="uk">United Kingdom</option>
                                    <option value="au">Australia</option>
                                    <option value="br">Brazil</option>
                                    <option value="fr">France</option>
                                    <option value="de">Germany</option>
                                    <option value="es">Spain</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="language">Preferred Language</label>
                                <select id="language" class="form-control">
                                    <option value="en">English</option>
                                    <option value="es">Spanish</option>
                                    <option value="fr">French</option>
                                    <option value="de">German</option>
                                    <option value="pt">Portuguese</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="bio">Bio</label>
                            <textarea id="bio" class="form-control" rows="4">Football enthusiast and World Cup fan since 1998. Looking forward to the 2030 tournament!</textarea>
                        </div>
                        <div class="form-actions" style="text-align: right; margin-top: 20px;">
                            <button type="button" class="btn btn-outline">Cancel</button>
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
                    <form id="password-form">
                        <div class="form-group">
                            <label for="current-password">Current Password</label>
                            <input type="password" id="current-password" class="form-control">
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="new-password">New Password</label>
                                <input type="password" id="new-password" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="confirm-password">Confirm New Password</label>
                                <input type="password" id="confirm-password" class="form-control">
                            </div>
                        </div>
                        <div class="form-actions" style="text-align: right; margin-top: 20px;">
                            <button type="button" class="btn btn-outline">Cancel</button>
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
                                <input type="checkbox" checked style="opacity: 0; width: 0; height: 0;">
                                <span
                                    style="position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: var(--primary); border-radius: 34px; transition: .4s;"></span>
                            </label>
                        </div>
                        <div class="notification-item"
                            style="display: flex; justify-content: space-between; margin-bottom: 15px; padding-bottom: 15px; border-bottom: 1px solid var(--gray-200);">
                            <div>
                                <h4 style="margin: 0 0 5px 0;">SMS Notifications</h4>
                                <p style="margin: 0; color: var(--gray-600); font-size: 0.9rem;">Receive text messages for
                                    important updates</p>
                            </div>
                            <label class="switch"
                                style="position: relative; display: inline-block; width: 50px; height: 24px;">
                                <input type="checkbox" style="opacity: 0; width: 0; height: 0;">
                                <span
                                    style="position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: var(--gray-300); border-radius: 34px; transition: .4s;"></span>
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
                                <input type="checkbox" checked style="opacity: 0; width: 0; height: 0;">
                                <span
                                    style="position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: var(--primary); border-radius: 34px; transition: .4s;"></span>
                            </label>
                        </div>
                        <div class="notification-item" style="display: flex; justify-content: space-between;">
                            <div>
                                <h4 style="margin: 0 0 5px 0;">Forum Activity</h4>
                                <p style="margin: 0; color: var(--gray-600); font-size: 0.9rem;">Get notified about replies
                                    to your posts</p>
                            </div>
                            <label class="switch"
                                style="position: relative; display: inline-block; width: 50px; height: 24px;">
                                <input type="checkbox" checked style="opacity: 0; width: 0; height: 0;">
                                <span
                                    style="position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: var(--primary); border-radius: 34px; transition: .4s;"></span>
                            </label>
                        </div>
                    </div>
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
                    <!-- Activity Item -->
                    <div class="activity-item">
                        <div class="activity-icon">
                            <i class="fas fa-ticket-alt"></i>
                        </div>
                        <div class="activity-content">
                            <div class="activity-title">Purchased ticket for Brazil vs Germany</div>
                            <div class="activity-time">2 days ago</div>
                        </div>
                    </div>

                    <!-- Activity Item -->
                    <div class="activity-item">
                        <div class="activity-icon">
                            <i class="fas fa-star"></i>
                        </div>
                        <div class="activity-content">
                            <div class="activity-title">Added Spain to favorite teams</div>
                            <div class="activity-time">3 days ago</div>
                        </div>
                    </div>

                    <!-- Activity Item -->
                    <div class="activity-item">
                        <div class="activity-icon">
                            <i class="fas fa-comment"></i>
                        </div>
                        <div class="activity-content">
                            <div class="activity-title">Posted a comment in "World Cup 2030 Predictions" forum</div>
                            <div class="activity-time">5 days ago</div>
                        </div>
                    </div>

                    <!-- Activity Item -->
                    <div class="activity-item">
                        <div class="activity-icon">
                            <i class="fas fa-ticket-alt"></i>
                        </div>
                        <div class="activity-content">
                            <div class="activity-title">Purchased ticket for Spain vs Portugal</div>
                            <div class="activity-time">1 week ago</div>
                        </div>
                    </div>

                    <!-- Activity Item -->
                    <div class="activity-item">
                        <div class="activity-icon">
                            <i class="fas fa-user-edit"></i>
                        </div>
                        <div class="activity-content">
                            <div class="activity-title">Updated profile information</div>
                            <div class="activity-time">2 weeks ago</div>
                        </div>
                    </div>
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

            tabs.forEach(tab => {
                tab.addEventListener('click', function() {
                    const tabId = this.getAttribute('data-tab');

                    // Remove active class from all tabs and contents
                    tabs.forEach(t => t.classList.remove('active'));
                    tabContents.forEach(c => c.classList.remove('active'));

                    // Add active class to current tab and content
                    this.classList.add('active');
                    document.getElementById(`${tabId}-tab`).classList.add('active');
                });
            });

            // Form submission handling
            const profileForm = document.getElementById('profile-form');
            if (profileForm) {
                profileForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    // Show success message or handle form submission
                    alert('Profile updated successfully!');
                });
            }

            const passwordForm = document.getElementById('password-form');
            if (passwordForm) {
                passwordForm.addEventListener('submit', function(e) {
                    e.preventDefault();

                    const newPassword = document.getElementById('new-password').value;
                    const confirmPassword = document.getElementById('confirm-password').value;

                    if (newPassword !== confirmPassword) {
                        alert('Passwords do not match!');
                        return;
                    }

                    // Handle password update
                    alert('Password updated successfully!');
                    this.reset();
                });
            }
        });
    </script>
@endsection
