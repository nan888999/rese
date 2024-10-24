<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthRequest extends FormRequest
{
    public function authorize()
    {
        return Auth::check();
    }

    protected function failedAuthorization()
    {
        throw ValidationException::withMessages([])->redirectTo('/login')->with('error_message', 'ログインが必要です');
    }

    public function rules()
    {
        return [];
    }
}
