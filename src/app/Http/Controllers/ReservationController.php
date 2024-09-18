<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Shop;
use App\Models\Reservation;

class ReservationController extends Controller
{
    public function reservation(Request $request)
    {
        $user_id = Auth::id();

        $shop_id = $request->input('shop_id');
        $shop = Shop::find($shop_id);

        $date = $request->input('date');

        $time = $request->input('time');

        $number = $request->input('number');

        Reservation::create([
            'user_id' => $user_id,
            'shop_id' => $shop_id,
            'date' => $date,
            'time' => $time,
            'number' => $number,
        ]);
        return view ('done');
    }
}
