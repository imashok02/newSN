<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Profile;
use Auth;

class ProfileController extends Controller
{
    public function user($id)
    {
    	$user = Profile::where('id', $id)->with('user')->first();
    	return $user;
    }

    public function update_profile(Request $request, $id)
    {
    	$profile = Profile::find($id);

    	if($profile->user_id === Auth::user()->id)
    		{
    			$profile->first_name = $request->first_name;
    			$profile->last_name = $request->last_name;

    			$profile->save();

    			return "Profile Updated!";

    		}

    		abort(403);

    }
}
