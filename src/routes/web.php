<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\AdminController;

Route::get('/login', [UserController::class, 'viewLogin']);
Route::post('/login', [UserController::class, 'login'])->name('login');

Route::get('/register', [UserController::class, 'viewRegister'])->name('viewRegister');
Route::post('/register', [UserController::class, 'register']);

// メール認証ページとメール認証処理
Route::get('/verify_email', [UserController::class, 'viewVerifyEmail']);
Route::post('/verify_email', [UserController::class, 'verifyEmail']);

// 認証メール内リンククリック時の処理
Route::get('/email/verify/{id}/{hash}', [UserController::class, 'emailVerified'])->middleware('signed')->name('verification.verify');

// 認証が必要なルート
Route::middleware(['check.session'])->group(function () {
  Route::get('/', [ShopController::class, 'getShopsView']);

  Route::get('/logout', [UserController::class, 'logout']);

  Route::get('/shop_details', [ShopController::class, 'showShopDetails'])->name('shop.details');

  Route::post('/reservation_confirm', [ShopController::class, 'showReservationConfirm']);

  Route::post('/reservation', [ShopController::class, 'reservation']);

  Route::post('/favorite', [ShopController::class, 'favorite']);

  Route::post('/unfavorite', [ShopController::class, 'unfavorite']);

  Route::get('/search', [ShopController::class, 'search']);

  Route::get('/my_page', [ShopController::class, 'myPage']);

  Route::post('/cancel_reservation', [ShopController::class, 'cancelReservation']);

  Route::post('/update_reservation', [ShopController::class, 'updateReservation']);

  Route::post('/review', [ShopController::class, 'review']);
});

// 管理者権限が必要なルート
Route::middleware(['check.role'])->group(function() {
  Route::get('/admin/manage', [AdminController::class, 'viewShopManage'])->name('admin.index');

  Route::get('/admin/search', [AdminController::class, 'search']);

  Route::post('/admin/add_shop', [AdminController::class, 'addShop']);

  Route::post('/admin/edit_shop', [AdminController::class, 'editShop']);
});