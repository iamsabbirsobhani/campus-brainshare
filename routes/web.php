<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('login');
});

Route::get('/register', function () {
    return view('register');
});

Route::get('/userprofile', [UserController::class, 'userpro']);

Route::get('/logout', [UserController::class, 'logout']);

Route::post('/userlogin', [UserController::class, 'login']);
Route::post('/register', [UserController::class, 'create']);
