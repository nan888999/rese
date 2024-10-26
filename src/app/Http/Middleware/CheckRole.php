<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next)
    {
      if (!Auth::check()) {
        return redirect('/login')->with('error_message', 'セッションがタイムアウトしました。再度ログインしてください。')
        ->withInput();

      } else {
        $user_role = Auth::user()->role;
        if ($user_role == 3) {
            return redirect ('/login')->with('error_message', '管理者権限のないアカウントです。管理者アカウントで再ログインしてください。');
          }
        return $next($request);
      }
    }
}
