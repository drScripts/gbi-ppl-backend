<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;


class WebMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $user = session('user');
        if (!$user) return redirect("/login");

        if ($user['role'] != 'admin' && $user['role'] != 'superadmin') {
            session(['user' => null]);
            return redirect("/login")->with("warning_form", "Restricted Area!");
        };

        return $next($request);
    }
}
