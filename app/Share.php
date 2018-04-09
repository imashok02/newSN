<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Share extends Model
{
	protected $fillable = ['user_id'];
	
	protected $table = 'shareable';

    public function shareable()
    {
    	return $this->morphTo();
    }

    public function user()
    {
    	return $this->belongsTo('App\User', 'user_id');
    }
}
