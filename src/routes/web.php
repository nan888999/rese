<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ShopController;

Route::get('/', [ShopController::class, 'getShopsView']);

Route::get('/register', [UserController::class, 'showRegister']);

Route::post('/register', [UserController::class, 'register']);

Route::get('/login', [UserController::class, 'showLogin']);

Route::post('/login', [UserController::class, 'login']);

Route::middleware('auth')->group(function (){
  Route::get('/', [ShopController::class, 'getShopsView']);
});

Route::post('/logout', [UserController::class, 'logout']);