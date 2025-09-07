# Laravel Social Media Project - Development Guide

## Project Overview

This is a Laravel-based social media application with the following features:

-   User authentication and profile management
-   Posts with media uploads
-   Comments system
-   Reactions (likes/dislikes)
-   Follow/Followers system
-   Timeline feed

## Getting Started

### Prerequisites

-   PHP 8.2 or higher
-   Composer
-   Node.js and npm
-   MariaDB database
-   Git


### Run Migrations

```bash
# Create database tables
php artisan migrate

# Or refresh all migrations (drops all tables and recreates them)
php artisan migrate:fresh

# Run migrations with seeders (if available)
php artisan migrate:fresh --seed
```

### Start Development Servers

```bash
# Terminal 1: Start Laravel development server
php artisan serve

# Terminal 2: Start Vite for asset compilation
npm run dev
```

## 🌿 Git Workflow & Feature Development

### Creating Feature Branches

```bash
# 1. Make sure you're on main branch and up to date
git checkout main
git pull origin main

# 2. Create and switch to a new feature branch
git checkout -b feature/authentication
git checkout -b feature/posts
git checkout -b feature/comments
git checkout -b feature/reactions
git checkout -b feature/follows

# Alternative: Create branch without switching
# Create
git branch feature/your-feature-name
# Switch
git checkout feature/your-feature-name
```

### Working on Features

```bash
# Check current branch
git branch

# See file changes
git status

# Add changes to staging
git add .
# Or add specific files
git add app/Http/Controllers/PostController.php

# Commit changes
git commit -m "Add post creation functionality"

# Push feature branch to remote
git push origin feature/posts
```

### Merging Features

```bash
# Switch back to main
git checkout main

# Pull latest changes
git pull origin main

# Merge your feature (or create Pull Request on GitHub)
git merge feature/posts

# Push merged changes
git push origin main

# Delete feature branch (optional)
git branch -d feature/posts
git push origin --delete feature/posts
```

## Common Development Commands

### Laravel Artisan Commands

```bash
# Create new migration
php artisan make:migration create_table_name

# Create new model with migration
php artisan make:model ModelName -m

# Create new controller
php artisan make:controller ControllerName

# Create resource controller
php artisan make:controller ControllerName --resource

# Create form request
php artisan make:request StorePostRequest

# Create middleware
php artisan make:middleware MiddlewareName

# Clear caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Run tests
php artisan test
./vendor/bin/pest
```

### Database Commands

```bash
# Run migrations
php artisan migrate

# Rollback migrations
php artisan migrate:rollback

# Fresh migration (drops all tables)
php artisan migrate:fresh

# Run specific migration
php artisan migrate --path=/database/migrations/filename.php

# Create seeder
php artisan make:seeder UserSeeder

# Run seeders
php artisan db:seed
php artisan db:seed --class=UserSeeder
```

## Team Collaboration Best Practices

1. **Always pull before starting work**
2. **Create feature branches for each task**
3. **Write descriptive commit messages**
4. **Test your code before pushing**
5. **Use consistent coding standards**
6. **Document your changes**
7. **Create pull requests for code review**

## Support

For any issues or questions:

1. Check Laravel documentation: https://laravel.com/docs
2. Review this guide
3. Ask team members
4. Create GitHub issues for bugs

---

Happy coding! 🎉
