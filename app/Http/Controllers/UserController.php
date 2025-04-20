<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\Ticket;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($request->except('password', 'password_confirmation'));
        }

        $user = User::create([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'status' => 'active',
            'role_id' => 2, // User role 
        ]);

        Auth::login($user);

        if ($user->role->name == 'admin') {
            return redirect()->route('admin')->with('success', 'Welcome to World Cup 2030, ' . $user->firstname . '! Your account has been created successfully.');
        } else {
            return redirect()->route('home')->with('success', 'Welcome to World Cup 2030, ' . $user->firstname . '! Your account has been created successfully.');
        }
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($request->except('password'));
        }

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if ($user->role->name === 'admin') {
                return redirect()->route('admin')->with('success', 'Welcome to admin dashboard!');
            } else {
                return redirect()->route('home')->with('success', 'Login successful!');
            }
        }

        return redirect()->back()
            ->withErrors(['email' => 'These credentials do not match our records.'])
            ->withInput($request->except('password'));
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'You have been logged out!');
    }

    public function profile()
    {
        $user = Auth::user();
        return view('user.profile', compact('user'));
    }


    public function adminIndex()
    {
        $totalUsers = User::count();
        $activeUsers = User::where('status', 'active')->count();
        $newUsers = User::where('created_at', '>=', Carbon::now()->subDays(7))->count();

        $users = User::with('role')->paginate(8);
        $roles = Role::all();

        // Get monthly registration data for chart
        $monthlyRegistrations = DB::table('users')
            ->select(DB::raw('MONTH(created_at) as month'), DB::raw('COUNT(*) as count'))
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->pluck('count', 'month')
            ->toArray();

        $chartData = [];
        for ($i = 1; $i <= 12; $i++) {
            $chartData[$i] = $monthlyRegistrations[$i] ?? 0;
        }

        return view('admin.users', compact('users', 'roles', 'totalUsers', 'activeUsers', 'newUsers', 'chartData'));
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role_id' => 'required|exists:roles,id',
            'status' => 'required|in:active,inactive,suspended,banned',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($request->except('password', 'password_confirmation'));
        }

        $user = User::create([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'status' => $request->status,
            'role_id' => $request->role_id,
            'country' => $request->country,
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'User created successfully.');
    }


    public function show($id)
    {
        $user = User::with('role', 'tickets')->findOrFail($id);

        return response()->json([
            'user' => $user
        ]);
    }


    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'role_id' => 'required|exists:roles,id',
            'status' => 'required|in:active,inactive,suspended,banned',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($request->except('password', 'password_confirmation'));
        }

        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->email = $request->email;
        $user->role_id = $request->role_id;
        $user->status = $request->status;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('admin.users.index')
            ->with('success', 'User updated successfully.');
    }


    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Check if user has tickets
        if ($user->tickets()->count() > 0) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Cannot delete user with associated tickets.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully.');
    }


    public function adminProfile()
    {
        $user = Auth::user();

        return view('admin.profile', compact('user'));
    }


    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'current_password' => 'nullable|required_with:new_password',
            'new_password' => 'nullable|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($request->except('current_password', 'new_password', 'new_password_confirmation'));
        }

        // Update user data
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->email = $request->email;

        // Update password if provided
        if ($request->filled('new_password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return redirect()->back()
                    ->withErrors(['current_password' => 'The current password is incorrect.'])
                    ->withInput($request->except('current_password', 'new_password', 'new_password_confirmation'));
            }

            $user->password = Hash::make($request->new_password);
        }

        $user->save();

        return redirect()->route('admin.profile')->with('success', 'Profile updated successfully!');
    }

    // public function updateProfile(Request $request)
    // {
    //     $user = Auth::user();

    //     $validator = Validator::make($request->all(), [
    //         'firstname' => 'required|string|max:255',
    //         'lastname' => 'required|string|max:255',
    //         'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
    //         'current_password' => 'nullable|required_with:new_password',
    //         'new_password' => 'nullable|min:8|confirmed',
    //     ]);

    //     if ($validator->fails()) {
    //         return redirect()->back()
    //             ->withErrors($validator)
    //             ->withInput($request->except('current_password', 'new_password', 'new_password_confirmation'));
    //     }

    //     // Update user data
    //     $user->firstname = $request->firstname;
    //     $user->lastname = $request->lastname;
    //     $user->email = $request->email;

    //     // Update password if provided
    //     if ($request->filled('new_password')) {
    //         if (!Hash::check($request->current_password, $user->password)) {
    //             return redirect()->back()
    //                 ->withErrors(['current_password' => 'The current password is incorrect.'])
    //                 ->withInput($request->except('current_password', 'new_password', 'new_password_confirmation'));
    //         }

    //         $user->password = Hash::make($request->new_password);
    //     }

    //     $user->save();

    //     // Update session data
    //     Session::put('user', $user);

    //     return redirect()->route('user.profile')->with('success', 'Profile updated successfully!');
    // }
}
