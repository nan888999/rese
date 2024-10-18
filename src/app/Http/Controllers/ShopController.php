<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Shop;
use App\Models\Reservation;
use App\Models\Area;
use App\Models\Category;
use App\Models\Favorite;
use App\Http\Requests\ReservationRequest;
use Carbon\Carbon;

class ShopController extends Controller
{
    public function getShopsView(Request $request)
    {
        if(Auth::check()) {
            $user_id = Auth::id();

            $shops = Shop::with(['area', 'category'])->select('id', 'name', 'area_id', 'category_id', 'img_url')->get();

            $areas = Area::select('id', 'name')->get();

            $categories = Category::select('id', 'name')->get();

            $favorite_shop_ids = Favorite::where('user_id', $user_id)->pluck('shop_id')->toArray();

            return view('index', compact('shops', 'areas', 'categories', 'favorite_shop_ids'));
        } else {
            return redirect ('/login');
        }
    }

    public function showShopDetails(Request $request)
    {
        $shop_id = $request->input('shop_id');
        $shop = Shop::where('id', $shop_id)->first();

        $today = Carbon::today()->format('Y-m-d');

        $number_options = [
            '1', '2', '3', '4',
            '5', '6', '7', '8',
            '9', '10',
        ];

        $reservation = $request->only(['date', 'time', 'number']);

        return view('reservation', compact('shop','today', 'number_options', 'reservation'));
    }

    public function showReservationConfirm(Request $request)
    {
        $shop_id = $request->input('shop_id');
        $shop = Shop::where('id', $shop_id)->first();

        $reservation = $request->only(['date', 'time', 'number']);

        $today = Carbon::today()->format('Y-m-d');

        $number_options = [
            '1', '2', '3', '4',
            '5', '6', '7', '8',
            '9', '10',
        ];

        return redirect()->route('shop.details', [
            'shop_id' => $shop->id,
            'today' => $today,
            'date' => $reservation['date'] ?? null,
            'time' => $reservation['time'] ?? null,
            'number' => $reservation['number'] ?? null,
            'number_options' => $number_options,
        ]);

    }

    public function reservation(ReservationRequest $request)
    {
        $user_id = Auth::id();

        if(!$user_id) {
            return redirect ('/login')->with('error_message', 'もう一度ログインし直してください。');
        }

        $reservation_data = $request->only(['shop_id', 'date', 'time', 'number',]);

        $today = Carbon::today()->format('Y-m-d');

        if(!empty($reservation_data['shop_id']) && !empty($reservation_data['date']) && !empty($reservation_data['time']) && !empty($reservation_data['number'])) {
            Reservation::create(array_merge($reservation_data, ['user_id' => $user_id]));
            return view ('done');
        } else {
            return route('shop.details');
        }
    }

    public function myPage(Request $request)
    {
        $user_id = Auth::id();
        if(!$user_id) {
            return redirect ('/login')->with('error_message', 'もう一度ログインし直してください');
        }

        $user_name = User::where('id', $user_id)->value('name');

        $reserved_shops = Reservation::with(['shop:id,name'])
        ->where('user_id', $user_id)
        ->orderBy('date', 'ASC')
        ->orderBy('time', 'ASC')
        ->get(['id', 'shop_id', 'date', 'time', 'number']);

        $today = Carbon::today()->format('Y-m-d');

        $number_options = [
            '1', '2', '3', '4',
            '5', '6', '7', '8',
            '9', '10',
        ];

        $favorite_shop_ids = Favorite::where('user_id', $user_id)->pluck('shop_id')->toArray();

        $favorite_shops = Shop::whereIn('id', $favorite_shop_ids)->with('area', 'category')->get();

        return view ('my_page', compact('user_id', 'user_name', 'reserved_shops', 'today', 'number_options',  'favorite_shop_ids', 'favorite_shops'));
    }

    public function cancelReservation (Request $request)
    {
        if(Auth::check()) {
            $user_id = Auth::id();
            $shop_id = $request->input('shop_id');
            Reservation::where('user_id', $user_id)
            ->where('shop_id', $shop_id)
            ->first()
            ->delete();
            return redirect ('/my_page');
        } else {
            return redirect ('/login')->with('error_message', 'もう一度ログインし直してください');
        }
    }

        public function updateReservation(Request $request)
    {
        $user_id = Auth::id();

        if(!$user_id) {
            return redirect ('/login')->with('error_message', 'もう一度ログインし直してください。');
        }

        $today = Carbon::today()->format('Y-m-d');

        $reservation_data = $request->only(['shop_id', 'date', 'time', 'number']);

        unset($reservation_data['_token']);
        $reservation = Reservation::find($request->reservation_id);

        if($reservation) {
            $reservation->update($reservation_data);
            return redirect ('/my_page');
        } else {
            return redirect ('/my_page')->with('error_message', '予約が見つかりません');
        }
    }

    public function favorite(Request $request)
    {
        $user_id = Auth::id();
        if(!$user_id) {
            return redirect ('/login')->with('error_message', 'もう一度ログインし直してください');
        }

        $form = [
            'user_id' => $user_id,
            'shop_id' => $request->input('shop_id'),
        ];
        Favorite::create($form);
        return redirect ('/');
    }

    public function unfavorite (Request $request)
    {
        $user_id = Auth::id();
        if(!$user_id) {
            return redirect ('/login')->with('error_message', '再度ログインしてください');
        }
        Favorite::where('user_id', $user_id)->find($request->shop_id)->delete();
        return redirect('/');
    }

    public function search (Request $request)
    {
        $user_id = Auth::id();
        $query = Shop::query();

        /* area検索 */
        $areas = Area::select('id', 'name')->get();
        $area_id = $request->input('area');
        if(!empty($area_id)) {
            $query->where('area_id', '=', $area_id);
        }

        /* genre検索 */
        $categories = Category::select('id', 'name')->get();
        $category_id = $request->input('category');
        if(!empty($category_id)) {
            $query->where('category_id', '=', $category_id);
        }

        /* keyword検索 */
        $keyword = $request->input('keyword');
        if(!empty($keyword)) {
            $query->where('name', 'LIKE', "%{$keyword}%");
        }

        $shops = $query->get();
        $favorite_shop_ids = Favorite::where('user_id', $user_id)->pluck('shop_id')->toArray();

        return view ('index', compact('shops', 'areas', 'area_id', 'keyword', 'categories', 'category_id', 'favorite_shop_ids'));
    }
}