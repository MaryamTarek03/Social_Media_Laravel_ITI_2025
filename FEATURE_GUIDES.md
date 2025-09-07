# Feature Development Guides

## Authentication & User Management (**Mohamed**)

### Tasks

-   Set up Laravel Breeze or use existing Laravel features
-   Implement profile management (update avatar, bio, delete account)
-   Work with validation and middleware (auth, guest)
-   Ensure only owner can edit their profile

### 📁 Files to Work With

```
app/Http/Controllers/Auth/
├── LoginController.php
├── RegisterController.php
└── ProfileController.php
```
#### Example Views & Components
```
resources/views/auth/
├── login.blade.php
├── register.blade.php
├── forgot-password.blade.php
└── reset-password.blade.php

resources/views/profile/
├── show.blade.php
├── edit.blade.php
└── components/
    ├── avatar.blade.php
    └── bio.blade.php
```

### Getting Started

```bash
# 1. Create feature branch
git checkout -b feature/authentication

# 2. Install Laravel Breeze (if not using custom auth)
composer require laravel/breeze --dev
php artisan breeze:install blade
npm install && npm run build
php artisan migrate

# 3. Create controllers (if not created)
php artisan make:controller Auth/LoginController
php artisan make:controller Auth/RegisterController
php artisan make:controller ProfileController

# 4. Create middleware (if needed)
php artisan make:middleware MyGuest
php artisan make:middleware MyAuth
```

### Routes to Add

```php
// routes/web.php
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ProfileController;

// Authentication routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'show'])->name('login');
    Route::post('/login', [LoginController::class, 'authenticate']);
    Route::get('/register', [RegisterController::class, 'show'])->name('register');
    Route::post('/register', [RegisterController::class, 'store']);
});

// Protected routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Profile routes
    Route::get('/profile/{user}', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/{user}/edit', [ProfileController::class, 'edit'])
        ->middleware('can:update,user')->name('profile.edit');
    Route::put('/profile/{user}', [ProfileController::class, 'update'])
        ->middleware('can:update,user')->name('profile.update');
    Route::delete('/profile/{user}', [ProfileController::class, 'destroy'])
        ->middleware('can:delete,user')->name('profile.destroy');
});
```

---

## Posts Feature (Mariam)

### Tasks

-   Build CRUD for posts (create, edit, delete, view)
-   Ensure only owner can edit their posts
-   Handle media uploads (images)

### 📁 Files to Work With

```
app/Http/Controllers/
└── PostController.php
```
#### Example Views & Components
```
resources/views/posts/
├── index.blade.php          # Timeline/feed
├── show.blade.php           # Single post view
├── create.blade.php         # Create post
├── edit.blade.php           # Edit post
└── components/
    ├── post-card.blade.php
    └── etc...
```

### Getting Started

```bash
# 1. Create feature branch
git checkout -b feature/posts

# 2. Create controller and requests
php artisan make:controller PostController --resource
php artisan make:request StorePostRequest
php artisan make:request UpdatePostRequest

# 3. Create storage link for media uploads
php artisan storage:link

# 4. Configure file upload in config/filesystems.php
```

### 📝 Routes to Add

```php
// routes/web.php
use App\Http\Controllers\PostController;

// Create:
// GET /posts - index (timeline)
// GET /posts/create - create
// POST /posts - store
// GET /posts/{post} - show
// GET /posts/{post}/edit - edit
// PUT /posts/{post} - update
// DELETE /posts/{post} - destroy
```

---

## Comments Feature (Sayed)

### Tasks

-   Implement comments under posts (create, delete)
-   Ensure only owner can edit their comments
-   Handle media upload (images)

### 📁 Files to Work With

```
app/Http/Controllers/
└── CommentController.php
```
#### Example Views & Components
```
resources/views/comments/components/
├── comment-list.blade.php
├── comment-form.blade.php
├── comment-item.blade.php
└── comment-media.blade.php
```

### Getting Started

```bash
# 1. Create feature branch
git checkout -b feature/comments

# 2. Create controller (if not created)
php artisan make:controller CommentController
```

### Routes to Add

```php
// routes/web.php
use App\Http\Controllers\CommentController;

Route::middleware('auth')->group(function () {
    Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::put('/comments/{comment}', [CommentController::class, 'update'])->name('comments.update');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
});
```

---

## Reactions & Follows (Eyad)

### Tasks

-   Implement likes/reactions system
-   Build follows/followers system
-   Write queries for "timeline feed" (posts from people you follow)
-   Handle uniqueness (no duplicate reactions, no duplicate follows)

### 📁 Files to Work With

```
app/Http/Controllers/
├── ReactionController.php
└── FollowController.php
```
#### Example Views & Components
```
resources/views/reactions/components/
├── reaction-buttons.blade.php
└── reaction-count.blade.php

resources/views/follows/
├── followers.blade.php
├── following.blade.php
└── components/
    ├── follow-button.blade.php
    └── user-list.blade.php
```

### Getting Started

```bash
# 1. Create feature branch
git checkout -b feature/reactions-follows

# 2. Create controllers (if not created)
php artisan make:controller ReactionController
php artisan make:controller FollowController
```

### Routes to Add

```php
// routes/web.php
use App\Http\Controllers\ReactionController;
use App\Http\Controllers\FollowController;

Route::middleware('auth')->group(function () {
    // Reactions
    Route::post('/posts/{post}/react', [ReactionController::class, 'store'])->name('reactions.store');
    Route::delete('/posts/{post}/react', [ReactionController::class, 'destroy'])->name('reactions.destroy');

    // Follows
    Route::post('/users/{user}/follow', [FollowController::class, 'store'])->name('follows.store');
    Route::delete('/users/{user}/follow', [FollowController::class, 'destroy'])->name('follows.destroy');
    Route::get('/users/{user}/followers', [FollowController::class, 'followers'])->name('users.followers');
    Route::get('/users/{user}/following', [FollowController::class, 'following'])->name('users.following');
});
```
