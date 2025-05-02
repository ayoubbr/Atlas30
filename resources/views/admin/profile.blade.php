@extends('admin.layout')

@section('title', 'Admin Profile - World Cup 2030')

@section('css')
    <style>
        .profile-container {
            display: grid;
            grid-template-columns: 1fr 2fr;
            gap: 30px;
            margin-bottom: 30px;
        }

        @media (max-width: 992px) {
            .profile-container {
                grid-template-columns: 1fr;
            }
        }

        .profile-card {
            background-color: white;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            overflow: hidden;
        }

        .profile-header {
            background-color: var(--primary);
            color: white;
            padding: 30px;
            text-align: center;
            position: relative;
        }

        .profile-avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            border: 5px solid rgba(255, 255, 255, 0.3);
            margin: 0 auto 15px;
            overflow: hidden;
            background-color: white;
        }

        .profile-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .profile-name {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .profile-role {
            font-size: 0.9rem;
            opacity: 0.9;
        }

        .profile-stats {
            display: flex;
            justify-content: space-around;
            padding: 20px;
            border-bottom: 1px solid var(--gray-200);
        }

        .profile-stat {
            text-align: center;
        }

        .stat-value {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--gray-800);
        }

        .stat-label {
            font-size: 0.8rem;
            color: var(--gray-600);
        }

        .profile-info {
            padding: 20px;
        }

        .info-item {
            display: flex;
            margin-bottom: 15px;
        }

        .info-item:last-child {
            margin-bottom: 0;
        }

        .info-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--primary-light);
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            flex-shrink: 0;
        }

        .info-content {
            flex: 1;
        }

        .info-label {
            font-size: 0.8rem;
            color: var(--gray-600);
            margin-bottom: 3px;
        }

        .info-value {
            font-weight: 600;
            color: var(--gray-800);
        }

        .profile-form-card {
            padding: 30px;
        }

        .form-title {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid var(--gray-200);
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
            padding: 10px 15px;
            border: 1px solid var(--gray-300);
            border-radius: var(--border-radius);
            font-family: 'Poppins', sans-serif;
            font-size: 0.9rem;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(230, 57, 70, 0.1);
        }

        .form-row {
            display: flex;
            gap: 20px;
        }

        .form-col {
            flex: 1;
        }

        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 30px;
        }

        .password-section {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid var(--gray-200);
        }
    </style>
@endsection

@section('content')
@section('header-title', 'Admin Profile')
<main class="admin-main">
    <div class="page-header">
        <div>
            <h2 class="page-header-title">Admin Profile</h2>
            <p class="page-header-description">View and update your profile information</p>
        </div>
    </div>

    <div class="profile-container">
        <div class="profile-card">
            <div class="profile-header">
                <div class="profile-avatar">
                    <img src="{{ asset($user->image) ?? 'https://via.placeholder.com/120x120' }}" alt="Admin Avatar">
                </div>
                <div class="profile-name">{{ $user->firstname }} {{ $user->lastname }}</div>
                <div class="profile-role">{{ $user->role->name }}</div>
            </div>

            <div class="profile-stats">
                <div class="profile-stat">
                    <div class="stat-value">{{ $user->created_at->diffInDays() }}</div>
                    <div class="stat-label">Days Active</div>
                </div>
            </div>

            <div class="profile-info">
                <div class="info-item">
                    <div class="info-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div class="info-content">
                        <div class="info-label">Email Address</div>
                        <div class="info-value">{{ $user->email }}</div>
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-icon">
                        <i class="fas fa-calendar"></i>
                    </div>
                    <div class="info-content">
                        <div class="info-label">Joined Date</div>
                        <div class="info-value">{{ $user->created_at->format('F j, Y') }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Profile Edit Form -->
        <div class="profile-card profile-form-card">
            <h3 class="form-title">Edit Profile</h3>

            <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-row">
                    <div class="form-col">
                        <div class="form-group">
                            <label for="firstname" class="form-label">First Name</label>
                            <input type="text" id="firstname" name="firstname" class="form-control"
                                value="{{ $user->firstname }}" required>
                        </div>
                    </div>
                    <div class="form-col">
                        <div class="form-group">
                            <label for="lastname" class="form-label">Last Name</label>
                            <input type="text" id="lastname" name="lastname" class="form-control"
                                value="{{ $user->lastname }}" required>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" id="email" name="email" class="form-control"
                        value="{{ $user->email }}" required>
                </div>

                <div class="form-group">
                    <label for="profileImage" class="form-label">Profile Picture</label>
                    <div class="custom-file-input">
                        <input type="file" id="image" name="image" accept="image/*">
                        <div class="custom-file-button">
                            <i class="fas fa-cloud-upload-alt"></i>
                            <span class="custom-file-text">Choose image</span>
                        </div>
                        <div class="custom-file-name"></div>
                        <div class="custom-file-preview">
                            <img src="#" alt="Image Preview" id="imagePreview">
                        </div>
                    </div>
                </div>

                <div class="password-section">
                    <h4 class="form-title">Change Password</h4>
                    <p class="text-muted mb-4">Leave these fields empty if you don't want to change your password</p>

                    <div class="form-group">
                        <label for="current_password" class="form-label">Current Password</label>
                        <input type="password" id="current_password" name="current_password" class="form-control">
                    </div>

                    <div class="form-row">
                        <div class="form-col">
                            <div class="form-group">
                                <label for="new_password" class="form-label">New Password</label>
                                <input type="password" id="new_password" name="new_password" class="form-control">
                            </div>
                        </div>
                        <div class="form-col">
                            <div class="form-group">
                                <label for="new_password_confirmation" class="form-label">Confirm New Password</label>
                                <input type="password" id="new_password_confirmation"
                                    name="new_password_confirmation" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="reset" class="btn btn-outline">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</main>
@endsection

@section('js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const menuToggle = document.getElementById('menu-toggle');
        const sidebar = document.querySelector('.admin-sidebar');

        if (menuToggle && sidebar) {
            menuToggle.addEventListener('click', function() {
                sidebar.classList.toggle('show');
            });
        }

        document.getElementById('image').addEventListener('change', function(event) {
            const file = event.target.files[0];
            const preview = document.getElementById('imagePreview');
            const previewImage = document.querySelector('.custom-file-preview');

            if (file && file.type.startsWith('image/')) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.parentElement.style.display = 'block';
                }

                reader.readAsDataURL(file);
            } else {
                preview.src = '#';
                preview.style.display = 'none';
            }
        });
    });
</script>
@endsection
