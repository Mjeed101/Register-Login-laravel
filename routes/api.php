<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TweetController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/register', [AuthController::class, 'register']);

Route::post('/login', [AuthController::class, 'login']);

Route::get('/user/{id}', [UserController::class, 'getUser']);

Route::put('/user/{id}', [UserController::class, 'updateUser']);


Route::post('/tweets', [TweetController::class, 'createTweet']);

Route::get('/timeline', [TweetController::class, 'getTimeline']);

Route::delete('tweets/{id}',[TweetController::class,'deleteTweet']);
