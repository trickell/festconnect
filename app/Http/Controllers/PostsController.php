<?php

namespace App\Http\Controllers;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;

class PostsController extends BaseController
{
    

    public function posts()
    {
        // Normal DB methods are working. Get working with Eloquent ORM
        // DB::table('user')->insert([
        //     'username' => 'testuser',
        //     'email' => 'test@user.com',
        //     'password' => md5('fconnection123'),
        //     'created_at' => date('Y-m-d H:i:s')
        //     ]);
        
        // Eloquent ORM
        $user = \App\Models\User::all();
        echo $user;

        // return view('pages.home');
    }

    public function submit_post()
    {
        $data = request()->except(['_token', '_method']);

        try {
            $post = \App\Models\Posts::create($data);
        }
        catch (\Exception $e) {
            return json_encode(['status' => 'error', 'message' => 'Post submission failed', 'error' => $e->getMessage(), 'post_data' => $data]);
        }
        return json_encode(['status' => 'success', 'message' => 'Post submitted successfully', 'post_id' => $post->id, 'post_data' => $data]);
    }

    public function reconnections()
    {
        return view('pages.reconnections');
    }
}