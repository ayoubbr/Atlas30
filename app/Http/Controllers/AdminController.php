<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;


class AdminController extends Controller
{
    public function index()
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

    
    public function adminProfile()
    {
        $user = Auth::user();

        return view('admin.profile', compact('user'));
    }
}
