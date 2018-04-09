<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Traits\Friendable;
use App\Traits\Extravable;
use App\Post;

class User extends Authenticatable
{
    use Notifiable;
    use Friendable;
    use Extravable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'username',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function profile()
    {
        return $this->hasOne('App\User');
    }


    public function posts()
    {
        return $this->hasMany('App\Post');
    }

    public function pages()
    {
        return $this->hasMany('App\Page');
    }

    public function groups()
    {
        return $this->belongsToMany('App\Group');
    }

    public function created_group()
    {
        return $this->hasMany('App\Group');
    }

    public function likes()
    {
        return $this->hasMany('App\Like');
    }

     public function hasLikedPost(Post $post)
    {
        return (bool) $post->likes->where('user_id', $this->id)->count();
    }

     public function hasLikedPage(Page $page)
    {
        return (bool) $page->likes->where('user_id', $this->id)->count();
    }

    public function shares()
    {
        return $this->hasMany('App\Share', 'user_id');
    }
}
