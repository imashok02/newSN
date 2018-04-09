<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class FriendshipController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
	}
	
    public function add_request($to) 
    {
    	$request = Auth::user()->add_friend((int) $to);
    	return $request;
    }

    public function accept_request($for)
    {
    	$request = Auth::user()->accept_friend((int) $for);
    	return $request;
    }

    public function pending_requests()
    {
    	$request = Auth::user()->pending_friend_requests();
    	return $request;
    }

    public function friend_list()
    {
    	$request = Auth::user()->friends();
    	return $request;
    }

    public function pending_friend_requests_sent()
	{
		$request = Auth::user()->pending_friend_requests_sent();
    	return $request;
	}

    public function check($id)
    {
        if(Auth::user()->is_friends_with($id))
            {
                return ['status' => 'Already Friends'];
            }
        if(Auth::user()->has_pending_friend_requests_from($id))
            {
                return ['status' => 'His Request is Pending'];
            }
        if(Auth::user()->has_pending_friend_requests_to($id))
            {
                return ['status' => 'Your Request is Pending'];
            }

        return ['status' => 0];
    }
}
