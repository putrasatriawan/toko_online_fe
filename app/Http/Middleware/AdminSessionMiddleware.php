<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class AdminSessionMiddleware
{
    public function handle($request, Closure $next)
    {
        // Cek role di session
        if (!Session::has('jwt_token') || Session::get('user_role') !== 'admin') {
            return redirect('/login')->with('error', 'Akses khusus admin');
        }

        return $next($request);
    }
}
