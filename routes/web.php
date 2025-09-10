<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReactionController;
use App\Http\Controllers\FollowController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Reactions
    Route::post('/posts/{post}/react', [ReactionController::class, 'store'])->name('reactions.store');
    Route::delete('/posts/{post}/react', [ReactionController::class, 'destroy'])->name('reactions.destroy');

    // Follows
    Route::post('/users/{user}/follow', [FollowController::class, 'store'])->name('follows.store');
    Route::delete('/users/{user}/follow', [FollowController::class, 'destroy'])->name('follows.destroy');
    Route::get('/users/{user}/followers', [FollowController::class, 'followers'])->name('users.followers');
    Route::get('/users/{user}/following', [FollowController::class, 'following'])->name('users.following');
});

Route::resource('users', \App\Http\Controllers\UserController::class);

Route::middleware('guest')->group(function () {
    Route::get('/mylogin', [LoginController::class, 'show'])->name('mylogin');
    Route::get('/myregister', [RegisterController::class, 'show'])->name('myregister');
});

require __DIR__ . '/auth.php';
