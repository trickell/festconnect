<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Posts;
use App\Models\Comments;
use App\Models\ModerationFlag;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Hash;

class ModerationController extends BaseController
{
    // --- Moderator Actions ---

    public function flag(Request $request)
    {
        $this->authorizeModerator();

        $data = $request->validate([
            'target_id' => 'required|integer',
            'target_type' => 'required|in:post,user',
            'type' => 'required|in:warning,bad,nudity',
            'reason' => 'required|string',
        ]);

        $data['moderator_id'] = session('user')->getKey();

        try {
            $flag = ModerationFlag::create($data);
            return response()->json(['status' => 'success', 'message' => 'Flag created successfully.']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Failed to create flag.']);
        }
    }

    public function get_moderator_flags()
    {
        $this->authorizeModerator();
        $flags = ModerationFlag::where('moderator_id', session('user')->getKey())
            ->with(['post', 'targetUser'])
            ->orderBy('created_at', 'desc')
            ->get();
        return response()->json($flags);
    }

    // --- Admin Action: User Management ---

    public function get_users(Request $request)
    {
        $this->authorizeAdmin();
        $users = User::orderBy('name', 'asc')->get();
        return response()->json($users);
    }

    public function create_user(Request $request)
    {
        $this->authorizeAdmin();
        $data = $request->validate([
            'name' => 'required|string|unique:users,name',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role' => 'required|in:user,admin,moderator',
        ]);

        $data['password'] = Hash::make($data['password']);
        User::create($data);

        return response()->json(['status' => 'success', 'message' => 'User created successfully.']);
    }

    public function update_user(Request $request, $id)
    {
        $this->authorizeAdmin();
        $user = User::findOrFail($id);

        $data = $request->validate([
            'name' => 'sometimes|string|unique:users,name,' . $id,
            'email' => 'sometimes|email|unique:users,email,' . $id,
            'role' => 'sometimes|in:user,admin,moderator',
            'about_me' => 'sometimes|string|nullable',
            'festivals' => 'sometimes|string|nullable',
        ]);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);
        return response()->json(['status' => 'success', 'message' => 'User updated successfully.']);
    }

    public function delete_user($id)
    {
        $this->authorizeAdmin();
        $user = User::findOrFail($id);

        if ($user->name === 'systemadmin') {
            return response()->json(['status' => 'error', 'message' => 'Cannot delete systemadmin.']);
        }

        $user->delete();
        return response()->json(['status' => 'success', 'message' => 'User deleted.']);
    }

    // --- Admin Action: Flag Management ---

    public function get_all_flags()
    {
        $this->authorizeAdmin();
        $flags = ModerationFlag::with(['moderator', 'admin', 'post', 'targetUser'])
            ->orderBy('created_at', 'desc')
            ->get();
        return response()->json($flags);
    }

    public function resolve_flag(Request $request, $id)
    {
        $this->authorizeAdmin();
        $flag = ModerationFlag::findOrFail($id);

        $data = $request->validate([
            'status' => 'required|in:cleared,warned,removed',
            'admin_comment' => 'required|string',
        ]);

        $data['admin_id'] = session('user')->getKey();
        $flag->update($data);

        // Notify content/user owner
        $targetUserId = null;
        if ($flag->target_type === 'post') {
            $post = Posts::find($flag->target_id);
            $targetUserId = $post ? $post->user_id : null;

            if ($data['status'] === 'removed' && $post) {
                $post->delete();
            }
        } else {
            $targetUserId = $flag->target_id;
        }

        if ($targetUserId) {
            Notification::create([
                'user_id' => $targetUserId,
                'type' => 'moderation_action',
                'data' => [
                    'flag_id' => $flag->id,
                    'status' => $data['status'],
                    'message' => "An admin has reviewed a flag on your account/content: " . $data['admin_comment']
                ]
            ]);
        }

        return response()->json(['status' => 'success', 'message' => 'Flag resolved.']);
    }

    public function toggleRegistration(Request $request)
    {
        $this->authorizeAdmin();
        $request->validate(['enabled' => 'required|boolean']);

        \App\Models\Setting::set('registration_enabled', $request->enabled ? '1' : '0');

        return response()->json(['status' => 'success', 'message' => 'Registration ' . ($request->enabled ? 'enabled' : 'disabled')]);
    }

    public function generateMoreInvites()
    {
        $this->authorizeAdmin();

        for ($i = 0; $i < 10; $i++) {
            \App\Models\BetaInvite::create([
                'code' => strtoupper(\Illuminate\Support\Str::random(10)),
                'is_active' => false,
            ]);
        }

        return response()->json(['status' => 'success', 'message' => '10 more invite codes generated.']);
    }

    // --- Helpers ---

    private function authorizeAdmin()
    {
        if (!session()->has('user') || optional(session('user'))->role !== 'admin') {
            abort(403, 'Admin access required.');
        }
    }

    private function authorizeModerator()
    {
        $role = optional(session('user'))->role;
        if (!session()->has('user') || ($role !== 'moderator' && $role !== 'admin')) {
            abort(403, 'Moderator access required.');
        }
    }
}
