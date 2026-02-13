<?php

namespace App\Http\Controllers;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends BaseController
{
    public function login()
    {
        $data = request()->except(['_token', '_method']);
        $user = \App\Models\User::where('email', $data['email'])->first();
        // Check to make sure the user exists.
        if (!$user) {
            return json_encode(['status' => 'error', 'message' => 'User does not exist.', 'data' => $data['email']]);
        }
        // Check the passwords
        if (Hash::check($data['password'], $user->password)) {
            // Store the user data for easy access later in a session.
            session(['user' => $user]);
            $user->update(['last_seen_at' => now()]);

            // send user data back and success status request
            return json_encode(['status' => 'success', 'message' => 'Login successful', 'user' => $user]);
        }
        return json_encode(['status' => 'error', 'message' => 'Password Incorrect']);
    }

    public function get_user($id = null)
    {
        // Get the user by the ID
        if ($id) {
            $user = \App\Models\User::find($id);
            return json_encode($user);
        }
        if (!session()->has('user')) {
            return json_encode(['status' => 'error', 'message' => 'User session has expired.']);
        }
        return json_encode(['status' => 'success', 'message' => 'User found', 'user' => session('user')]);
    }

    public function create()
    {
        $data = request()->except(['_token', '_method']);

        if (empty($data['password'])) {
            return json_encode(['status' => 'error', 'message' => 'Password is required']);
        }

        $data['password'] = Hash::make($data['password']);

        try {
            $user = \App\Models\User::create($data);
        } catch (\Exception $e) {
            return json_encode(['status' => 'error', 'message' => 'User creation failed: ' . $e->getMessage(), 'debug_data' => $data]);
        }
        return json_encode(['status' => 'success', 'message' => 'User created successfully', 'user_id' => $user->id]);
    }

    public function logout()
    {
        session()->forget('user');
        return redirect('/');
    }

    public function update_presence()
    {
        if (!session()->has('user')) {
            return json_encode(['status' => 'error', 'message' => 'Unauthorized']);
        }

        $sessionUser = session('user');
        $userId = is_object($sessionUser) ? $sessionUser->getKey() : (is_array($sessionUser) ? $sessionUser['id'] : null);

        if ($userId) {
            \App\Models\User::where('id', $userId)->update(['last_seen_at' => now()]);
        }

        return json_encode(['status' => 'success']);
    }
}