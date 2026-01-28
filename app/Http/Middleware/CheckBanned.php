<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckBanned
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (session()->has('user')) {
            $user = session('user');

            // Refresh model instance
            if ($user) {
                $user = \App\Models\User::find(is_object($user) ? $user->getKey() : (is_array($user) ? $user['id'] : null));
                if ($user) {
                    session(['user' => $user]); // Update session with latest marks/ban

                    // Check if ban expired
                    if ($user->banned_until && $user->banned_until < now()) {
                        $user->update(['banned_until' => null]);
                        session(['user' => $user]);

                        \App\Models\Notification::create([
                            'user_id' => $user->id,
                            'type' => 'moderation_action',
                            'data' => [
                                'message' => "Your assessment period has ended. Your posting privileges have been RESTORED. Please follow community guidelines.",
                                'status' => 'restored'
                            ]
                        ]);
                    }

                    // If still banned and trying to perform an action
                    if ($user->banned_until && $user->banned_until > now()) {
                        if ($request->isMethod('post') || $request->isMethod('put') || $request->isMethod('patch') || $request->isMethod('delete')) {
                            $remaining = now()->diffForHumans($user->banned_until, true);

                            if ($request->ajax() || $request->wantsJson()) {
                                return response()->json([
                                    'status' => 'error',
                                    'message' => "You are currently BANNED. Restrictions lift in: {$remaining}."
                                ], 403);
                            }

                            return redirect()->back()->with('error', "You are currently BANNED. Restrictions lift in: {$remaining}.");
                        }
                    }
                }
            }
        }

        return $next($request);
    }
}
