<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminMailRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'subject' => 'required | string | between:2,50 | regex:/^[^#<>^;_]*$/',
            'body' => 'required | string | between:10, 255',
        ];
    }

    public function messages()
    {
        return [
            'subject.required' => '件名を入力してください',
            'subject.string' => '文字列で入力してください',
            'subject.between' => '2字以上50字以下で入力してください',
            'subject.regex' => '特殊記号は使用しないでください',
            'body.required' => '本文を入力してください',
            'body.string' => '文字列で入力してください',
            'body.between' => '10字以上255字以内で入力してください',
        ];
    }
}

