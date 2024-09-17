<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;
use App\Models\Area;
use App\Models\Category;

class ShopController extends Controller
{
    public function getShopsView(Request $request)
    {
        $shops = Shop::with(['area', 'category'])->select('id', 'name', 'area_id', 'category_id', 'img_url')->get();
        return view('index', compact('shops'));
    }

    public function viewShopDetails()
    {
        $shop = Shop::select('id');
    }
}
