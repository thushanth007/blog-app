<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MyPostController;
use App\Http\Controllers\UserPostController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminPostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\Auth\ProviderController;

// Route for the homepage
Route::get('/', [HomeController::class, 'index'])->name('home');

// User
Route::middleware('auth')->group(function () {
    // dashboard
    Route::get('/dashboard', [DashboardController::class, 'show'])->name('dashboard');
    Route::get('/my-post', [MyPostController::class, 'show'])->name('my-post');
    Route::get('/user-post/{id}', [UserPostController::class, 'show'])->name('user-post');

    // profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // post
    Route::get('/posts/add', [PostController::class, 'add'])->name('posts.add');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::get('/posts/{post}', [PostController::class, 'edit'])->name('posts.edit');
    Route::patch('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');

    // Route for storing a new comment
    Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');

    // Route for deleting a comment
    Route::delete('/comments/{id}', [CommentController::class, 'destroy']);
});

// Admin
Route::middleware('auth')->group(function () {
    Route::get('/admin-dashboard', [AdminController::class, 'show'])->name('admin.dashboard');
    Route::get('/admin-post/{post}', [AdminPostController::class, 'edit'])->name('admin.edit');
    Route::patch('/admin-post-status/{post}', [AdminPostController::class, 'updateStatus'])->name('admin.update-status');
    Route::delete('/admin-post/{post}', [AdminPostController::class, 'destroy'])->name('admin.post-destroy');
});

Route::get('/auth/{provider}/redirect', [ProviderController::class, 'redirect']);
Route::get('/auth/{provider}/callback', [ProviderController::class, 'callback']);

require __DIR__.'/auth.php';
