<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckSession
{
    public function handle($request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect('/login')->with('error_message', 'セッションがタイムアウトしました。再度ログインしてください。')
            ->withInput();
        }

        return $next($request);
    }
}
