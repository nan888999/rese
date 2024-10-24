<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Exceptions\HttpResponseException;

class AuthRequest extends FormRequest
{
    protected $redirect = '/login';

    public function authorize()
    {
        return Auth::check();
    }

    protected function failedAuthorization()
    {
        throw new HttpResponseException(
            redirect($this->redirect)->with('error_message', 'ログインが必要です')
        );
    }

    public function rules()
    {
        return [];
    }
}