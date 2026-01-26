<?php

namespace App\Http\Controllers;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class PostsController extends BaseController
{

    // Returns all the posts with their respective users
    public function get_posts(Request $request)
    {
        $type = $request->query('type', 'missed_connection');
        $festival = $request->query('festival', 'all');
        $usePagination = $request->has('page') || $type === 'share_zone';

        $query = \App\Models\Posts::with('user')
            ->where('post_type', $type);

        if ($festival !== 'all') {
            $query->where('festival', $festival);
        }

        $query->orderBy('created_at', 'desc');

        if ($usePagination) {
            $posts = $query->paginate(10);
        } else {
            $posts = $query->get();
        }

        return response()->json($posts);
    }

    // Returns all the comments for a specific post
    public function get_comments($id)
    {
        $comments = \App\Models\Comments::with('user')
            ->where('post_id', $id)
            ->where('turn_off', false)
            ->orderBy('created_at', 'asc')
            ->get();

        // Transform to match the structure the frontend expects if necessary, 
        // though Eloquent will return a collection that json_encode handles well.
        // We'll flatten the user name for easier consumption.
        $formatted = $comments->map(function ($c) {
            return [
                'id' => $c->id,
                'user_name' => $c->user ? $c->user->name : 'Unknown',
                'parent' => $c->parent,
                'comment' => $c->comment,
                'created_at' => $c->created_at
            ];
        });

        return json_encode($formatted);
    }

    // Handles the submission of a post
    public function submit_post(Request $request)
    {
        // Merge userid with data
        $userid = $request->session()->get('user')->id;
        $request->merge(['user_id' => $userid]);

        $data = request()->except(['_token', '_method']);
        $images = [];

        // Handle Image Upload
        if ($request->hasFile('optConnectImg')) {
            $files = $request->file('optConnectImg');
            if (!is_array($files)) {
                $files = [$files];
            }

            // Limit to 5 images
            $files = array_slice($files, 0, 5);

            foreach ($files as $file) {
                $filename = time() . '_' . uniqid() . '.webp';
                $path = public_path('uploads/' . $filename);

                // Compress and convert to webp using GD
                if ($this->convertToWebp($file, $path)) {
                    $images[] = 'uploads/' . $filename;
                }
            }

            if (!empty($images)) {
                $data['mc_image'] = $images[0]; // For backward compatibility
                $data['images'] = $images;
            }
        }

        try {
            $post = \App\Models\Posts::create($data);
        } catch (\Exception $e) {
            return json_encode(['status' => 'error', 'message' => 'Post submission failed', 'error' => $e->getMessage(), 'post_data' => $data]);
        }
        return json_encode(['status' => 'success', 'message' => 'Post submitted successfully', 'post_id' => $post->id, 'post' => $post->load('user')]);
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

    // Handles post deletion
    public function delete_post($id, Request $request)
    {
        if (!$request->session()->has('user')) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 401);
        }

        $userId = $request->session()->get('user')->id;
        $post = \App\Models\Posts::find($id);

        if (!$post) {
            return response()->json(['status' => 'error', 'message' => 'Post not found'], 404);
        }

        if ($post->user_id !== $userId) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 403);
        }

        try {
            // Delete associated images if they exist
            if ($post->images) {
                foreach ($post->images as $img) {
                    if (file_exists(public_path($img))) {
                        unlink(public_path($img));
                    }
                }
            } elseif ($post->mc_image && file_exists(public_path($post->mc_image))) {
                unlink(public_path($post->mc_image));
            }

            $post->delete();
            return response()->json(['status' => 'success', 'message' => 'Post deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Deletion failed', 'error' => $e->getMessage()]);
        }
    }

    // Update typing status for a user in a room
    public function update_typing(Request $request)
    {
        if (!$request->session()->has('user')) {
            return json_encode(['status' => 'error', 'message' => 'Unauthorized']);
        }

        $userId = $request->session()->get('user')->id;
        $room = $request->input('room', 'share_zone');

        \DB::table('typing_indicators')->updateOrInsert(
            ['user_id' => $userId, 'room' => $room],
            ['last_typed_at' => now(), 'updated_at' => now()]
        );

        return json_encode(['status' => 'success']);
    }

    // Get list of users currently typing in a room
    public function get_typing_status(Request $request)
    {
        $room = $request->query('room', 'share_zone');
        // Users who typed in the last 4 seconds are considered 'typing'
        $typingUsers = \DB::table('typing_indicators')
            ->join('users', 'users.id', '=', 'typing_indicators.user_id')
            ->where('room', $room)
            ->where('last_typed_at', '>=', now()->subSeconds(4))
            ->select('users.name')
            ->get();

        return json_encode($typingUsers);
    }

    // Handles any submission of comments
    public function submit_comment(Request $request)
    {
        // Merge userid with data
        $userid = $request->session()->get('user')->id;
        $request->merge(['user_id' => $userid]);

        $data = request()->except(['_token', '_method']);

        // return $data; 
        try {
            $comment = \App\Models\Comments::create($data);
            $user = \App\Models\User::find($userid); // Fetch user to return name
        } catch (\Exception $e) {
            return json_encode(['status' => 'error', 'message' => 'Comment submission failed', 'error' => $e->getMessage(), 'comment_data' => $data]);
        }
        return json_encode(['status' => 'success', 'message' => 'Comment submitted successfully', 'comment_id' => $comment->id, 'user_name' => $user->name, 'comment_data' => $data]);
    }

}