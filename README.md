# Laravel Social Media Project

A comprehensive social media application built with Laravel, featuring user authentication, posts, comments, reactions, and a follow system.

## Documentation

- **[Development Guide](DEVELOPMENT_GUIDE.md)** - Complete setup and development instructions
- **[Git Commands](GIT_COMMANDS.md)** - Git workflow and commands reference
- **[Feature Guides](FEATURE_GUIDES.md)** - Specific instructions for each team member

## Quick Start

### Clone and setup

```bash
git clone https://github.com/MaryamTarek03/Social_Media_Laravel_ITI_2025.git
cd Social_Media_Laravel_ITI_2025
composer install && npm install
cp .env.example .env
php artisan key:generate
php artisan migrate
```

### Database Configuration

Edit your `.env` file with your database credentials:

```env
DB_CONNECTION=mariadb
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=social_media_laravel
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

---
## Team Tasks

### 1. Database & Models (**Maryam Tarek**)
- ✅ Create migrations (`users`, `posts`, `comments`, `reactions`, `reaction_types`, `follows`)
- ✅ Define Eloquent models + relationships
- ✅ Ensure constraints and cascade rules are correct
- (*Optional*) Write **factories/seeders** for testing

### 2. Authentication & User Management (**Mohamed**)
- Set up Laravel Breeze or use existing Laravel features (login, registration, logout, password reset)
- Implement profile management (update avatar, bio, delete account)  
- Work with validation and middleware (auth, guest)
- Make sure only owner can edit their profile
- 📖 **[See detailed guide](FEATURE_GUIDES.md#-authentication--user-management-mohamed)**

### 3. Posts (**Mariam**)
- Build CRUD for posts (create, edit, delete, view)
- Make sure only owner can edit their posts
- Handle media uploads (images)
- 📖 **[See detailed guide](FEATURE_GUIDES.md#-posts-feature-mariam)**

### 4. Comments (**Sayed**)
- Implement comments under posts (create, delete)
- Make sure only owner can edit their comments
- Handle media upload (images)
- 📖 **[See detailed guide](FEATURE_GUIDES.md#-comments-feature-sayed)**

### 5. Reactions & Follows (**Eyad**)
- Implement likes/reactions system
- Build follows/followers system
- Write queries for "timeline feed" (show posts from people you follow)
- Handle uniqueness (no duplicate reactions, no duplicate follows)
- 📖 **[See detailed guide](FEATURE_GUIDES.md#️-reactions--follows-eyad)**

---
## Development Workflow

1. **Create feature branch**: `git checkout -b feature/your-feature`
2. **Make changes and commit**: `git add . && git commit -m "Your changes"`
3. **Push changes**: `git push origin feature/your-feature`
4. **Create PR**: after you finish create a pull request on GitHub
5. **Get code review and merge**

## Git Branches

- `main` - Production-ready code
- `feature/authentication` - Mohamed's authentication work
- `feature/posts` - Mariam's posts functionality
- `feature/comments` - Sayed's comments system
- `feature/reactions-follows` - Eyad's reactions and follows

## Tech Stack

- **Backend**: Laravel 12, PHP 8.2+
- **Frontend**: Blade templates, Tailwind CSS
- **Database**: MariaDB
- **Testing**: Pest PHP
- **Build Tools**: Vite


## General Development Workflow

### For All Team Members:

1. **Start Working on Feature**

```bash
git checkout main
git pull origin main
git checkout -b feature/your-feature-name
```

2. **Daily Workflow**

```bash
# Before starting work each day (to make sure you have any changes in main)
git checkout main
git pull origin main
git checkout feature/your-feature-name
git merge main  # Get latest changes

# After making changes
git add .
git commit -m "Descriptive commit message"
git push origin feature/your-feature-name
```

## Testing Guidelines

-   Test all CRUD operations
-   Test authentication and authorization
-   Test file uploads
-   Test edge cases (empty data, large files, etc.)
-   Test with different user roles


## Need Help?

1. Check the [Development Guide](DEVELOPMENT_GUIDE.md) for setup issues
2. Review [Git Commands](GIT_COMMANDS.md) for git workflow
3. See [Feature Guides](FEATURE_GUIDES.md) for your specific tasks
4. Ask team members or create GitHub issues

---

Happy coding! 🎉
