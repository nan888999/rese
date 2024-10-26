<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AdminRegisterRequest;
use App\Http\Requests\ManageShopRequest;
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

        return view('/admin/shop/manage', compact('shops', 'areas', 'categories'));
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

        return view ('/admin/shop/manage', compact('shops', 'areas', 'area_id', 'keyword', 'categories', 'category_id'));
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

    public function editShop (ManageShopRequest $request)
    {
        $shop = $request->only('name', 'area_id', 'category_id', 'detail', 'img_url');

        // バリデータ取得
        $validator = $request->getValidator();

        // バリデーションに失敗した場合は、エラーをセッションにフラッシュする
        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput()
                ->with('open_modal_edit', true);
        }

        Shop::find($request->shop_id)->update($shop);

        return redirect()->back()->with('message', '店舗情報が更新されました');
    }

    public function register(AdminRegisterRequest $request) {
        User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'role' => 2,
            'email_verified' => 9,
        ]);

        return redirect()->with('message', '店舗第代表者を登録しました');
    }
}
