<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;
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
    return view('home');
})->name('home');

// Routes publiques
Route::middleware('guest')->group(function () {
    Route::get('/login', [UserController::class, 'showLogin'])->name('login');
    Route::post('/login', [UserController::class, 'login'])->name('login.submit');
    Route::get('/register', [UserController::class, 'showRegister'])->name('register');
    Route::post('/register', [UserController::class, 'register'])->name('register.submit');
});

// Routes protégées
Route::middleware('auth')->group(function () {
    Route::get('/profile', [UserController::class, 'showProfile'])->name('profile');
    Route::post('/profile', [UserController::class, 'updateProfile'])->name('profile.update');
    Route::post('/profile/password', [UserController::class, 'updatePassword'])->name('profile.updatePassword');
    Route::delete('/profile', [UserController::class, 'deleteProfile'])->name('profile.delete');
    Route::post('/logout', [UserController::class, 'logout'])->name('logout');

    // Posts routes
    Route::resource('posts', PostController::class);
});

// Redirection vers accueil si la route n'existe pas
Route::fallback(function () {
    return redirect()->route('home');
});
