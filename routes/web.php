<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MessageController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    if (!Auth::check()) {
        return view('welcome');
    } else {
        return redirect('/userprofile');
    }
});

Route::get('/login', function () {
    return view('login');
});

Route::get('/register', function () {
    return view('register');
});

Route::get('/userprofile', [UserController::class, 'userpro']);
Route::get('/userprofile/message', [MessageController::class, 'getmessages']);

Route::get('/userprofile/editprofile', [UserController::class, 'edituserpro']);

Route::get('/logout', [UserController::class, 'logout']);

Route::post('/userlogin', [UserController::class, 'login']);
Route::post('/register', [UserController::class, 'create']);
Route::post('/usereditprofile', [UserController::class, 'editprofile']);
Route::post('/searchexpert', [UserController::class, 'getallexpertsoncourses']);
