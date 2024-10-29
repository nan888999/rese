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
            'name' => 'required | string | between:2,50 | regex:/^[^#<>^;_]*$/',
            'password' => 'required | between:8,16 | string | confirmed',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '名前を入力してください',
            'name.string' => '文字列で入力してください',
            'name.between' => '2字以上50字以下で入力してください',
            'name.regex' => '特殊記号は使用しないでください',
            'password.required' => 'パスワードを入力してください',
            'password.between' => '8字以上16字以内で入力してください',
            'password.string' => '文字列で入力してください',
            'password.confirmed' => '確認用パスワードと一致しません',
        ];
    }
}

