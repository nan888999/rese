<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class EditShopRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
                'name' => 'nullable | string | between:2,20 | regex:/^[^#<>^;_]*$/',
                'area_id' => 'nullable | integer | regex:/^[0-9]$/',
                'category_id' => 'nullable | integer | regex:/^[0-9]$/',
                'detail' => 'nullable | string | max:200',
                'img_url' => 'nullable | string | max:255 | active_url',
            ];
    }

    public function messages()
    {
        return [
            'name.string' => '文字列で入力してください',
            'name.between' => '2字以上20字以下で入力してください',
            'name.regex' => '特殊記号は使用しないでください',
            'area_id.integer' => 'エリアIDは整数を指定してください',
            'area_id.regex' => 'エリアIDは1桁の整数を指定してください',
            'category_id.integer' => 'エリアIDは整数を指定してください',
            'category_id.regex' => 'エリアIDは1桁の整数を指定してください',
            'detail.string' => '文字列で入力してください',
            'detail.max' => '200字以内で入力してください',
            'img_url.string' => '文字列で入力してください',
            'img_url.max' => '255字以内で入力してください',
            'img_url.active_url' => 'アクセス可能なURLを入力してください'
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
