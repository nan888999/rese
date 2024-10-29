<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckManager
{
    public function handle($request, Closure $next)
    {
      if (!Auth::check()) {
        return redirect('/login')->with('error_message', 'セッションがタイムアウトしました。再度ログインしてください。')
        ->withInput();

      } else {
        $user_role = Auth::user()->role;
        if ($user_role == 1 || $user_role == 2) {
          return $next($request);
        }
          return redirect ('/')->with('error_message', '管理者権限のないアカウントです。管理者アカウントで再ログインしてください。');
      }
    }
}
