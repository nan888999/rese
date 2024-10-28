<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\AdminRegisterRequest;
use App\Http\Requests\ManageShopRequest;
use App\Models\User;
use App\Models\Shop;
use App\Models\Reservation;
use App\Models\Area;
use App\Models\Category;

class AdminController extends Controller
{
    public function viewShopManage(Request $request)
    {
        // 検索フォーム表示
        $shops = Shop::with(['area', 'category'])->select('id', 'name', 'area_id', 'category_id', 'detail', 'img_url')->get();

        $areas = Area::select('id', 'name')->get();
        $categories = Category::select('id', 'name')->get();

        return view('admin.manager.shop_manage', compact('shops', 'areas', 'categories'));
    }

    public function search (Request $request)
    {
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

        return view ('admin.manager.shop_manage', compact('shops', 'areas', 'area_id', 'keyword', 'categories', 'category_id'));
    }

    public function addShop(ManageShopRequest $request)
    {
        $shop = $request->only('name', 'area_id', 'category_id', 'detail', 'img_url');

        // バリデータ取得
        $validator = $request->getValidator();

        // バリデーションに失敗した場合は、エラーをセッションにフラッシュする
        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput()
                ->with('open_modal_add', true);
        }

        Shop::create($shop);

        return redirect()->back()->with('message', '店舗が追加されました');
    }

    public function viewEditForm (request $request)
    {
        $shop_id = $request->input('shop_id');
        $shop = Shop::findOrFail($shop_id);
        $areas = Area::select('id', 'name')->get();
        $categories = Category::select('id', 'name')->get();

        return view ('admin.manager.edit_shop', compact('shop', 'areas', 'categories'));
    }

    public function editShop (ManageShopRequest $request)
    {
        $shop = $request->only('name', 'area_id', 'category_id', 'detail', 'img_url');

        Shop::findOrFail($request->shop_id)->update($shop);

        return redirect('admin.shop_manage')->with('message', '店舗情報が更新されました');
    }

    public function showReservation(Request $request)
    {
        $shop_id = $request->input('shop_id');
        $shop_name = Shop::find($shop_id)->name;
        $reservations = Reservation::where('shop_id', $shop_id)->get();

        return view ('admin.manager.reservation', compact('shop_name', 'reservations'));
    }

    public function viewAdminPanel()
    {
        return view ('admin.panel');
    }

    public function register(AdminRegisterRequest $request) {
        User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'role' => 2,
            'email_verified' => 9,
        ]);

        return redirect('admin.panel')->with('message', '店舗第代表者を登録しました');
    }
}
