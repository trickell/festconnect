<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

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

// Routes to pages
Route::get('/', function () {
    return view('pages.home');
});

Route::get('/missed_connections', function () {
    return view('pages.missedconn');
});

Route::get('/about', function () {
    return view('pages.about');
});

Route::get('/contact', function () {
    return view('pages.contact');
});

Route::get('/reconnections', function (Request $request) {
    if (!$request->session()->has(['user'])) {
        return view('pages.login');
    }
    return view('pages.reconnections');
});

Route::get('/login', function () {
    return view('pages.login');
});
Route::get('/logout', $C_NAMESPACE . 'UserController@logout');

Route::post('/login', $C_NAMESPACE . 'UserController@login');
Route::post('/register', $C_NAMESPACE . 'UserController@create');
Route::post('/update_presence', $C_NAMESPACE . 'UserController@update_presence');

// Routes for retrieving and submitting posts and comments
Route::get('/get_posts', $C_NAMESPACE . 'PostsController@get_posts');
Route::get('/get_comments/{postId}', $C_NAMESPACE . 'PostsController@get_comments');
Route::get('/get_user', $C_NAMESPACE . 'UserController@get_user');

// Post Routes for Post / Comment Submission
Route::post('/submit_post', $C_NAMESPACE . 'PostsController@submit_post');
Route::post('/submit_comment', $C_NAMESPACE . 'PostsController@submit_comment');

// Share Zone and Typing routes
Route::get('/share_zone', function (Request $request) {
    if (!$request->session()->has(['user'])) {
        return view('pages.login');
    }
    return view('pages.sharezone');
});
Route::post('/update_typing', $C_NAMESPACE . 'PostsController@update_typing');
Route::post('/delete_post/{id}', $C_NAMESPACE . 'PostsController@delete_post');
Route::post('/update_post/{id}', $C_NAMESPACE . 'PostsController@update_post');
Route::get('/get_notifications', $C_NAMESPACE . 'PostsController@get_notifications');
Route::post('/mark_notifications_read', $C_NAMESPACE . 'PostsController@mark_notifications_read');
Route::get('/get_typing_status', $C_NAMESPACE . 'PostsController@get_typing_status');

// Profile Routes
Route::get('/profile/{name}', $C_NAMESPACE . 'ProfileController@show');
Route::post('/profile/update', $C_NAMESPACE . 'ProfileController@update');

// Route::get('/create_comment', function(){
//     try {
//         $user = new \App\Models\Comments();
//         $user->post_id = 1;
//         $user->user_id = 1;
//         $user->comment = 'I know this girl! She was killing it to DailyBread at the main stage. She was wearing a black crop top and jean shorts. She was with a group of friends. I was with my friends and we were all dancing. I was wearing a white t-shirt and black shorts. I was with a group of friends. I would love to meet up with her again. She was so beautiful.';
//         $user->created_at = date('Y-m-d H:i:s');
//         $user->save();
//     }
//     catch (\Exception $e) {
//         return json_encode(['status' => 'error', 'message' => 'User creation failed', 'error' => $e->getMessage(), 'user_data' => $user]);
//     }
// });