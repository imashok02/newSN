<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    public function user()
    {
    	return $this->belongsTo('App\User');
    } 

    public function likes()
    {
    	return $this->morphMany('App\Like', 'likeable');
    }
}
