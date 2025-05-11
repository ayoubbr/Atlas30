<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PostController;
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

// Visitor routes
Route::prefix('/')->group(function () {

    // Home
    Route::get('', [GameController::class, 'home'])->name('home');

    // Authentication 
    Route::get('login', [AuthController::class, 'authenticate'])->name('login');
    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::post('register', [AuthController::class, 'register'])->name('register');

    // GAMES
    Route::get('games', [GameController::class, 'visitorIndex'])->name('games');
    // Route::get('team/{id}/games', [GameController::class, 'teamGames']);

    // TICKETS
    Route::get('tickets/checkout', [TicketController::class, 'checkout'])->name('tickets.checkout');
    Route::post('tickets/process-payment', [PaymentController::class, 'processPayment'])->name('tickets.process-payment');
    Route::get('tickets/confirmation', [PaymentController::class, 'confirmation'])->name('tickets.confirmation');
    Route::get('user/tickets/{id}/download', [TicketController::class, 'downloadPdf'])->name('user.ticket.download');
    // Route::get('user/tickets/show', [TicketController::class, 'userTicketsShow'])->name('user.ticket.view');

    // TEAMS
    Route::get('teams', [TeamController::class, 'visitorIndex'])->name('teams');
    Route::get('teams/{id}', [TeamController::class, 'visitorShow'])->name('teams.show');

    // NOTIFICATIONS
    Route::get('users/notifications', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');

    // STADIUMS
    Route::get('stadiums', [StadiumController::class, 'visitorIndex'])->name('stadiums');
});


// User routes
Route::middleware(['auth'])->group(function () {

    // User profile
    Route::get('profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::post('profile/notifications', [ProfileController::class, 'updateNotifications'])->name('profile.notifications');
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('games/{id}', [GameController::class, 'visitorShow'])->name('games.show');
    Route::post('tickets/buy/{id}', [GameController::class, 'buyTickets'])->name('tickets.buy');

    // Forum routes
    Route::prefix('forum')->name('forum.')->group(function () {
        Route::get('/', [GroupController::class, 'index'])->name('index');
        Route::get('/group/{id}', [GroupController::class, 'showGroup'])->name('group');
        Route::get('/group/{groupId}/post/{postId}', [PostController::class, 'show'])->name('post');
        Route::get('/create-group', [GroupController::class, 'createGroup'])->name('create-group');
        Route::post('/create-group', [GroupController::class, 'storeGroupUser'])->name('store-group');

        Route::get('/group/{groupId}/create-post', [PostController::class, 'create'])->name('create-post');
        Route::post('/group/{groupId}/create-post', [PostController::class, 'store'])->name('store-post');

        Route::post('/group/{groupId}/post/{postId}/comment', [CommentController::class, 'store'])->name('store-comment');
        Route::post('/group/{groupId}/post/{postId}/like', [LikeController::class, 'toggleLike'])->name('toggle-like');

        Route::get('/group/{groupId}/post/{postId}/edit', [PostController::class, 'edit'])->name('edit-post');
        Route::put('/group/{groupId}/post/{postId}', [PostController::class, 'update'])->name('update-post');

        Route::get('/group/{id}/edit', [GroupController::class, 'edit'])->name('edit-group');
        Route::put('/group/{id}', [GroupController::class, 'updateGroup'])->name('update-group');

        Route::get('/my-likes', [LikeController::class, 'getUserLikes'])->name('my-likes');
    });
});


// Admin routes
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('admin');

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
    Route::put('tickets/{id}', [TicketController::class, 'update'])->name('admin.tickets.update');
    Route::delete('tickets/{id}', [TicketController::class, 'destroy'])->name('admin.tickets.destroy');

    // USER
    Route::get('users', [AdminController::class, 'index'])->name('admin.users.index');
    Route::post('users', [AdminController::class, 'store'])->name('admin.users.store');
    Route::get('users/{id}', [AdminController::class, 'show'])->name('admin.users.show');
    Route::put('users/{id}', [AdminController::class, 'update'])->name('admin.users.update');
    Route::delete('users/{id}', [AdminController::class, 'destroy'])->name('admin.users.destroy');

    // Admin profile routes
    Route::get('profile', [AdminController::class, 'adminProfile'])->name('admin.profile');
    Route::post('profile', [UserController::class, 'updateProfile'])->name('admin.profile.update');

    // User list for announcements
    Route::get('users/list', [UserController::class, 'getUsersList'])->name('admin.users.list');

    // Admin forum routes
    Route::prefix('forum')->name('admin.forum.')->middleware(['auth', 'admin'])->group(function () {
        Route::get('/', [ForumController::class, 'index'])->name('index');

        Route::post('/announcement', [ForumController::class, 'createAnnouncement'])->name('create-announcement');
        Route::delete('/announcement/{id}', [ForumController::class, 'destroyAnnouncement'])->name('destroy-announcement');

        Route::delete('/post/{id}', [PostController::class, 'destroy'])->name('destroy-post');
        Route::delete('/comment/{id}', [CommentController::class, 'destroy'])->name('destroy-comment');
        Route::delete('/group/{id}', [GroupController::class, 'destroyGroup'])->name('destroy-group');
        Route::post('/group', [GroupController::class, 'storeGroup'])->name('store-group');

        Route::get('/top-posts', [PostController::class, 'getTopPosts'])->name('top-posts');
        Route::get('/recent-posts', [PostController::class, 'getRecentPosts'])->name('recent-posts');
        Route::get('/recent-comments', [CommentController::class, 'getRecentComments'])->name('recent-comments');
        Route::get('/top-groups', [GroupController::class, 'getTopGroups'])->name('top-groups');
        Route::get('/active-users', [ForumController::class, 'getMostActiveUsers'])->name('active-users');
    });
});


Route::fallback(function () {
    return redirect('/')->with('error', 'The page you are looking for does not exist.');
});

// Route::get('admin/forum/group/{id}', [GroupController::class, 'getGroup'])->name('edit-group-2');