<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthorStatsController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\SiteController;
use Illuminate\Support\Facades\Route;

Route::get('/locale/{locale}', [SiteController::class, 'switchLocale'])->name('locale.switch');

Route::get('/', [SiteController::class, 'home'])->name('home');

Route::get('/books', [BookController::class, 'index'])->name('books.index');

Route::get('/media/{path}', [MediaController::class, 'show'])->where('path', '.*')->name('media.public');

Route::middleware(['auth', 'not.banned'])->group(function () {
    Route::get('/books/create', [BookController::class, 'create'])->name('books.create');
    Route::post('/books', [BookController::class, 'store'])->name('books.store');
    Route::get('/books/{book}/edit', [BookController::class, 'edit'])->name('books.edit');
    Route::put('/books/{book}', [BookController::class, 'update'])->name('books.update');
    Route::delete('/books/{book}', [BookController::class, 'destroy'])->name('books.destroy');

    Route::post('/books/{book}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::post('/books/{book}/ratings', [RatingController::class, 'store'])->name('ratings.store');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/author/stats', [AuthorStatsController::class, 'index'])->name('author.stats');
});

Route::get('/books/{book}', [BookController::class, 'show'])->name('books.show');

Route::middleware(['auth', 'not.banned', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/users', [AdminController::class, 'users'])->name('users.index');
    Route::delete('/users/{user}', [AdminController::class, 'destroyUser'])->name('users.destroy');
    Route::patch('/users/{user}/role', [AdminController::class, 'updateUserRole'])->name('users.role');
    Route::post('/users/{user}/ban', [AdminController::class, 'banUser'])->name('users.ban');
    Route::post('/users/{user}/unban', [AdminController::class, 'unbanUser'])->name('users.unban');

    Route::get('/books', [AdminController::class, 'books'])->name('books.index');

    Route::get('/comments', [AdminController::class, 'comments'])->name('comments.index');
    Route::delete('/comments/{comment}', [AdminController::class, 'destroyComment'])->name('comments.destroy');
});

Route::get('/dashboard', [SiteController::class, 'dashboard'])->middleware(['auth', 'not.banned', 'verified'])->name('dashboard');

require __DIR__.'/auth.php';
