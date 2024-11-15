<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FeedbackRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
                'rating' => 'required | integer | between:1,5',
                'comment' => 'nullable | string | max:400',
                'img' => 'file | image | mimes:jpeg,png, jpg | max:1024'
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
            'comment.max' => '400字以内で入力してください',
            'img.file' => '画像ファイルをアップロードしてください。',
            'img.image' => '画像ファイルをアップロードしてください',
            'img.mimes' => '画像形式はJPEG、PNG、JPGのみアップロード可能です',
            'img.max' => '画像のサイズは最大1MBまでです',
        ];
    }
}
