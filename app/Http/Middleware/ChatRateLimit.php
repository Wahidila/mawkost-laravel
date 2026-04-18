<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Symfony\Component\HttpFoundation\Response;

class ChatRateLimit
{
    /**
     * Handle an incoming request.
     * Limit: 30 messages per hour per IP.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $key = 'chat:' . $request->ip();
        $maxAttempts = 30;
        $decayMinutes = 60;

        if (RateLimiter::tooManyAttempts($key, $maxAttempts)) {
            $retryAfter = RateLimiter::availableIn($key);

            return response()->json([
                'error' => 'Terlalu banyak pesan. Silakan tunggu ' . ceil($retryAfter / 60) . ' menit lagi.',
                'retry_after' => $retryAfter,
            ], 429);
        }

        RateLimiter::hit($key, $decayMinutes * 60);

        return $next($request);
    }
}
