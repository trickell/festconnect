<?php

namespace App\Http\Controllers;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;

class UserController extends BaseController 
{
    public function login(){
        $data = request()->except(['_token', '_method']);
        $user = \App\Models\User::where('email', $data['email'])->first();
        if ($user && password_verify(md5($data['password']), $user->password)) {
            // Store the user data for easy access later in a session.
            session(['user' => $user]);

            // send user data back and success status request
            return json_encode(['status' => 'success', 'message' => 'Login successful', 'user' => $user]);
        }
        return json_encode(['status' => 'error', 'message' => 'Login failed']);
    }

    public function getUser(){
        if(!session()->has('user')){
            return json_encode(['status' => 'error', 'message' => 'User session has expired.']);
        }
        return json_encode(['status' => 'success', 'message' => 'User found', 'user' => session('user')]);
    }

    public function logout(){
        if(!session()->has('user')){
            return json_encode(['status' => 'error', 'message' => 'User session has expired.']);
        }
        session()->forget('user');
        return json_encode(['status' => 'success', 'message' => 'User logged out']);
    }
}