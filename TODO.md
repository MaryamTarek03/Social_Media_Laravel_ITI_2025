# TODO: Implement Reactions & Follows System

## 1. Implement ReactionController

-   [x] Add store method for creating reactions
-   [x] Add destroy method for removing reactions
-   [x] Add validation and uniqueness handling

## 2. Implement FollowController

-   [x] Add store method for following users
-   [x] Add destroy method for unfollowing users
-   [x] Add followers method to show user's followers
-   [x] Add following method to show users being followed

## 3. Add Routes

-   [x] Add reaction routes (store/destroy) to web.php
-   [x] Add follow routes (store/destroy/followers/following) to web.php
-   [x] Ensure routes are protected with auth middleware

## 4. Create Timeline Feed Query

-   [x] Add scopeTimeline method to Post model
-   [x] Query posts from followed users

## 5. Create View Components

-   [x] Create reaction-buttons.blade.php
-   [x] Create reaction-count.blade.php
-   [x] Create follow-button.blade.php

## 6. Update Dashboard

-   [x] Integrate timeline into dashboard.blade.php
-   [x] Add reaction and follow components to posts

## 7. Testing

-   [ ] Test reaction endpoints
-   [ ] Test follow endpoints
-   [ ] Test timeline display
-   [ ] Test UI interactions
