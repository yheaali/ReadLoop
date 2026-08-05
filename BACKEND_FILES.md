# Backend Files (Read loop)

## Main Backend Folders
- app/
- routes/
- database/
- config/
- bootstrap/
- tests/

## Core Backend Files
- routes/web.php
- routes/auth.php
- bootstrap/app.php
- config/app.php

## Controllers
- app/Http/Controllers/BookController.php
- app/Http/Controllers/CommentController.php
- app/Http/Controllers/RatingController.php
- app/Http/Controllers/AdminController.php
- app/Http/Controllers/AuthorStatsController.php
- app/Http/Controllers/ProfileController.php
- app/Http/Controllers/Auth/*

## Models / Policies / Middleware
- app/Models/User.php
- app/Models/Book.php
- app/Models/Comment.php
- app/Models/Rating.php
- app/Policies/BookPolicy.php
- app/Http/Middleware/AdminMiddleware.php
- app/Http/Middleware/EnsureUserIsNotBanned.php

## Database Layer
- database/migrations/*
- database/seeders/DatabaseSeeder.php
- database/factories/UserFactory.php

## Backend Dependencies/Run
- composer.json
- artisan
- .env
