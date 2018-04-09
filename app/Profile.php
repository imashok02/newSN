<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Profile extends Model
{
    protected $fillable = ['user_id'];

    public function user()
    {
    	return $this->belongsTo('App\User');
    }
}
