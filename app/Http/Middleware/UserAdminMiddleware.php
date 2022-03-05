<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Helpers\JWTGenerator;
use App\Helpers\ResponseFormatter;
use Exception;

class UserAdminMiddleware
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
        try {
            $token = $request->bearerToken();
            if (!JWTGenerator::validateToken($token)) {
                return ResponseFormatter::error([], 'Un Authorized', 403);
            }

            $payload = JWTGenerator::showPayload($token);

            if ($payload['role'] != 'admin' && $payload['role'] != 'user') {
                return ResponseFormatter::error([], 'Restricted Area', 403);
            }
            $request->attributes->set('payload', $payload);
            return $next($request);
        } catch (Exception $err) {
            return ResponseFormatter::error([], 'Un Authorized', 403);
        }
    }
}
