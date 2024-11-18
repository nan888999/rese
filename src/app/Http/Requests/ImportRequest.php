<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImportRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'file' => 'required|file|mimes:csv,txt|max:102400'
        ];
    }

    public function messages()
    {
        return [
            'file.required' => 'CSVファイルをアップロードしてください',
            'file.file' => 'CSVファイルをアップロードしてください',
            'file.mimes' => 'CSVファイルを選択してください',
            'file.max' => 'ファイルサイズは100MB以内にしてください',
        ];
    }
}
