<?php
namespace App\Traits;

use App\Friendship;

trait Friendable
{
	public function add_friend($requested_to_id)
	{
	
		if($this->id === $requested_to_id)
		{
			return 0;
		}
		if($this->has_pending_friend_requests_to($requested_to_id)=== 1)
		{
			return "Request sent already";
		}
		if($this->has_pending_friend_requests_from($requested_to_id) == 1)
		{
			return $this->accept_friend($requested_to_id);
		}
		if($this->is_friends_with($requested_to_id)=== 1)
		{
			return "Already Friends";
		}
		$friendship = Friendship::create([
			'request_from' => $this->id,
			'requested_to' => $requested_to_id
		]);
		if($friendship)
		{
			return 1;
		}
		return 0;
	}


	public function accept_friend($request_from)
	{
		if($this->has_pending_friend_requests_from($request_from)=== 0)
		{
			return 0;
		}
		$friendship= Friendship::where('request_from', $request_from)->where('requested_to', $this->id)->first();
		if($friendship)
		{
			$friendship->update([
				'status' => 1
				]);
			return 1;
		}
		return 0;
	}


	public function friends()
	{
		$friends1 = array();
			$f1 = Friendship::where('status',1)->where('request_from', $this->id)->get();
			foreach($f1 as $friendship):
				array_push($friends1, \App\User::find($friendship->requested_to));
			endforeach;
		$friends2 = array();
			$f2 = Friendship::where('status',1)->where('requested_to', $this->id)->get();
			foreach($f2 as $friendship):
				array_push($friends2, \App\User::find($friendship->request_from));
			endforeach;
		return array_merge($friends1, $friends2);
	}


	public function pending_friend_requests()
	{
		$users = array();
		$friendships = Friendship::where('status',0)->where('requested_to',$this->id)->get();
		foreach($friendships as $friendship):
			array_push($users,\App\User::find($friendship->request_from));
		endforeach;
		return $users;
	}


	public function friends_ids()
	{
		return collect($this->friends())->pluck('id')->toArray();
	}


	public function is_friends_with($user_id)
	{
		if(in_array($user_id, $this->friends_ids()))
		{
			return 1;
		}
		else
		{
			return 0;
			
		}
	}


	public function pending_friend_request_ids()
	{
		return collect($this->pending_friend_requests())->pluck('id')->toArray();
	}


	public function pending_friend_requests_sent()
	{
		$users = array();
		$friendships = Friendship::where('status', 0)->where('request_from',$this->id)->get();
		foreach($friendships as $friendship):
			array_push($users, \App\User::find($friendship->requested_to));
		endforeach;
		return $users;
	}


	public function pending_friend_request_sent_ids()
	{
		return collect($this->pending_friend_requests_sent())->pluck('id')->toArray();
	}


	public function has_pending_friend_requests_from($user_id)
	{
		if(in_array($user_id, $this->pending_friend_request_ids()))
		{
			return 1;
		}
		else
		{
			return 0;
		}
	}


	public function has_pending_friend_requests_to($user_id)
	{
		if(in_array($user_id, $this->pending_friend_request_sent_ids()))
		{
			return 1;
		}
		else
		{
			return 0;
		}
	}
}
