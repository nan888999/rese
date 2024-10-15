<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\ReservationController;

Route::get('/', [ShopController::class, 'getShopsView']);

Route::get('/login', [UserController::class, 'viewLogin']);

Route::post('/login', [UserController::class, 'login'])->name('login');

Route::get('/logout', [UserController::class, 'logout']);

Route::get('/register', [UserController::class, 'viewRegister']);

Route::post('/register', [UserController::class, 'register']);

Route::get('/shop_details', [ShopController::class, 'showShopDetails'])->name('shop.details');

Route::post('/reservation_confirm', [ShopController::class, 'showReservationConfirm']);

Route::post('/reservation', [ShopController::class, 'reservation']);

Route::post('/favorite', [ShopController::class, 'favorite']);

Route::post('/unfavorite', [ShopController::class, 'unfavorite']);

Route::get('/search', [ShopController::class, 'search']);

Route::get('/my_page', [ShopController::class, 'myPage']);

Route::post('/cancel', [ShopController::class, 'cancel']);