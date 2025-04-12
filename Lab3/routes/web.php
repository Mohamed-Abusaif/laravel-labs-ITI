<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('posts', PostController::class);

// Restore soft deleted post
Route::get('/posts/{post}/restore', [PostController::class, 'restore'])->name('posts.restore');

// Routes for comments
Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');
Route::get('/comments/{comment}/edit', [CommentController::class, 'edit'])->name('comments.edit');
Route::put('/comments/{comment}', [CommentController::class, 'update'])->name('comments.update');
Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
Route::get('/comments/{comment}/delete', [CommentController::class, 'destroy'])->name('comments.confirm-delete');
