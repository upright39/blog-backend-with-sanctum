<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use GuzzleHttp\Middleware;





// public routes

Route::get('/posts', [PostController::class, "Post"]);
Route::post('/register', [AuthController::class, "register"]);
Route::post('/login', [AuthController::class, "login"]);


// protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/addPost', [PostController::class, "addPost"]);
    Route::post('/logout', [AuthController::class, "logout"]);
});
