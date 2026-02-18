<?php

namespace App\Http\Controllers;

use App\Models\LiveStream;
use App\Models\LiveChatMessage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class LiveStreamController extends Controller
{
    public function getCurrentStream()
    {
        $stream = LiveStream::with(['user', 'messages.user'])
            ->where('status', 'live')
            ->first();

        if (!$stream) {
            $nextStream = LiveStream::with('user')
                ->where('status', 'scheduled')
                ->where('scheduled_at', '>', now())
                ->orderBy('scheduled_at', 'asc')
                ->first();

            return response()->json([
                'status' => 'offline',
                'next_stream' => $nextStream
            ]);
        }

        return response()->json([
            'status' => 'live',
            'stream' => $stream
        ]);
    }

    private function getAuthenticatedUser()
    {
        $sessionUser = session('user');
        if (!$sessionUser)
            return null;

        $id = is_object($sessionUser) ? ($sessionUser->id ?? null) : ($sessionUser['id'] ?? null);
        if (!$id && is_object($sessionUser) && method_exists($sessionUser, 'getKey')) {
            $id = $sessionUser->getKey();
        }

        if (!$id)
            return null;

        // Fetch fresh from DB to ensure correct properties/types
        $user = User::find($id);
        if ($user)
            session(['user' => $user]); // Update session too
        return $user;
    }

    public function getScheduledStreams()
    {
        $user = $this->getAuthenticatedUser();
        if (!$user)
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 403);

        $streams = LiveStream::where('user_id', $user->id)
            ->where('status', '!=', 'ended')
            ->orderBy('scheduled_at', 'asc')
            ->get();

        return response()->json($streams);
    }

    public function scheduleStream(Request $request)
    {
        try {
            $request->validate([
                'scheduled_at' => 'required|date',
            ]);

            $user = $this->getAuthenticatedUser();
            if (!$user || (!$user->is_special_guest && $user->role !== 'admin')) {
                return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 403);
            }

            $requestedTime = Carbon::parse($request->scheduled_at);

            // Check if it's too far in the past (allow 5 min buffer for clock drift/submission time)
            if ($requestedTime->lt(now()->subMinutes(5))) {
                return response()->json(['status' => 'error', 'message' => 'You cannot schedule a stream in the past.'], 422);
            }

            // Check if anyone else is already scheduled for this time (simple check for now)
            $exists = LiveStream::where('status', 'scheduled')
                ->whereBetween('scheduled_at', [
                    $requestedTime->copy()->subMinutes(60),
                    $requestedTime->copy()->addMinutes(60)
                ])->exists();

            if ($exists) {
                return response()->json(['status' => 'error', 'message' => 'This slot is already taken.'], 422);
            }

            $stream = LiveStream::create([
                'user_id' => $user->id,
                'scheduled_at' => $requestedTime,
                'status' => 'scheduled'
            ]);

            return response()->json(['status' => 'success', 'stream' => $stream]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Server error: ' . $e->getMessage()], 500);
        }
    }

    public function startStream($id)
    {
        $stream = LiveStream::findOrFail($id);
        $user = $this->getAuthenticatedUser();
        if (!$user || ($stream->user_id !== $user->id && $user->role !== 'admin')) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 403);
        }

        // Check window: 30 minutes before
        $startWindow = Carbon::parse($stream->scheduled_at)->subMinutes(30);
        if (now()->lt($startWindow)) {
            return response()->json(['status' => 'error', 'message' => 'You can only go live 30 minutes before your scheduled time.'], 422);
        }

        // End any other live streams
        LiveStream::where('status', 'live')->update(['status' => 'ended', 'ended_at' => now()]);

        $stream->update([
            'status' => 'live',
            'started_at' => now()
        ]);

        return response()->json(['status' => 'success', 'stream' => $stream]);
    }

    public function endStream($id)
    {
        $stream = LiveStream::findOrFail($id);
        $user = $this->getAuthenticatedUser();
        if (!$user || ($stream->user_id !== $user->id && $user->role !== 'admin')) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 403);
        }

        $stream->update([
            'status' => 'ended',
            'ended_at' => now()
        ]);

        return response()->json(['status' => 'success']);
    }

    public function postChatMessage(Request $request)
    {
        $request->validate([
            'stream_id' => 'required|exists:live_streams,id',
            'message' => 'required|string|max:500'
        ]);

        $stream = LiveStream::findOrFail($request->stream_id);
        if ($stream->status !== 'live') {
            return response()->json(['status' => 'error', 'message' => 'Stream is not live.'], 422);
        }

        $user = $this->getAuthenticatedUser();
        if (!$user)
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 403);

        $msg = LiveChatMessage::create([
            'stream_id' => $stream->id,
            'user_id' => $user->id,
            'message' => $request->message,
            'color_override' => ($user->id === $stream->user_id) ? $user->stream_chat_color : null
        ]);

        return response()->json(['status' => 'success', 'message' => $msg->load('user')]);
    }

    public function updateChatColor(Request $request)
    {
        $request->validate(['color' => 'required|string|regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/']);

        $user = $this->getAuthenticatedUser();
        if (!$user)
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 403);

        $userModel = User::find($user->id);
        $userModel->update(['stream_chat_color' => $request->color]);

        // Update session user too
        $user->stream_chat_color = $request->color;
        session(['user' => $user]);

        return response()->json(['status' => 'success']);
    }

    public function updatePersonalLinks(Request $request)
    {
        $user = $this->getAuthenticatedUser();
        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 401);
        }

        $request->validate([
            'links' => 'nullable|array|max:3',
            'links.*.name' => 'nullable|string|max:255',
            'links.*.url' => 'required|url|max:500',
        ]);

        $user->update([
            'personal_links' => $request->links ?? []
        ]);

        return response()->json(['status' => 'success']);
    }
}
