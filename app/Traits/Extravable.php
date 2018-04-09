<?php

namespace App\Traits;

use App\Like;

trait Extravable {

	public function pages_likes_list()
	{
		return Like::where('user_id', $this->id)->where('likeable_type', 'App\Post')->get();
	}
	
}