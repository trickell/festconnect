<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UpdateUserPresence
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (session()->has('user')) {
            $sessionUser = session('user');
            $userId = is_object($sessionUser) ? $sessionUser->getKey() : (is_array($sessionUser) ? $sessionUser['id'] : null);

            if ($userId) {
                \App\Models\User::where('id', $userId)->update(['last_seen_at' => now()]);
            }
        }

        return $next($request);
    }
}
