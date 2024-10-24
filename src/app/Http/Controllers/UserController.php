<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailVerification;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Requests\MailRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UserController extends Controller
{
    public function viewRegister(Request $request)
    {
        $user_id = $request->query('id');
        return view('auth.register', compact('user_id'));
    }

    // ユーザー登録処理
    public function register(UserRequest $request) {
        $user_id = $request->input('user_id');
        $user = User::find($user_id);
        // ユーザーが見つからない場合の処理
        if (!$user) {
            return redirect('/verify_email')->with('error_message', 'メールアドレスを認証してください');
        }

        $user->update([
            'name' => $request->input('name'),
            'password' => Hash::make($request->input('password')),
            'role' => 3,
            'email_verified' => 1,
        ]);

        Auth::login($user);

        return view('auth.thanks');
    }

    public function viewLogin()
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
        return redirect('/login')->with('message', 'ログアウトしました');
    }

    // メール認証ページの表示
    public function viewVerifyEmail()
    {
        return view ('auth.emails.email_verify');
    }

    // メール認証処理
    public function verifyEmail(MailRequest $request)
    {
        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'email_verify_token' => base64_encode($request['email']),
        ]);
        // メール確認リンクの生成
        $verification_url = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $user->id, 'hash' => sha1($user->email)]
        );
        // 認証メールの送信
        Mail::to($user->email)->send(new EmailVerification($user, $verification_url));

        return view ('auth.emails.verified', compact('verification_url'));
    }

    // 認証メール内リンククリック時の処理
    public function emailVerified (Request $request, $id, $hash)
    {
        $user = User::find($id);
        // ユーザーが見つからない場合
        if (!$user) {
            return redirect('/verify_email')->with('error_message', 'ユーザーが見つかりません');
        }
        // hashの確認
        if (sha1($user->email) !== $hash) {
            return redirect ('/verify_email')->with('error_message', 'リンクが正しくありません');
        }
        // メール確認のマーク
        if(!$user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
        }
        return redirect()->route('viewRegister', ['id'=> $id]);
    }
}
