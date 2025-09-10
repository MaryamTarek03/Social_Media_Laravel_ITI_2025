<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReactionController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\UserController;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');
Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
Route::get('/dashboard', [PostController::class, 'index'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/timeline', [PostController::class, 'timeline'])->name('timeline');

    // Reactions
    Route::post('/posts/{post}/react', [ReactionController::class, 'store'])->name('reactions.store');
    // Route::delete('/posts/{post}/react', [ReactionController::class, 'destroy'])->name('reactions.destroy');

    // Comments
    Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::put('/comments/{comment}', [CommentController::class, 'update'])->name('comments.update');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

    // Follows
    Route::post('/users/{user}/follow', [FollowController::class, 'store'])->name('follows.store');
    Route::delete('/users/{user}/follow', [FollowController::class, 'destroy'])->name('follows.destroy');
    Route::get('/users/{user}/followers', [FollowController::class, 'followers'])->name('users.followers');
    Route::get('/users/{user}/following', [FollowController::class, 'following'])->name('users.following');
});

Route::resource('users', UserController::class);

Route::get('/users/list/{user}/followers', [UserController::class, 'listFollowers'])->name('users.list.followers');
Route::get('/users/list/{user}/following', [UserController::class, 'listFollowing'])->name('users.list.following');
Route::get('/users/list/{post}/reactions', [UserController::class, 'listReactions'])->name('users.list.reactions');



Route::middleware('guest')->group(function () {
    Route::get('/mylogin', [LoginController::class, 'show'])->name('mylogin');
    Route::get('/myregister', [RegisterController::class, 'show'])->name('myregister');
});

require __DIR__ . '/auth.php';
