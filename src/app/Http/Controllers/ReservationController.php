<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests\ReservationRequest;
use App\Http\Requests\UpdateReservationRequest;
use App\Models\Shop;
use App\Models\Reservation;
use App\Models\Feedback;
use Carbon\Carbon;

class ReservationController extends Controller
{
    public function showReservationConfirm(Request $request)
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

    public function cancelReservation (Request $request)
    {
        $user_id = Auth::id();
        $shop_id = $request->input('shop_id');

        $reservation = Reservation::where('user_id', $user_id)
        ->where('shop_id', $shop_id)
        ->first();

        if ($reservation) {
            $reservation->delete();
            return redirect('/my_page')->with('success_message', '予約をキャンセルしました');
        } else {
            return redirect('/my_page')->with('error_message', '該当する予約が見つかりません');
        }
    }

    public function showUpdateReservationForm(Request $request)
    {
        $reservation_id = $request->input('reservation_id');

        $reservation = Reservation::find($reservation_id);

        $reservation_time = optional($reservation)->time;
            if ($reservation_time) {
                $reservation_time = Carbon::createFromFormat('H:i:s', $reservation_time)->format('H:i');
            }

        $number_options = [
            '1', '2', '3', '4',
            '5', '6', '7', '8',
            '9', '10',
        ];

        $tomorrow = Carbon::tomorrow()->format('Y-m-d');

        return view ('update_reservation', compact('reservation', 'reservation_time', 'number_options', 'tomorrow'));
    }

    public function updateReservation(UpdateReservationRequest $request)
    {
        $user_id = Auth::id();

        $tomorrow = Carbon::tomorrow()->format('Y-m-d');
        $now = Carbon::now()->format('H:i:s');

        $reservation_data = $request->only(['shop_id', 'date', 'time', 'number']);

        unset($reservation_data['_token']);
        $reservation = Reservation::find($request->reservation_id);

        if($reservation) {
            $reservation->update($reservation_data);
            return redirect ('/my_page')->with('message', '予約を変更しました');
        } else {
            return redirect ('/my_page')->with('error_message', '予約が見つかりません');
        }
    }
}
