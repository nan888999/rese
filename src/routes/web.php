<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\ReservationController;

Route::get('/', [ShopController::class, 'getShopsView']);

Route::get('/register', [UserController::class, 'showRegister']);

Route::post('/register', [UserController::class, 'register']);

Route::get('/login', [UserController::class, 'showLogin']);

Route::post('/login', [UserController::class, 'login'])->name('login');

Route::middleware('auth')->group(function (){
  Route::get('/', [ShopController::class, 'getShopsView']);
});

Route::get('/logout', [UserController::class, 'logout']);

Route::get('/shop_details', [ShopController::class, 'viewShopDetails']);

Route::post('/reservation', [ReservationController::class, 'reservation']);