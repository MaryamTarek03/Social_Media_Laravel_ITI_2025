# Git Commands Quick Reference

## Getting Started

```bash
# Clone repository
git clone https://github.com/MaryamTarek03/Social_Media_Laravel_ITI_2025.git
cd Social_Media_Laravel_ITI_2025
```

## 🌿 Branch Management

```bash
# Check current branch
git branch

# Create new feature branch
git checkout -b feature/authentication
git checkout -b feature/posts
git checkout -b feature/comments
git checkout -b feature/reactions
git checkout -b feature/follows

# Switch between branches
git checkout main
git checkout feature/posts

# List all branches (including remote)
git branch -a
```

## Making Changes

```bash
# Check status of files
git status

# Add files to staging area
git add .                           # Add all files (usually the one you use)
git add file.php                    # Add specific file
git add app/Http/Controllers/       # Add specific directory

# Commit changes (example messages)
git commit -m "Add post creation functionality"
git commit -m "Fix: resolve comment deletion bug"
git commit -m "Update: improve user profile layout"

# Push to remote repository
git push origin feature/posts       # Push feature branch
git push origin main               # Push to main branch
```

## Staying Updated

```bash
# Switch to main and pull latest changes
git checkout main
git pull origin main

# Update your feature branch with main branch changes
git checkout feature/posts
git merge main
# OR
git rebase main
```

## Merging Features

```bash
# Create Pull Request on GitHub (Recommended, don't merge on local)
git push origin feature/posts
# Then create PR on GitHub website
```

## Cleanup

```bash
# Delete local feature branch (after merging)
git branch -d feature/posts

# Delete remote feature branch
git push origin --delete feature/posts

# Force delete local branch (if not merged)
git branch -D feature/posts
```

## 🆘 Emergency Commands

```bash
# Undo last commit (keep changes)
git reset --soft HEAD~1

# Undo last commit (discard changes)
git reset --hard HEAD~1

# Discard local changes
git checkout -- filename.php       # Single file
git checkout -- .                  # All files

# Stash changes temporarily
git stash                          # Save changes
git stash pop                      # Restore changes
git stash list                     # View stashed changes
```

## Commit Message Conventions

```bash
# Use clear, descriptive messages
git commit -m "Add user authentication system"
git commit -m "Fix: resolve post deletion error"
git commit -m "Update: improve comment styling"
git commit -m "Remove: unused profile components"

# For larger features
git commit -m "Feature: Complete user profile management

- Add profile edit functionality
- Implement avatar upload
- Add bio editing
- Include form validation"
```

## Viewing History

```bash
# View commit history
git log
git log --oneline              # Compact view
git log --graph --oneline      # Visual branch history

# View changes in specific commit
git show commit_hash

# View file changes
git diff                       # Unstaged changes
git diff --staged              # Staged changes
git diff main feature/posts    # Compare branches
```

## Team Workflow Example

```bash
# 1. Start new feature
git checkout main
git pull origin main
git checkout -b feature/user-posts

# 2. Work on feature
# ... make changes ...
git add .
git commit -m "Add post creation form"

# 3. Push feature for backup/collaboration
git push origin feature/user-posts

# 4. Keep feature updated with main
git checkout main
git pull origin main
git checkout feature/user-posts
git merge main

# 5. When feature is complete
git push origin feature/user-posts
# Create Pull Request on GitHub

# 6. After PR is merged
git checkout main
git pull origin main
git branch -d feature/user-posts
```

---

💡 **Pro Tips:**

-   Always `git pull` before starting work
-   Create small, focused commits
-   Write descriptive commit messages
-   Test your code before committing
-   Use feature branches for all changes
-   Never force push to main branch
