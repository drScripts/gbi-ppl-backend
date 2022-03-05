<?php

namespace App\Http\Middleware;

use App\Helpers\JWTGenerator;
use App\Helpers\ResponseFormatter;
use Closure;
use Illuminate\Http\Request;

class EnsureSuperadminValidToken
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
        $token = $request->bearerToken();
        if (!JWTGenerator::validateToken($token)) {
            return ResponseFormatter::error([], 'Un Authorized', 403);
        }

        $payload = JWTGenerator::showPayload($token);

        if ($payload['role'] != 'superadmin') {
            return ResponseFormatter::error([], 'Restricted Area', 403);
        }
        $request->attributes->set('payload', $payload);
        return $next($request);
    }
}
