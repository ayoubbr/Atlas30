<?php

namespace App\Http\Controllers;

use App\Repository\Impl\IUserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    private $userRepository;

    public function __construct(IUserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function profile()
    {
        $user = $this->userRepository->getAuthenticatedUser();
        return view('user.profile', compact('user'));
    }


    public function updateProfile(Request $request)
    {
        $user = $this->userRepository->getAuthenticatedUser();

        $validator = Validator::make($request->all(), [
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'current_password' => 'nullable|required_with:new_password',
            'new_password' => 'nullable|min:8|confirmed',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($request->except('current_password', 'new_password', 'new_password_confirmation'));
        }

        $this->userRepository->updateProfile(
            $user,
            $request->all(),
            $request->hasFile('image') ? $request->file('image') : null
        );

        if ($request->filled('new_password')) {
            if (!$this->userRepository->checkCurrentPassword($user, $request->current_password)) {
                return redirect()->back()
                    ->withErrors(['current_password' => 'The current password is incorrect.'])
                    ->withInput($request->except('current_password', 'new_password', 'new_password_confirmation'));
            }

            $this->userRepository->updatePassword($user, $request->new_password);
        }

        return redirect()->route('admin.profile')->with('success', 'Profile updated successfully!');
    }

    public function getUsersList()
    {
        $users = $this->userRepository->getUsersList();
        return response()->json($users);
    }
}
