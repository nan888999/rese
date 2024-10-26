<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Exceptions\HttpResponseException;
use Carbon\Carbon;

class ReservationRequest extends FormRequest
{
    protected $redirect = '/login';

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $today = Carbon::today()->format('Y-m-d');

        return [
            'date' => 'required | date | after_or_equal:'. $today,
            'time' => 'required | date_format:H:i',
            'number' => 'required',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            // 入力された日付と時刻を取得
            $inputDate = $this->input('date');
            $inputTime = $this->input('time');

            // 現在の日付と時刻
            $currentDate = Carbon::today()->format('Y-m-d');
            $currentTime = Carbon::now()->format('H:i');

            // 日付が今日かつ時刻が現在の時刻よりも前ならエラー
            if ($inputDate == $currentDate && $inputTime < $currentTime) {
                $validator->errors()->add('time', '過去の時刻を選択しないでください');
            }
        });
    }

    public function messages()
    {
        return [
            'date.required' => '日付を選択してください',
            'date.date' => '日付形式で入力してください',
            'date.after_or_equal' => '本日以降の日付を選択してください',
            'time.required' => '時刻を選択してください',
            'time.date_format' => '時刻はHH:MM形式で入力してください',
            'number.required' => '人数を選択してください'
        ];
    }
}
