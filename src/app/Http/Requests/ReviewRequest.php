<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class ReviewRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
                'rating' => 'required | integer | between:1,5',
                'comment' => 'nullable | string | max:100',
            ];
    }

    public function messages()
    {
        return [
            'rating.required' => '評価は必須項目です',
            'rating.integer' => '評価は整数を指定してください',
            'rating.between' => '評価は1〜
            5の5段階です',
            'comment.string' => '文字列で入力してください',
            'comment.max' => '100字以内で入力してください',
        ];
    }

    /**
     * @Override
     * 勝手にリダイレクトさせない
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     */
    protected function failedValidation(Validator $validator)
    {
    }

    /**
     * バリデータを取得する
     * @return  \Illuminate\Contracts\Validation\Validator  $validator
     */
    public function getValidator()
    {
        return $this->validator;
    }
}
