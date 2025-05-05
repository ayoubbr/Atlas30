<?php

namespace App\Http\Controllers;

use App\Repository\Impl\IAuthRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    private $authRepository;

    public function __construct(IAuthRepository $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    public function authenticate()
    {
        return view('user.auth');
    }

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

        $user = $this->authRepository->createUser($request->all());

        auth()->login($user);

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

        if ($this->authRepository->attemptLogin($credentials)) {
            $user = $this->authRepository->getCurrentUser();

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
        $this->authRepository->logout($request);
        return redirect()->route('home')->with('success', 'You have been logged out!');
    }
}
