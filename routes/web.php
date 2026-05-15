<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::get('/posts/create', [PostController::class,'create'])->name('posts.create');
    Route::get('/posts/trashed', [PostController::class, 'trashed'])->name('posts.trashed');
    Route::get('/posts/{id}', [PostController::class, 'show'])->name('posts.show');
    // Route::get('/posts/{id}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::put('/posts/{id}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{id}', [PostController::class, 'destroy'])->name('posts.destroy');

    // restore soft deleted resource
    Route::patch('/posts/{id}/restore', [PostController::class, 'restore'])->name('posts.restore');

    // comments
    Route::post('/posts/{id}/comments', [PostController::class, 'storeComment'])->name('posts.comments.store');

    // likes (polymorphic)
    Route::post('/posts/{id}/like', [PostController::class, 'likePost'])->name('posts.like');
    Route::post('/posts/{postId}/comments/{commentId}/like', [PostController::class, 'likeComment'])->name('posts.comments.like');
    
    Route::resource('users', UserController::class)->middleware('isAdmin');
});

require __DIR__.'/auth.php';
