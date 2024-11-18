<?php

namespace App\Http\Controllers;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Redirect;

class UserController extends BaseController 
{
    public function login(){
        $data = request()->except(['_token', '_method']);
        $user = \App\Models\User::where('email', $data['email'])->first();
        // Check to make sure the user exists.
        if(!$user){ 
            return json_encode(['status' => 'error', 'message' => 'User does not exist.', 'data' => $data['email']]); }
        // Check the passwords
        if (Hash::check($data['password'], $user->password)) {
            // Store the user data for easy access later in a session.
            session(['user' => $user]);

            // send user data back and success status request
            return json_encode(['status' => 'success', 'message' => 'Login successful', 'user' => $user]);
        }
        return json_encode(['status' => 'error', 'message' => 'Password Incorrect']);
    }

    public function get_user($id = null){
        // Get the user by the ID
        if($id){
            $user = \App\Models\User::where('user', $data['email'])->first();
            return json_encode($user);
        }
        if(!session()->has('user')){
            return json_encode(['status' => 'error', 'message' => 'User session has expired.']);
        }
        return json_encode(['status' => 'success', 'message' => 'User found', 'user' => session('user')]);
    }

    public function create(){
        $data = request()->except(['_token', '_method']);

        try{
            $user = \App\Models\User::create($data);
        }
        catch (\Exception $e) {
            return json_encode(['status' => 'error', 'message' => 'User creation failed', 'error' => $e->getMessage(), 'post_data' => $data]);
        }
        return json_encode(['status' => 'success', 'message' => 'User created successfully', 'user_id' => $user->id, 'user_data' => $data]);

    }

    public function logout(){
        if(!session()->has('user')){
            return \Redirect::back();
        }
        session()->forget('user');
        return \Redirect::back();
    }
}