<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Carbon\Carbon;

class UpdateReservationRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $tomorrow = Carbon::tomorrow()->format('Y-m-d');

        return [
            'date' => 'required | date | after_or_equal:'. $tomorrow,
            'time' => 'required | date_format:H:i',
            'number' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'date.required' => '日付を選択してください',
            'date.date' => '日付形式で入力してください',
            'date.after_or_equal' => '明日以降の日付を選択してください',
            'time.required' => '時刻を選択してください',
            'time.date_format' => '時刻はHH:MM形式で入力してください',
            'number.required' => '人数を選択してください'
        ];
    }

}
