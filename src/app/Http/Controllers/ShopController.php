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
use App\Models\Review;
use App\Http\Requests\AuthRequest;
use App\Http\Requests\ReservationRequest;
use App\Http\Requests\ReviewRequest;
use Carbon\Carbon;

class ShopController extends Controller
{
    public function getShopsView(AuthRequest $request)
    {
        $user_id = Auth::id();

        $shops = Shop::with(['area', 'category'])->select('id', 'name', 'area_id', 'category_id', 'img_url')->get();

        $areas = Area::select('id', 'name')->get();

        $categories = Category::select('id', 'name')->get();

        $favorite_shop_ids = Favorite::where('user_id', $user_id)->pluck('shop_id')->toArray();

        return view('index', compact('shops', 'areas', 'categories', 'favorite_shop_ids'));
    }

    public function showShopDetails(AuthRequest $request)
    {
        $shop_id = $request->input('shop_id');
        $shop = Shop::where('id', $shop_id)->first();

        $today = Carbon::today()->format('Y-m-d');
        $now = Carbon::now()->format('H:i');

        $number_options = [
            '1', '2', '3', '4',
            '5', '6', '7', '8',
            '9', '10',
        ];

        $reservation = $request->only(['date', 'time', 'number']);

        // 予約済情報
        $user_id = Auth::id();
        $reserved_ids = Reservation::where([
            ['user_id', '=', $user_id],
            ['shop_id', '=', $shop_id],
        ])->pluck('id');

        // 予約済だがレビューのない予約ID
        $unreviewed_reservation = Reservation::whereIn('id', $reserved_ids)->whereNotIn('id', function($query) {
            $query->select('reservation_id')->from('reviews');
        })->first();

        if($unreviewed_reservation) {
            $unreviewed_reservation_time = Carbon::createFromFormat('H:i:s', $unreviewed_reservation->time)->format('H:i');

            return view('reservation', compact('shop','today', 'now', 'number_options', 'reservation', 'unreviewed_reservation', 'unreviewed_reservation_time'));
        } else {
            return view('reservation', compact('shop','today', 'now', 'number_options', 'reservation', 'unreviewed_reservation'));
        }
    }

    public function showReservationConfirm(AuthRequest $request)
    {
        $shop_id = $request->input('shop_id');
        $shop = Shop::where('id', $shop_id)->first();

        $reservation = $request->only(['date', 'time', 'number']);

        $today = Carbon::today()->format('Y-m-d');

        $now = Carbon::now()->format('H:i');

        $number_options = [
            '1', '2', '3', '4',
            '5', '6', '7', '8',
            '9', '10',
        ];

        $route_parameters = [
            'shop_id' => $shop->id,
            'today' => $today,
            'date' => $reservation['date'] ?? null,
            'time' => $reservation['time'] ?? null,
            'number' => $reservation['number'] ?? null,
            'number_options' => $number_options,
        ];

        if(!empty($reservation['date']) && !empty($reservation['time']) && $reservation['date'] == $today && $reservation['time'] < $now) {
            return redirect()->route('shop.details', $route_parameters)->withErrors(['time' => '過去の時刻を選択しないでください']);
        }

        return redirect()->route('shop.details', $route_parameters);
    }

    public function reservation(ReservationRequest $request)
    {
        $user_id = Auth::id();

        $reservation_data = $request->only(['shop_id', 'date', 'time', 'number',]);

        $today = Carbon::today()->format('Y-m-d');

        $now = Carbon::now()->format('H:i:s');

        if(!empty($reservation_data['shop_id']) && !empty($reservation_data['date']) && !empty($reservation_data['time']) && !empty($reservation_data['number'])) {
            Reservation::create(array_merge($reservation_data, ['user_id' => $user_id]));
            return view ('done');
        } else {
            return route('shop.details');
        }
    }

    public function review(ReviewRequest $request)
    {
        $user_id = Auth::id();

        $review = $request->only(['reservation_id', 'rating', 'comment']);

        Review::create($review);

        return redirect()->back()->with('message', '評価が完了しました');
    }

    public function myPage(AuthRequest $request)
    {
        $user_id = Auth::id();

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

    public function cancelReservation (AuthRequest $request)
    {
        $user_id = Auth::id();
        $shop_id = $request->input('shop_id');
        Reservation::where('user_id', $user_id)
        ->where('shop_id', $shop_id)
        ->first()
        ->delete();
        return redirect ('/my_page');
    }

    public function updateReservation(AuthRequest $request)
    {
        $user_id = Auth::id();

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

    public function favorite(AuthRequest $request)
    {
        $user_id = Auth::id();

        $form = [
            'user_id' => $user_id,
            'shop_id' => $request->input('shop_id'),
        ];

        Favorite::create($form);

        return redirect()->back();
    }

    public function unfavorite (AuthRequest $request)
    {
        $user_id = Auth::id();

        $favorite = Favorite::where('user_id', $user_id)->where('shop_id', $request->shop_id)->first();

        if(!$favorite) {
            return redirect()->back()->with('error_message', 'お気に入りが見つかりませんでした');
        }

        $favorite->delete();
        return redirect()->back();
    }

    public function search (AuthRequest $request)
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