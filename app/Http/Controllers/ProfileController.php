<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends BaseController
{
    public function show($name)
    {
        $user = User::where('name', $name)->with('posts')->firstOrFail();

        $isOwner = false;
        $viewer = null;
        if (session()->has('user')) {
            $sessionUser = session('user');
            $sid = is_object($sessionUser) ? $sessionUser->getKey() : (is_array($sessionUser) ? $sessionUser['id'] : null);
            $viewer = User::find($sid);
            if ($viewer) {
                session(['user' => $viewer]);
                $isOwner = $viewer->id === $user->id;
            }
        }

        // Fetch penalties (flags targeted at this user or their posts) - visible to owner or admin
        $penalties = [];
        if ($isOwner || (optional($viewer)->role === 'admin')) {
            $userPostIds = $user->posts->pluck('id')->toArray();

            $penalties = \App\Models\ModerationFlag::where(function ($query) use ($user, $userPostIds) {
                $query->where(function ($q) use ($user) {
                    $q->where('target_id', $user->id)->where('target_type', 'user');
                })->orWhere(function ($q) use ($userPostIds) {
                    $q->whereIn('target_id', $userPostIds)->where('target_type', 'post');
                });
            })
                ->whereIn('status', ['pending', 'warned', 'removed'])
                ->orderBy('created_at', 'desc')
                ->get();
        }

        // Fetch flags created by this user (if moderator/admin)
        $modFlags = [];
        if ($user->role === 'moderator' || $user->role === 'admin') {
            $modFlags = \App\Models\ModerationFlag::where('moderator_id', $user->id)
                ->with(['post', 'targetUser'])
                ->orderBy('created_at', 'desc')
                ->get();
        }

        // Fetch generated invites (and generate them if none exist for the owner)
        $generatedInvites = $user->generatedInvites;
        if ($isOwner && $generatedInvites->isEmpty()) {
            for ($i = 0; $i < 5; $i++) {
                \App\Models\BetaInvite::create([
                    'code' => strtoupper(\Illuminate\Support\Str::random(8)),
                    'user_id' => $user->id,
                    'is_active' => false
                ]);
            }
            \Illuminate\Support\Facades\Log::info("Generated 5 codes for user: {$user->id}");
            $generatedInvites = $user->fresh()->generatedInvites;
        }

        return view('pages.profile', compact('user', 'isOwner', 'penalties', 'modFlags', 'viewer'))
            ->with('generatedInvites', $generatedInvites);
    }

    public function update(Request $request)
    {
        if (!session()->has('user')) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 401);
        }

        $viewer = session('user');
        $userId = $request->input('user_id', $viewer ? $viewer->getKey() : null);

        // If updating someone else, must be admin
        if ($userId != optional($viewer)->getKey() && optional($viewer)->role !== 'admin') {
            return response()->json(['status' => 'error', 'message' => 'Forbidden'], 403);
        }

        $user = User::findOrFail($userId);

        $data = $request->only(['about_me', 'festivals', 'genres']);

        // Handle nested JSON for genres if it comes as a string
        if ($request->has('genres') && is_string($request->genres)) {
            $data['genres'] = json_decode($request->genres, true);
        }

        // Handle password update
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        // Handle Profile Image Upload
        if ($request->hasFile('profile_image')) {
            $file = $request->file('profile_image');
            $filename = time() . '_' . $user->name . '.webp';
            $path = public_path('uploads/profiles/' . $filename);

            if (!file_exists(public_path('uploads/profiles'))) {
                mkdir(public_path('uploads/profiles'), 0777, true);
            }

            if ($this->convertToWebp($file, $path)) {
                // Delete old image if exists
                if ($user->profile_image && file_exists(public_path($user->profile_image))) {
                    unlink(public_path($user->profile_image));
                }
                $data['profile_image'] = 'uploads/profiles/' . $filename;
            }
        }

        try {
            $user->update($data);
            // Refresh session user data
            session(['user' => $user->fresh()]);
            return response()->json(['status' => 'success', 'message' => 'Profile updated successfully', 'user' => $user]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Update failed: ' . $e->getMessage()]);
        }
    }

    private function convertToWebp($file, $path)
    {
        $extension = strtolower($file->getClientOriginalExtension());
        $image = null;

        switch ($extension) {
            case 'jpg':
            case 'jpeg':
                $image = imagecreatefromjpeg($file->getRealPath());
                break;
            case 'png':
                $image = imagecreatefrompng($file->getRealPath());
                if ($image) {
                    imagepalettetotruecolor($image);
                    imagealphablending($image, true);
                    imagesavealpha($image, true);
                }
                break;
            case 'gif':
                $image = imagecreatefromgif($file->getRealPath());
                break;
            case 'webp':
                $image = imagecreatefromwebp($file->getRealPath());
                break;
        }

        if ($image) {
            $result = imagewebp($image, $path, 80);
            imagedestroy($image);
            return $result;
        }

        return false;
    }
}
