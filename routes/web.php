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
    return view('user.matches');
});

Route::get('/match', function () {
    return view('user.match');
});

Route::get('/payment', function () {
    return view('user.payment');
});

Route::get('/forum', function () {
    return view('user.forum');
});

Route::get('/profile', function () {
    return view('user.profile');
});
