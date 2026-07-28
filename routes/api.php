<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;

Route::post('/register', RegisterController::class)->name('register');
Route::post('/login', LoginController::class)->name('login');
Route::get('/blog', [PostController::class, 'index'])->name('posts.index');
Route::get('/blog/{post}', [PostController::class, 'show'])->name('posts.show');

Route::middleware('auth:sanctum')->group(function () {

    Route::get('profile', ProfileController::class)->name('profile');
    Route::post('logout', LogoutController::class)->name('logout');

    Route::apiResource('/posts', PostController::class)->names('posts')->except(['index', 'show']);
    Route::apiResource('/posts/{post}/comments', CommentController::class)->names('comments');
});

Route::post('/hellow-world', [HomeController::class, 'index'])->name('home');

Route::get('/sample', function () {
    return [
        ['id' => 1, 'name' => 'Hello'],
        ['id' => 2, 'name' => 'World'],
        ['id' => 3, 'name' => 'EZ!']
    ];
});
