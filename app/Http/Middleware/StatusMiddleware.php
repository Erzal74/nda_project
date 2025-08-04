<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StatusMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check() || Auth::user()->status !== 'approved') {
            Auth::logout();
            return redirect('/login')->with('error', 'Akun Anda belum disetujui.');
        }
        return $next($request);
    }
}
