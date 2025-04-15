<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Ticket;
use App\Models\Team;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $tickets = Ticket::where('user_id', $user->id)
            ->with(['game.homeTeam', 'game.awayTeam', 'game.stadium', 'category'])
            ->get();


        $postCount = Post::where('user_id', $user->id)->count();

        // Get recent activity
        $recentTickets = Ticket::where('user_id', $user->id)
            ->with(['game.homeTeam', 'game.awayTeam'])
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        $recentPosts = Post::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        $activities = collect();

        foreach ($recentTickets as $ticket) {
            $activities->push([
                'type' => 'ticket',
                'icon' => 'ticket-alt',
                'title' => 'Purchased ticket for ' . $ticket->game->homeTeam->name . ' vs ' . $ticket->game->awayTeam->name,
                'time' => $ticket->created_at,
            ]);
        }

        foreach ($recentPosts as $post) {
            $activities->push([
                'type' => 'post',
                'icon' => 'comment',
                'title' => 'Posted in "' . $post->topic . '" forum',
                'time' => $post->created_at,
            ]);
        }

        $activities = $activities->sortByDesc('time')->values();

        return view('user.profile', compact('user', 'tickets', 'postCount', 'activities'));
    }


    public function update(Request $request)
    {
        $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . Auth::id(),
            'phone' => 'nullable|string|max:20',
            'country' => 'nullable|string|max:2',
            'language' => 'nullable|string|max:2',
            'bio' => 'nullable|string|max:500',
        ]);

        $user = Auth::user();
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->country = $request->country;
        $user->language = $request->language;
        $user->bio = $request->bio;
        $user->save();

        return redirect()->route('profile')->with('success', 'Profile updated successfully!');
    }


    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|current_password',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();
        $user->password = bcrypt($request->new_password);
        $user->save();

        return redirect()->route('profile')->with('success', 'Password updated successfully!');
    }


    public function updateNotifications(Request $request)
    {
        $user = Auth::user();
        $user->email_notifications = $request->has('email_notifications');
        $user->sms_notifications = $request->has('sms_notifications');
        $user->match_reminders = $request->has('match_reminders');
        $user->forum_notifications = $request->has('forum_notifications');
        $user->save();

        return redirect()->route('profile')->with('success', 'Notification settings updated successfully!');
    }
}
