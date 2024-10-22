<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required | string | min:2 | max:50 | regex:/^[^#<>^;_]*$/',
            'password' => 'required | min:8 | max:16 | confirmed',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '名前を入力してください',
            'name.string' => '文字列で入力してください',
            'name.min' => '2字以上50字以内で入力してください',
            'name.max' => '2字以上50字以内で入力してください',
            'name.regex' => '特殊記号は使用しないでください',
            'password.required' => 'パスワードを入力してください',
            'password.min' => '８文字以上１６文字以内で入力してください',
            'password.max' => '8字以上16字以内で入力してください',
            'password.confirmed' => '確認用パスワードと一致しません',
        ];
    }
}

