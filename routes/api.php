<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;

Route::post('/register', LoginController::class)->name('register');
Route::post('/login', RegisterController::class)->name('login');

Route::middleware('auth:sanctum')->group(function () {

    Route::get('profile', ProfileController::class)->name('profile');
    Route::post('logout', LogoutController::class)->name('logout');

    Route::apiResource('/posts', PostController::class)->names('posts');
    Route::apiResource('/posts/{post}/comments', CommentController::class)->names('comments');
});

Route::post('/hellow-world', [HomeController::class, 'index'])->name('home');
