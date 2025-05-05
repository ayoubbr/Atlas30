<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\StadiumController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\UserController;
use App\Models\Game;
use Carbon\Carbon;
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

// User profile 
// Route::middleware(['auth'])->group(function () {
Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
Route::post('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
Route::post('/profile/notifications', [ProfileController::class, 'updateNotifications'])->name('profile.notifications');
// Route::put('/profile', [UserController::class, 'updateProfile'])->name('user.profile.update');
// });



// User
Route::prefix('/')->group(function () {


    Route::get('login', function () {
        return view('user.auth');
    })->name('login');

    // Visitor routes
    // GAMES
    Route::get('', [GameController::class, 'home'])->name('home');
    Route::get('games', [GameController::class, 'visitorIndex'])->name('games');
    Route::get('games/{id}', [GameController::class, 'visitorShow'])->name('games.show');
    Route::get('team/{id}/games', [GameController::class, 'teamGames']);
    Route::post('tickets/buy/{id}', [GameController::class, 'buyTickets'])->name('tickets.buy');

    Route::get('tickets/checkout', [TicketController::class, 'checkout'])->name('tickets.checkout');
    // to be confirmed
    Route::post('tickets/process-payment', [PaymentController::class, 'processPayment'])->name('tickets.process-payment');
    Route::get('tickets/confirmation', [PaymentController::class, 'confirmation'])->name('tickets.confirmation');
    // Route::get('user/tickets/', [TicketController::class, 'userTickets'])->name('user.tickets');
    Route::get('user/tickets/{id}/download', [TicketController::class, 'downloadPdf'])->name('user.ticket.download');
    Route::get('user/tickets/show', [TicketController::class, 'userTicketsShow'])->name('user.ticket.view');
    // Route::get('tickets/{ticket}/download', [TicketController::class, 'downloadPdf'])->name('tickets.download');
    Route::get('tickets/verify/{id}', [App\Http\Controllers\TicketController::class, 'verifyTicket'])->name('tickets.verify');

    Route::get('teams', [TeamController::class, 'visitorIndex'])->name('teams');
    Route::get('teams/{id}', [TeamController::class, 'visitorShow'])->name('teams.show');

    Route::get('users/notifications', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');

    Route::get('stadiums', [StadiumController::class, 'visitorIndex'])->name('stadiums');

    // Forum Routes
    Route::prefix('forum')->name('forum.')->group(function () {
        Route::get('/', [ForumController::class, 'indexUser'])->name('index');
        Route::get('/group/{id}', [GroupController::class, 'showGroup'])->name('group');
        Route::get('/group/{groupId}/post/{postId}', [ForumController::class, 'showPost'])->name('post');

        // require authentication
        // Route::middleware(['auth'])->group(function () {
        // Group creation
        Route::get('/create-group', [GroupController::class, 'createGroup'])->name('create-group');
        Route::post('/create-group', [GroupController::class, 'storeGroupUser'])->name('store-group');

        // Post creation
        Route::get('/group/{groupId}/create-post', [ForumController::class, 'createPost'])->name('create-post');
        Route::post('/group/{groupId}/create-post', [ForumController::class, 'storePost'])->name('store-post');

        // Comments
        Route::post('/group/{groupId}/post/{postId}/comment', [ForumController::class, 'storeComment'])->name('store-comment');

        // Likes
        Route::post('/group/{groupId}/post/{postId}/like', [ForumController::class, 'toggleLike'])->name('toggle-like');
        // });
    });

    // Authentication 
    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::post('register', [AuthController::class, 'register'])->name('register');
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('forgot-password', [AuthController::class, 'forgotPassword'])->name('forgot-password');
});


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
    Route::get('users', [AdminController::class, 'index'])->name('admin.users.index');
    Route::post('users', [AdminController::class, 'store'])->name('admin.users.store');
    Route::get('users/{id}', [AdminController::class, 'show'])->name('admin.users.show');
    Route::put('users/{id}', [AdminController::class, 'update'])->name('admin.users.update');
    Route::delete('users/{id}', [AdminController::class, 'destroy'])->name('admin.users.destroy');
    // Admin profile routes
    Route::get('profile', [AdminController::class, 'adminProfile'])->name('admin.profile');
    Route::post('profile', [UserController::class, 'updateProfile'])->name('admin.profile.update');


    // Forum dashboard
    Route::get('forum', [ForumController::class, 'index'])->name('admin.forum.index');
    // Group management
    Route::post('forum/groups', [GroupController::class, 'storeGroup'])->name('admin.forum.store-group');
    Route::get('forum/groups/{id}', [ForumController::class, 'getGroup'])->name('admin.forum.get-group');
    Route::put('forum/groups/{id}', [GroupController::class, 'updateGroup'])->name('admin.forum.update-group');
    Route::delete('forum/groups/{id}', [GroupController::class, 'destroyGroup'])->name('admin.forum.destroy-group');
    // Post management
    Route::get('forum/groups/{id}/posts', [ForumController::class, 'getGroupPosts'])->name('admin.forum.get-group-posts');
    Route::delete('forum/posts/{id}', [ForumController::class, 'destroyPost'])->name('admin.forum.destroy-post');
    Route::get('forum/top-posts', [ForumController::class, 'getTopPosts'])->name('admin.forum.get-top-posts');
    // Comment management
    Route::delete('forum/comments/{id}', [ForumController::class, 'destroyComment'])->name('admin.forum.destroy-comment');
    // Announcement management
    Route::post('forum/announcements', [ForumController::class, 'createAnnouncement'])->name('admin.forum.create-announcement');
    Route::delete('forum/announcements/{id}', [ForumController::class, 'destroyAnnouncement']);
    // User list for announcements
    Route::get('users/list', [UserController::class, 'getUsersList'])->name('admin.users.list');

    Route::get('dashboard', [DashboardController::class, 'index'])->name('admin');
});



Route::fallback(function () {
    return redirect('/')->with('error', 'The page you are looking for does not exist.');
});
