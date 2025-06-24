<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthenticationController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\TagController;
use App\Http\Controllers\Api\BlogController;

Route::post('register', [AuthenticationController::class, 'register'])->name('register');
Route::post('login', [AuthenticationController::class, 'login'])->name('login');

Route::middleware('auth:api')->group(function () {
    Route::post('/logout', [AuthenticationController::class, 'logout'])->name('logout');
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

     Route::get('/users', [UserController::class, 'index']);
     Route::apiResource('categories', CategoryController::class);
     Route::apiResource('tags', TagController::class);
     Route::apiResource('blogs', BlogController::class);
     Route::get('blogs/{id}/comments', [CommentController::class, 'index']);
     Route::post('comments', [CommentController::class, 'store']);
});
