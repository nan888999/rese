<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;

class ReservationRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $today = Carbon::today()->format('Y-m-d');
        $twoYearsFromToday = Carbon::today()->addYears(2)->format('Y-m-d');

        return [
            'date' => 'required | date',
            'time' => 'required | date_format:H:i',
            'number' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'date.required' => '日付を選択してください',
            'date.date' => '日付形式で入力してください',
            'time.required' => '時刻を選択してください',
            'time.date_format' => '時刻はHH:MM形式で入力してください',
            'number.required' => '人数を選択してください'
        ];
    }
}
