<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;
use App\Models\Category;

class ShopController extends Controller
{
    public function getShopsView(Request $request)
    {
        $shops = Shop::select('id', 'name', 'area', 'category', 'img_url')->get();
        $shops->map(function ($shop) {
            $areaMapping = [
                1 => '東京都',
                2 => '大阪府',
                3 => '福岡県',
            ];
            $shop->area = $areaMapping[$shop->area] ?? '';
        });
        $shops->map(function ($shop) {
            $categoryMapping = [
                1 =>'イタリアン',
                2 =>'ラーメン',
                3 =>'居酒屋',
                4 =>'寿司',
                5 =>'焼肉',
            ];
            $shop->category = $categoryMapping[$shop->category] ?? '';
        });
        return view('index', compact('shops'));
    }
}
