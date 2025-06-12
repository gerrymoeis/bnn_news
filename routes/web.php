<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\CheckRole;
use App\Http\Middleware\CheckForApproval;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CategoryController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/post/{slug}', [HomeController::class, 'show'])->name('post.show');
Route::get('/kategori/{category:slug}', [HomeController::class, 'category'])->name('category.show');

Route::middleware(['auth', CheckForApproval::class])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware('verified')->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Post Management
    Route::resource('dashboard/posts', PostController::class)->names('posts');
    Route::patch('dashboard/posts/{post}/approve', [PostController::class, 'approve'])->name('posts.approve');
    Route::patch('dashboard/posts/{post}/reject', [PostController::class, 'reject'])->name('posts.reject');
});

require __DIR__.'/auth.php';

// Profile Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', CheckForApproval::class, CheckRole::class . ':Admin'])->group(function () {
    Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users.index');
    Route::patch('admin/users/{user}/approve', [UserController::class, 'approve'])->name('admin.users.approve');
    
    // Rute untuk Manajemen Kategori (Khusus Admin)
    Route::resource('admin/categories', CategoryController::class)->except(['show']);
});