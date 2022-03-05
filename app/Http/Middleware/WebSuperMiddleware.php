<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class WebSuperMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = session('user');
        if (!$user) return redirect("/login");

        if (!$user && $user['role'] != 'superadmin') {
            session(['user' => null]);
            return redirect("/login")->with("warning_form", "Restricted Area!");
        };

        return $next($request);
    }
}
