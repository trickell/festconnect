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
        $user = User::where('name', $name)->firstOrFail();

        $isOwner = false;
        if (session()->has('user')) {
            $isOwner = optional(session('user'))->id === $user->id;
        }

        return view('pages.profile', compact('user', 'isOwner'));
    }

    public function update(Request $request)
    {
        if (!session()->has('user')) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 401);
        }

        $userId = optional(session('user'))->id;
        $user = User::find($userId);

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
