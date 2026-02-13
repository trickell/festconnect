<?php

namespace App\Http\Controllers;

use App\Models\BetaInvite;
use App\Models\User;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Routing\Controller as BaseController;

use Illuminate\Support\Facades\Mail;
use App\Mail\BetaInviteMail;

class BetaInviteController extends BaseController
{
    public function requestInvite(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $email = $request->email;

        // Check if an inactive code has been sent within 1 hour.
        $existingInvite = BetaInvite::where('email', $email)->first();
        if ($existingInvite) {
            return response()->json([
                'status' => 'duplicate',
                'message' => 'This email address has already been used to request an invite. If you haven\'t received it yet, please check your spam, or use a friend\'s invite code from their profile page!'
            ]);
        }
        // If it's been over an hour, that code can be used.
// "Don't send a inactive code that was sent before 1 hour from the active sent timestamp."
// This means we can reuse a code if it was sent more than 1 hour ago and is NOT active.

        $invite = BetaInvite::where('is_active', false)
            ->where(function ($query) {
                $query->whereNull('sent_at')
                    ->orWhere('sent_at', '<=', now()->subHour());
            })
            ->first();

        if (!$invite) {
            return response()->json([
                'status' => 'error',
                'message' => 'No invite codes available at the moment. Please try again later.'
            ]);
        }

        $invite->update([
            'email' => $email,
            'sent_at' => now()
        ]);

        // Send Actual Email via SendGrid/SMTP
        $registrationUrl = url('/invitecode') . '?code=' . $invite->code;
        try {
            Mail::to($email)->send(new BetaInviteMail($invite->code, $registrationUrl));
            Log::info("Beta Invite sent to {$email} with code: {$invite->code}");
        } catch (\Exception $e) {
            Log::error("Failed to send beta invite to {$email}: " . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to send invite email. Please contact support.'
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Invite code has been sent to your email! Please check your inbox.'
        ]);
    }

    public function showInvitePage()
    {
        return view('pages.invite_register');
    }

    public function verifyCode(Request $request)
    {
        $request->validate([
            'code' => 'required|string'
        ]);

        $invite = BetaInvite::where('code', $request->code)
            ->where('is_active', false)
            ->first();

        if (!$invite) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid or already activated invite code.'
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Code verified.',
            'code' => $invite->code
        ]);
    }

    public function register(Request $request)
    {
        $request->validate([
            'invite_code' => 'required|exists:beta_invites,code',
            'name' => 'required|string|unique:users,name',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $invite = BetaInvite::where('code', $request->invite_code)
            ->where('is_active', false)
            ->first();

        if (!$invite) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invite code is no longer valid.'
            ]);
        }

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'user'
            ]);

            $invite->update([
                'is_active' => true,
                'activated_at' => now(),
                'used_by_user_id' => $user->id
            ]);

            // Generate 5 codes for the new user
            for ($i = 0; $i < 5; $i++) {
                BetaInvite::create([
                    'code' => strtoupper(\Illuminate\Support\Str::random(8)),
                    'user_id' => $user->id,
                    'is_active' => false
                ]);
            }

            // Auto-login or session setup
            session(['user' => $user]);

            return response()->json([
                'status' => 'success',
                'message' => 'Registration successful! Welcome to the beta.',
                'redirect' => url('/')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Registration failed: ' . $e->getMessage()
            ]);
        }
    }

    public function markWelcomeSeen()
    {
        if (!session()->has('user')) {
            return response()->json(['status' => 'error'], 401);
        }
        $user = User::find(session('user')->getKey());
        if ($user) {
            $user->update(['has_seen_welcome' => true]);
            session(['user' => $user]);
        }
        return response()->json(['status' => 'success']);
    }
}