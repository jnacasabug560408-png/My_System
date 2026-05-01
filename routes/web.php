<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\CommentController;

/*
|--------------------------------------------------------------------------
| CMS Web Routes
|--------------------------------------------------------------------------
*/

// 1. LANDING PAGE & PUBLIC VIEWING
Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/posts', [ContentController::class, 'publicIndex'])->name('posts.public.index');
Route::get('/posts/{content:slug}', [ContentController::class, 'show'])->name('posts.public.show');
Route::get('/tags/{tag:slug}', [TagController::class, 'show'])->name('tags.show');

Route::get('/category-filter/{category:slug}', [CategoryController::class, 'show'])->name('categories.show');

// 2. PUBLIC/GUEST ROUTES (Login, Register, etc.)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
    Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
});

// 3. PROTECTED ROUTES (Lahat ng roles na naka-login)
Route::middleware('auth')->group(function () {
    
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Comment Posting (Para sa lahat)
    Route::post('/posts/{content:slug}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');
    
    // Personal Comment History (Subscriber/Author/Editor can see their own)
    Route::get('/my-comments', [CommentController::class, 'subscriberIndex'])->name('subscriber.comments');
    Route::get('/comments/{comment}', [CommentController::class, 'show'])->name('comments.show'); 
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

    // 4. CONTENT CREATION (Admin, Editor, Author, Subscriber - based sa AppServiceProvider)
    Route::middleware('can:canCreateContent')->group(function () {
        Route::resource('contents', ContentController::class);
        Route::resource('media', MediaController::class)->only(['index', 'store', 'destroy']);
    });

    // 5. MODERATION (Admin at Editor lang - match sa moderate.comments Gate)
    Route::middleware('can:moderate.comments')->group(function () {
        Route::get('/all-comments', [CommentController::class, 'index'])->name('comments.index');
        Route::patch('/comments/{comment}/approve', [CommentController::class, 'approve'])->name('comments.approve');
        Route::patch('/comments/{comment}/reject', [CommentController::class, 'reject'])->name('comments.reject');
        Route::patch('/comments/{comment}/spam', [CommentController::class, 'spam'])->name('comments.spam');
        
        // Content Publishing powers
        Route::patch('/contents/{content}/publish', [ContentController::class, 'publish'])->name('contents.publish');
        Route::patch('/contents/{content}/unpublish', [ContentController::class, 'unpublish'])->name('contents.unpublish');
        Route::get('/contents-moderation', [ContentController::class, 'moderation'])->name('contents.moderation');
    });

    // 6. SUPER ADMIN ONLY (Users, Categories, Analytics)
    Route::middleware('can:admin')->group(function () {
        Route::resource('users', UserController::class);
        Route::patch('/users/{user}/activate', [UserController::class, 'activate'])->name('users.activate');
        Route::patch('/users/{user}/deactivate', [UserController::class, 'deactivate'])->name('users.deactivate');
        
        Route::resource('categories', CategoryController::class);
        Route::resource('tags', TagController::class)->except(['show']);
        
        Route::patch('/contents/{content}/status', [ContentController::class, 'updateStatus'])->name('contents.updateStatus');
        Route::get('/analytics', [DashboardController::class, 'analytics'])->name('analytics');
        Route::get('/reports', [DashboardController::class, 'reports'])->name('reports');
    });
});