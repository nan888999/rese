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

Route::post('/reservation_confirm', [ShopController::class, 'showReservationConfirm']);

Route::post('/reservation', [ShopController::class, 'reservation']);

Route::get('/reservation/done', function () {
    return view('done');
})->name('reservation.done');

Route::post('/favorite', [ShopController::class, 'favorite']);

Route::post('/unfavorite', [ShopController::class, 'unfavorite']);

Route::get('/my_page', [ShopController::class, 'myPage']);

Route::post('/cancel', [ShopController::class, 'cancel']);