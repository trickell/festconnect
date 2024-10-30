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

Route::get('/posts', $C_NAMESPACE . 'PostsController@posts');
Route::post('/submit_post', $C_NAMESPACE . 'PostsController@submit_post');