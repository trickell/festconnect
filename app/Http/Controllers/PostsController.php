<?php

namespace App\Http\Controllers;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;

class PostsController extends BaseController
{
    

    public function get_posts()
    {
        $user = \App\Models\Posts::with('user')->hasMany('')->get();
        return json_encode($user);
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

    public function get_comments($id)
    {
        $comments = \App\Models\Posts::find($id)->comments;
        return json_encode($comments);
    }
}