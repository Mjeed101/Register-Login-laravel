<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/test', function () {
    return "Hello, World!";
});

Route::get('/users', [UserController::class, 'index']);
