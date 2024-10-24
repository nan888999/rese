<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReviewRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
                'rating' => 'required | integer | min:1 | max:5',
                'comment' => 'string | max:100',
            ];
    }

    public function messages()
    {
        return [
            'rating.required' => '評価は必須項目です',
            'rating.integer' => '評価は整数を指定してください',
            'rating.min' => '評価の最小値は1です',
            'rating.max' => '評価の最大値は5です',
            'comment.string' => '文字列で入力してください',
            'comment.max' => '100字以内で入力してください',
        ];
    }
}
