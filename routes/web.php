<?php

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

Route::get('/', function () {
    return view('welcome');
});


Route::get('/auth', function () {
    return view('user.auth');
});

Route::get('/matches', function () {
    return view('matches');
});

Route::get('/match', function () {
    return view('match');
});

Route::get('/payment', function () {
    return view('payment');
});

Route::get('/forum', function () {
    return view('forum');
});

Route::get('/profile', function () {
    return view('profile');
});
