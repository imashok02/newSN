<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Post extends Model
{
    public function user() {
    	return $this->belongsTo('App\User');
    }

    public function likes()
    {
    	return $this->morphMany('App\Like', 'likeable');
    }

    public function shares()
    {
    	return $this->morphMany('App\Share', 'shareable');
    }
}

