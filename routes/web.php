<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\AuditLogController;

Route::get('/', [PostController::class, 'index'])->name('home');
Route::get('/search', [PostController::class, 'search'])->name('posts.search');
Route::middleware('auth')->group(function () {
    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
    Route::get('/logs', [AuditLogController::class, 'index'])->name('logs.index');
    Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
    Route::get('/admin/users', [\App\Http\Controllers\AdminController::class, 'index'])->name('admin.users');
    Route::post('/admin/users/{user}/toggle-block', [\App\Http\Controllers\AdminController::class, 'toggleBlock'])->name('admin.toggleBlock');
    Route::delete('/comments/{comment}', [\App\Http\Controllers\CommentController::class, 'destroy'])->name('comments.destroy');
});
Route::get('/language/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'lv'])) {
        session(['locale' => $locale]);
    }
    return back();
})->name('language.switch');
Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');
// Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
