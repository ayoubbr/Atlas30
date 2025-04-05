<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// User
Route::prefix('/')->group(function () {

    Route::get('', function () {
        return view('welcome');
    })->name('home');

    Route::get('login', function () {
        return view('user.auth');
    })->name('login');

    Route::get('matches', function () {
        return view('user.matches');
    });

    Route::get('match', function () {
        return view('user.match');
    });

    Route::get('payment', function () {
        return view('user.payment');
    });

    Route::get('forum', function () {
        return view('user.forum');
    });

    Route::get('profile', function () {
        return view('user.profile');
    });

    // Authentication 
    Route::post('login', [UserController::class, 'login'])->name('login');
    Route::post('register', [UserController::class, 'register'])->name('register');
    Route::post('logout', [UserController::class, 'logout'])->name('logout');
    Route::post('forgot-password', [UserController::class, 'forgotPassword'])->name('forgot-password');
});

// User profile 
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [UserController::class, 'profile'])->name('user.profile');
    Route::put('/profile', [UserController::class, 'updateProfile'])->name('user.profile.update');
});

// Admin
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {

    Route::get('dashboard', function () {
        return view('admin.dashboard');
    })->name("admin");

    Route::get('analytics', function () {
        return view('admin.analytics');
    });

    Route::get('matches', function () {
        return view('admin.matches');
    });

    Route::get('tickets', function () {
        return view('admin.tickets');
    });

    Route::get('venues', function () {
        return view('admin.venues');
    });

    Route::get('teams', function () {
        return view('admin.teams');
    });

    Route::get('users', function () {
        return view('admin.users');
    });

    Route::get('forums', function () {
        return view('admin.forums');
    });

    Route::get('settings', function () {
        return view('admin.settings');
    });
});
