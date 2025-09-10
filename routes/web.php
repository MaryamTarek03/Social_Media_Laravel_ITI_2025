<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ReactionController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\EditController;
use App\Http\Controllers\ProcessingController;
use App\Http\Controllers\ReportsController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (auth()->check()) {
        return view('dashboard');
    }
    return redirect()->route('login');
})->name('home');

# Removed duplicate dashboard route since '/' now serves dashboard view

Route::middleware('auth')->group(function () {
    Route::get('profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Posts
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');

    // Reactions
    Route::post('/posts/{post}/react', [ReactionController::class, 'store'])->name('reactions.store');
    Route::delete('/posts/{post}/react', [ReactionController::class, 'destroy'])->name('reactions.destroy');

    // Follows
    Route::post('/users/{user}/follow', [FollowController::class, 'store'])->name('follows.store');
    Route::delete('/users/{user}/follow', [FollowController::class, 'destroy'])->name('follows.destroy');
    Route::get('/users/{user}/followers', [FollowController::class, 'followers'])->name('users.followers');
    Route::get('/users/{user}/following', [FollowController::class, 'following'])->name('users.following');

    // Search
    Route::get('/search', [SearchController::class, 'index'])->name('search.index');
    Route::get('/api/search/users', [SearchController::class, 'users'])->name('api.search.users');
    Route::get('/api/search/posts', [SearchController::class, 'posts'])->name('api.search.posts');

    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{notification}/read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
    Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');
    Route::get('/api/notifications/unread-count', [NotificationController::class, 'getUnreadCount'])->name('api.notifications.unreadCount');
    Route::delete('/notifications/{notification}', [NotificationController::class, 'destroy'])->name('notifications.destroy');

    // Chats
    Route::get('/chats', [ChatController::class, 'index'])->name('chats.index');
    Route::get('/chats/{user}', [ChatController::class, 'show'])->name('chats.show');
    Route::post('/chats/{user}', [ChatController::class, 'store'])->name('chats.store');
    Route::get('/api/chats/unread-count', [ChatController::class, 'getUnreadCount'])->name('api.chats.unreadCount');
    Route::post('/chats/{chat}/mark-read', [ChatController::class, 'markAsRead'])->name('chats.markAsRead');
    Route::get('/api/chats/{chat}/messages', [ChatController::class, 'getMessages'])->name('api.chats.messages');

    // Settings
    Route::get('/settings', [\App\Http\Controllers\SettingsController::class, 'index'])->name('settings.index');
    Route::patch('/settings/profile', [\App\Http\Controllers\SettingsController::class, 'updateProfile'])->name('settings.updateProfile');
    Route::patch('/settings/password', [\App\Http\Controllers\SettingsController::class, 'updatePassword'])->name('settings.updatePassword');
    Route::patch('/settings/privacy', [\App\Http\Controllers\SettingsController::class, 'updatePrivacy'])->name('settings.updatePrivacy');
    Route::patch('/settings/notifications', [\App\Http\Controllers\SettingsController::class, 'updateNotifications'])->name('settings.updateNotifications');
    Route::delete('/settings', [\App\Http\Controllers\SettingsController::class, 'destroy'])->name('settings.destroy');

    // Edit Module
    Route::prefix('edit')->name('edit.')->group(function () {
        Route::get('/', [EditController::class, 'index'])->name('index');
        Route::get('/posts', [EditController::class, 'posts'])->name('posts');
        Route::get('/posts/{post}/edit', [EditController::class, 'editPost'])->name('posts.edit');
        Route::patch('/posts/{post}', [EditController::class, 'updatePost'])->name('posts.update');
        Route::delete('/posts/{post}', [EditController::class, 'deletePost'])->name('posts.delete');
        Route::get('/profile', [EditController::class, 'profile'])->name('profile');
    });

    // Processing Module
    Route::prefix('processing')->name('processing.')->group(function () {
        Route::get('/', [ProcessingController::class, 'index'])->name('index');
        Route::get('/import', [ProcessingController::class, 'import'])->name('import');
        Route::post('/import', [ProcessingController::class, 'importData'])->name('import.store');
        Route::get('/export', [ProcessingController::class, 'export'])->name('export');
        Route::post('/export', [ProcessingController::class, 'exportData'])->name('export.store');
        Route::get('/cleanup', [ProcessingController::class, 'cleanup'])->name('cleanup');
        Route::post('/cleanup', [ProcessingController::class, 'performCleanup'])->name('cleanup.perform');
    });

    // Reports Module
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/', [ReportsController::class, 'index'])->name('index');
        Route::get('/user-analytics', [ReportsController::class, 'userAnalytics'])->name('user-analytics');
        Route::get('/post-analytics', [ReportsController::class, 'postAnalytics'])->name('post-analytics');
        Route::get('/engagement', [ReportsController::class, 'engagement'])->name('engagement');
        Route::get('/system-health', [ReportsController::class, 'systemHealth'])->name('system-health');
        Route::post('/export', [ReportsController::class, 'export'])->name('export');
    });
});

Route::resource('users', \App\Http\Controllers\UserController::class);

Route::middleware('guest')->group(function () {
    Route::get('/mylogin', [LoginController::class, 'show'])->name('mylogin');
    Route::get('/myregister', [RegisterController::class, 'show'])->name('myregister');
});

require __DIR__ . '/auth.php';
