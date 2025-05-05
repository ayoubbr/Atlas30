<?php

namespace App\Http\Controllers;

use App\Repository\Impl\IProfileRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    private $profileRepository;

    public function __construct(IProfileRepository $profileRepository)
    {
        $this->profileRepository = $profileRepository;
    }

    public function index()
    {
        $userId = Auth::id();
        $user = $this->profileRepository->getUserWithTickets($userId);
        $postCount = $this->profileRepository->getUserPostCount($userId);
        $activities = $this->profileRepository->getUserActivity($userId);

        return view('user.profile', compact('user', 'postCount', 'activities'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . Auth::id(),
            'phone' => 'nullable|string|max:20',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
        ]);

        $result = $this->profileRepository->updateUserProfile(Auth::id(), $request->all());

        if (!$result) {
            return redirect()->back()->with('error', 'Failed to update profile.');
        }

        return redirect()->route('profile')->with('success', 'Profile updated successfully!');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|current_password',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        $result = $this->profileRepository->updateUserPassword(Auth::id(), $request->new_password);

        if (!$result) {
            return redirect()->back()->with('error', 'Failed to update password.');
        }

        return redirect()->route('profile')->with('success', 'Password updated successfully!');
    }

    public function updateNotifications(Request $request)
    {
        $settings = [
            'email_notifications' => $request->has('email_notifications'),
            'sms_notifications' => $request->has('sms_notifications'),
            'match_reminders' => $request->has('match_reminders'),
            'forum_notifications' => $request->has('forum_notifications')
        ];

        $result = $this->profileRepository->updateUserNotifications(Auth::id(), $settings);

        if (!$result) {
            return redirect()->back()->with('error', 'Failed to update notification settings.');
        }

        return redirect()->route('profile')->with('success', 'Notification settings updated successfully!');
    }
}
