<?php

use Illuminate\Support\Facades\Route;

// backsite controller
use App\Http\Controllers\Auth\SocialController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

//Route::get('auth/github', 'Auth\SocialController@redirectToGitHub');
//Route::get('auth/github/callback', 'Auth\SocialController@handleGitHubCallback');

//Route::get('login', [LoginController::class, 'auth_redirect'])->name('auth.redirect');
Route::get('auth/github', [SocialController::class, 'redirectToGitHub'])->name('redirect.to.github');
Route::get('callback/github', [SocialController::class, 'handleGitHubCallback'])->name('handle.callback');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
