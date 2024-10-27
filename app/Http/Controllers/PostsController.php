<?php

namespace App\Http\Controllers;
use Illuminate\Routing\Controller as BaseController;

class PostsController extends BaseController
{
    public function posts()
    {
        return view('pages.home');
    }

    public function comments()
    {
        return view('pages.missedconn');
    }

    public function reconnections()
    {
        return view('pages.reconnections');
    }
}