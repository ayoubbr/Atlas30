<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\StadiumController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\TicketController;
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

    // Route::get('profile', function () {
    //     return view('user.profile');
    // });

    // Authentication 
    Route::post('login', [UserController::class, 'login'])->name('login');
    Route::post('register', [UserController::class, 'register'])->name('register');
    Route::post('logout', [UserController::class, 'logout'])->name('logout');
    Route::post('forgot-password', [UserController::class, 'forgotPassword'])->name('forgot-password');
});

// User profile 
// Route::middleware(['auth'])->group(function () {
Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
Route::post('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
Route::post('/profile/notifications', [ProfileController::class, 'updateNotifications'])->name('profile.notifications');
// Route::put('/profile', [UserController::class, 'updateProfile'])->name('user.profile.update');
// });

// Admin
// middleware(['auth', 'admin'])->
Route::prefix('admin')->group(function () {
    // TEAM
    Route::get('teams', [TeamController::class, 'index'])->name('admin.teams.index');
    Route::post('teams', [TeamController::class, 'store'])->name('admin.teams.store');
    Route::put('teams/{id}', [TeamController::class, 'update'])->name('admin.teams.update');
    Route::delete('teams/{id}', [TeamController::class, 'destroy'])->name('admin.teams.destroy');

    // STADIUM
    Route::get('stadiums', [StadiumController::class, 'index'])->name('admin.stadiums.index');
    Route::post('stadiums', [StadiumController::class, 'store'])->name('admin.stadiums.store');
    Route::put('stadiums/{id}', [StadiumController::class, 'update'])->name('admin.stadiums.update');
    Route::delete('stadiums/{id}', [StadiumController::class, 'destroy'])->name('admin.stadiums.destroy');

    // CATEGORY
    Route::get('categories', [CategoryController::class, 'index'])->name('admin.categories.index');
    Route::post('categories', [CategoryController::class, 'store'])->name('admin.categories.store');
    Route::put('categories/{id}', [CategoryController::class, 'update'])->name('admin.categories.update');
    Route::delete('categories/{id}', [CategoryController::class, 'destroy'])->name('admin.categories.destroy');

    // ROLE
    Route::get('roles', [RoleController::class, 'index'])->name('admin.roles.index');
    Route::post('roles', [RoleController::class, 'store'])->name('admin.roles.store');
    Route::put('roles/{id}', [RoleController::class, 'update'])->name('admin.roles.update');
    Route::delete('roles/{id}', [RoleController::class, 'destroy'])->name('admin.roles.destroy');

    // GAME
    Route::get('games', [GameController::class, 'index'])->name('admin.games.index');
    Route::post('games', [GameController::class, 'store'])->name('admin.games.store');
    Route::put('games/{id}', [GameController::class, 'update'])->name('admin.games.update');
    Route::delete('games/{id}', [GameController::class, 'destroy'])->name('admin.games.destroy');
    Route::post('games/{game}/score', [GameController::class, 'updateScore'])->name('games.score');

    // TICKET
    Route::get('tickets', [TicketController::class, 'index'])->name('admin.tickets.index');
    Route::post('tickets', [TicketController::class, 'store'])->name('admin.tickets.store');
    Route::put('tickets/{id}', [TicketController::class, 'update'])->name('admin.tickets.update');
    Route::delete('tickets/{id}', [TicketController::class, 'destroy'])->name('admin.tickets.destroy');

    // USER
    Route::get('users', [UserController::class, 'adminIndex'])->name('admin.users.index');
    Route::post('users', [UserController::class, 'store'])->name('admin.users.store');
    Route::get('users/{id}', [UserController::class, 'show'])->name('admin.users.show');
    Route::put('users/{id}', [UserController::class, 'update'])->name('admin.users.update');
    Route::delete('users/{id}', [UserController::class, 'destroy'])->name('admin.users.destroy');
    // Admin profile routes
    Route::get('profile', [UserController::class, 'adminProfile'])->name('admin.profile');
    Route::post('profile', [UserController::class, 'updateProfile'])->name('admin.profile.update');



    
    Route::get('dashboard', function () {
        return view('admin.dashboard');
    })->name("admin");

    Route::get('analytics', function () {
        return view('admin.analytics');
    });

    // Route::get('users', function () {
    //     return view('admin.users');
    // });

    Route::get('forums', function () {
        return view('admin.forums');
    });

    Route::get('settings', function () {
        return view('admin.settings');
    });
});
