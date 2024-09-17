<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $user = User::query()->create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password'])
        ]);

        Auth::login($user);

        return redirect('/login');
    }

    public function showLogin()
    {
        return view ('auth.login');
    }

    public function login(Request $request)
    {
        if(empty($request->email) || empty($request->password))
        {
            return back()->with(
                'error_message', 'メールアドレスとパスワードは必須入力です'
            );
        }

        $credentials = $request->only('email', 'password');

        if(Auth::attempt($credentials))
        {
            $request->session()->regenerate();
            return redirect()->intended('/');
        }
        return back()->with(
            'error_message', 'メールアドレスかパスワードが一致しません'
        );
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
