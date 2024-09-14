<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShopController;


Route::get('/', [ShopController::class, 'getShopsView']);
