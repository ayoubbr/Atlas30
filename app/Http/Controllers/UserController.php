<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class UserController extends Controller
{
  

    public function profile()
    {
        $user = Auth::user();
        return view('user.profile', compact('user'));
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


   


    public function updateProfile(Request $request)
    {
        $user = Auth::user();

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

        // Update user data
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->email = $request->email;

        if ($request->hasFile('image')) {
            $imageName = Str::slug($request->firstname) . '_' . Str::slug($request->lastname) . '-' . time() . '.' . $request->image->extension();
            $request->image->storeAs('public/users', $imageName);
            $user->image = 'storage/users/' . $imageName;
        }

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


    public function getUsersList()
    {
        $users = User::select('id', 'firstname', 'lastname', 'email')
            ->orderBy('firstname')
            ->get();

        return response()->json($users);
    }
}
