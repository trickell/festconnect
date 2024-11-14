<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
$C_NAMESPACE = "App\Http\Controllers\\";

Route::get('/', function () {
    return view('pages.home');
});

Route::get('/missed_connections', function () {
    return view('pages.missedconn');
});

Route::get('/reconnections', function () {
    return view('pages.reconnections');
});

Route::get('/get_posts', $C_NAMESPACE . 'PostsController@get_posts');
Route::get('/get_comments/{postId}', $C_NAMESPACE . 'PostsController@get_comments');

// Post Routes for Post / Comment Submission
Route::post('/submit_post', $C_NAMESPACE . 'PostsController@submit_post');
Route::post('/submit_comment', $C_NAMESPACE . 'PostsController@submit_comment');

Route::get('/create_comment', function(){
    try {
        $user = new \App\Models\Comments();
        $user->post_id = 1;
        $user->user_id = 1;
        $user->comment = 'I know this girl! She was killing it to DailyBread at the main stage. She was wearing a black crop top and jean shorts. She was with a group of friends. I was with my friends and we were all dancing. I was wearing a white t-shirt and black shorts. I was with a group of friends. I would love to meet up with her again. She was so beautiful.';
        $user->created_at = date('Y-m-d H:i:s');
        $user->save();
    }
    catch (\Exception $e) {
        return json_encode(['status' => 'error', 'message' => 'User creation failed', 'error' => $e->getMessage(), 'user_data' => $user]);
    }
});