<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repository\Impl\IAdminRepository;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    private $adminRepository;

    public function __construct(IAdminRepository $adminRepository)
    {
        $this->adminRepository = $adminRepository;
    }

    public function index()
    {
        $totalUsers = $this->adminRepository->getTotalUsersCount();
        $activeUsers = $this->adminRepository->getActiveUsersCount();
        $newUsers = $this->adminRepository->getNewUsersCount(7);

        $users = $this->adminRepository->getPaginatedUsers(8);
        $roles = $this->adminRepository->getAllRoles();

        $chartData = $this->adminRepository->getMonthlyRegistrations();

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

        $this->adminRepository->createUser($request->all());

        return redirect()->route('admin.users.index')
            ->with('success', 'User created successfully.');
    }

    public function show($id)
    {
        $user = $this->adminRepository->findUserById($id, ['role', 'tickets']);

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        return response()->json([
            'user' => $user
        ]);
    }

    public function update(Request $request, $id)
    {
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

        $user = $this->adminRepository->updateUser($id, $request->all());

        if (!$user) {
            return redirect()->back()->with('error', 'User not found.');
        }

        return redirect()->route('admin.users.index')
            ->with('success', 'User updated successfully.');
    }

    public function adminProfile()
    {
        $user = $this->adminRepository->getAuthenticatedUser();

        return view('admin.profile', compact('user'));
    }

    public function destroy($id)
    {
        if ($this->adminRepository->hasTickets($id)) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Cannot delete user with associated tickets.');
        }

        if ($this->adminRepository->hasComments($id)) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Cannot delete user with associated comments.');
        }

        if ($this->adminRepository->hasLikes($id)) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Cannot delete user with associated likes.');
        }

        if ($this->adminRepository->hasNotifications($id)) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Cannot delete user with associated notifications.');
        }

        $this->adminRepository->deleteUser($id);

        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully.');
    }
}
