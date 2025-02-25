<?php

namespace App\Http\Controllers;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class PostsController extends BaseController
{
    
    // Returns all the posts with their respective users
    public function get_posts()
    {
        $user = \App\Models\Posts::with('user')->get();
        return json_encode($user);
    }

    // Returns all the comments for a specific post
    public function get_comments($id)
    {
        $comments = DB::table('comments')
                    ->join('users', 'users.id', '=','comments.user_id')
                    ->select('users.username', 'comments.parent','comments.comment','comments.created_at')
                    ->where('post_id', $id)
                    ->get();

        // $comments = DB::table('comments')->join('users', 'users.id', '=','comments.user_id');

        // $comments = \App\Models\Posts::find($id)->comments;
        return json_encode($comments);
    }

    // Handles the submission of a post
    public function submit_post(Request $request)
    {
        // Merge userid with data
        $userid = $request->session()->only(['user'])['user']->id;
        $request->merge(['user_id' => $userid]);

        $data = request()->except(['_token', '_method']);

        try {
            $post = \App\Models\Posts::create($data);
        }
        catch (\Exception $e) {
            return json_encode(['status' => 'error', 'message' => 'Post submission failed', 'error' => $e->getMessage(), 'post_data' => $data]);
        }
        return json_encode(['status' => 'success', 'message' => 'Post submitted successfully', 'post_id' => $post->id, 'post_data' => $data]);
    }

    // Handles any submission of comments
    public function submit_comment(Request $request)
    {
        // Merge userid with data
        $userid = $request->session()->only(['user'])['user']->id;
        $request->merge(['user_id' => $userid]);

        $data = request()->except(['_token', '_method']);      

        // return $data; 
        try {
            $comment = \App\Models\Comments::create($data);
        }
        catch (\Exception $e) {
            return json_encode(['status' => 'error', 'message' => 'Comment submission failed', 'error' => $e->getMessage(), 'comment_data' => $data]);
        }
        return json_encode(['status' => 'success', 'message' => 'Comment submitted successfully', 'comment_id' => $comment->id, 'user' => 'test', 'comment_data' => $data]);
    }

}