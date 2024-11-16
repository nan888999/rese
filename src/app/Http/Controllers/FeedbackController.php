<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Shop;
use App\Models\Area;
use App\Models\Category;
use App\Models\Favorite;
use App\Models\Feedback;
use App\Http\Requests\FeedbackRequest;

class FeedbackController extends Controller
{
    public function viewFeedbackForm(Request $request)
    {
        $user_id = Auth::id();
        $shop_id = $request->query('shop_id');
        $shop = Shop::find($shop_id);

        $favorite_shop = Favorite::where('user_id', $user_id)->where('shop_id', $shop_id)->first();

        $previous_feedback = Feedback::where('user_id', $user_id)->where('shop_id', $shop_id)->first();

        return view('feedback', compact('user_id', 'shop', 'favorite_shop', 'previous_feedback'));
    }

    public function feedback(FeedbackRequest $request)
    {
        $user_id = Auth::id();
        $shop_id = $request->input('shop_id');
        $data = $request->only(['shop_id', 'rating', 'comment']);
        $img_path = null;

        if($request->hasFile('img') && $request->file('img')->isValid()) {
            $path = $request->file('img')->store('public/img/user');
            $img_path = Storage::url($path);
            session()->flash('uploaded_img', $img_path);
        }

        $previous_feedback = Feedback::where('user_id', $user_id)->where('shop_id', $shop_id)->first();

        $feedback = array_merge(
            $data,
            ['user_id' => $user_id],
            $img_path ? ['img_path' => $img_path] : [],
        );

        if ($previous_feedback) {
            $previous_feedback->update($feedback);
            session()->forget('uploaded_img');
            return redirect()->back()->with('message', '口コミを更新しました');
        } else {
            Feedback::create($feedback);
            session()->forget('uploaded_img');
            return redirect()->back()->with('message', '口コミを投稿しました');
        }
    }

    public function deleteFeedback(Request $request)
    {
        $feedback_id = $request->input('feedback_id');
        if($feedback_id) {
            $feedback = Feedback::find($feedback_id);
            $feedback_user_id = $feedback->user_id;
            $user_id = Auth::id();
            if($feedback_user_id == $user_id) {
                $feedback->delete();
                return redirect()->back()->with('message', '口コミを削除しました');
            } else {
                return redirect()->back()->with('error_message', 'この口コミは削除できません');
            }
        } else {
            return redirect()->back()->with('error_message', '口コミが見つかりません');
        }
    }

    public function showAllFeedbacks(Request $request)
    {
        $user_id = Auth::id();
        $shop_id = $request->input('shop_id');
        $shop = Shop::find($shop_id);
        $favorite_shop = Favorite::where('user_id', $user_id)->where('shop_id', $shop_id)->first();
        $feedbacks = Feedback::where('shop_id', $shop_id)->get();

        return view('all_feedbacks', compact('shop','favorite_shop' ,'feedbacks'));
    }
}
