<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\ReviewRequest;
use App\Models\User;
use App\Models\Shop;
use App\Models\Reservation;
use App\Models\Area;
use App\Models\Category;
use App\Models\Favorite;
use App\Models\Review;
use App\Models\Feedback;
use Carbon\Carbon;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ShopController extends Controller
{
    public function getShopsView(Request $request)
    {
        $user_id = Auth::id();

        $shops = Shop::with(['area', 'category'])->select('id', 'name', 'area_id', 'category_id', 'img_url')->get();

        $areas = Area::select('id', 'name')->get();

        $categories = Category::select('id', 'name')->get();

        $favorite_shop_ids = Favorite::where('user_id', $user_id)->pluck('shop_id')->toArray();

        return view('index', compact('shops', 'areas', 'categories', 'favorite_shop_ids'));
    }

    public function showShopDetails(Request $request)
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
        })
        ->orderBy('date', 'asc')
        ->orderBy('time', 'asc')
        ->first();

        // QRコードの生成処理
        $qr_code = QrCode::size(100)->generate(url('/manager/reservation/today?shop_id=' . $shop_id));

        // 過去の口コミデータ
        $previous_feedback = Feedback::where('user_id', $user_id)->where('shop_id', $shop_id)->first();

        if($unreviewed_reservation) {
            $unreviewed_reservation_time = Carbon::createFromFormat('H:i:s', $unreviewed_reservation->time)->format('H:i');

            return view('reservation', compact('shop','today', 'now', 'number_options', 'reservation', 'unreviewed_reservation', 'unreviewed_reservation_time', 'qr_code', 'previous_feedback'));
        } else {
            return view('reservation', compact('shop','today', 'now', 'number_options', 'reservation', 'unreviewed_reservation', 'qr_code', 'previous_feedback'));
        }
    }

    public function review(ReviewRequest $request)
    {
        $user_id = Auth::id();

        $review = $request->only(['reservation_id', 'rating', 'comment']);

        // バリデータ取得
        $validator = $request->getValidator();

        // バリデーションに失敗した場合は、エラーをセッションにフラッシュする
        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput()
                ->with('open_modal', true);
        }

        // 予約IDが実際に存在するか確認
        if (!Reservation::where('id', $review['reservation_id'])->exists()) {
            return back()->withErrors(['reservation_id' => '無効な予約IDです']);
        }

        Review::create($review);

        return redirect()->back()->with('message', '評価が完了しました');
    }

    public function myPage(Request $request)
    {
        $user_id = Auth::id();

        $user_name = User::where('id', $user_id)->value('name');

        $today = Carbon::today()->format('Y-m-d');
        $now = Carbon::now()->format('H:i:s');
        $tomorrow = Carbon::tomorrow()->format('Y-m-d');

        $reserved_shops = Reservation::with(['shop:id,name'])
        ->where('user_id', $user_id)
        ->where(function ($query) use ($today, $now) {
            $query->where('date', '>=', $today)
            ->orWhere(function ($query) use ($today, $now) {
                $query->where('date', '=', $today)
                ->where('time', '>', $now);
            });
        })->orderBy('date', 'ASC')
        ->orderBy('time', 'ASC')
        ->get(['id', 'shop_id', 'date', 'time', 'number']);

        $number_options = [
            '1', '2', '3', '4',
            '5', '6', '7', '8',
            '9', '10',
        ];

        $favorite_shop_ids = Favorite::where('user_id', $user_id)->pluck('shop_id')->toArray();

        $favorite_shops = Shop::whereIn('id', $favorite_shop_ids)->with('area', 'category')->get();

        return view ('my_page', compact('user_id', 'user_name', 'reserved_shops', 'today', 'tomorrow', 'number_options',  'favorite_shop_ids', 'favorite_shops'));
    }

    public function favorite(Request $request)
    {
        $user_id = Auth::id();

        $form = [
            'user_id' => $user_id,
            'shop_id' => $request->input('shop_id'),
        ];

        Favorite::create($form);

        return redirect()->back();
    }

    public function unfavorite (Request $request)
    {
        $user_id = Auth::id();

        $favorite = Favorite::where('user_id', $user_id)->where('shop_id', $request->shop_id)->first();

        if(!$favorite) {
            return redirect()->back()->with('error_message', 'お気に入りが見つかりませんでした');
        }

        $favorite->delete();
        return redirect()->back();
    }

    public function search (Request $request)
    {
        $user_id = Auth::id();
        $shops_query = Shop::with(['area', 'category'])->select('id', 'name', 'area_id', 'category_id', 'img_url');

        /* area検索 */
        $areas = Area::select('id', 'name')->get();
        $area_id = $request->input('area');
        if(!empty($area_id)) {
            $shops_query->where('area_id', '=', $area_id);
        }

        /* genre検索 */
        $categories = Category::select('id', 'name')->get();
        $category_id = $request->input('category');
        if(!empty($category_id)) {
            $shops_query->where('category_id', '=', $category_id);
        }

        /* keyword検索 */
        $keyword = $request->input('keyword');
        if(!empty($keyword)) {
            $shops_query->where('name', 'LIKE', "%{$keyword}%");
        }

        /* sort機能 */
        $sort_option = $request->input('sort');
        if ($sort_option) {
            if ($sort_option === 'random') {
                $shops_query->inRandomOrder();
            } elseif ($sort_option === 'high' || $sort_option === 'low') {
                $shops_query->leftJoin(
                    DB::raw('(SELECT shop_id, AVG(rating) as average_feedback_rating FROM feedbacks GROUP BY shop_id) as avg_ratings'),
                    'shops.id', '=', 'avg_ratings.shop_id'
                );

                $is_null_order = 'ISNULL(avg_ratings.average_feedback_rating) asc';
                $average_order = $sort_option === 'high' 
                    ? 'avg_ratings.average_feedback_rating desc' 
                    : 'avg_ratings.average_feedback_rating asc';

                $shops_query->orderByRaw($is_null_order)->orderByRaw($average_order);
            } else {
                return redirect()->back()->with('error_message', 'エラーが発生しました');
            }
            $shops = $shops_query->get();
            $favorite_shop_ids = Favorite::where('user_id', $user_id)->pluck('shop_id')->toArray();

            return view ('index', compact('shops', 'areas', 'area_id', 'keyword', 'categories', 'category_id', 'sort_option', 'favorite_shop_ids'));
        }
    }
}