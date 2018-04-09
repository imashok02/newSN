<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;
use App\Post;

class UserController extends Controller
{
    public function feed()
    {
    	$feed = Post::where('user_id', Auth::user()->id)->orWhereIn('user_id', Auth::user()->friends_ids())->get();
    	return $feed;
    }
}
