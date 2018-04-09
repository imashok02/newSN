<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Profile;
use DB;

class SearchController extends Controller
{
    public function user_search(Request $request)
    {
    	$q = $_GET['query'];
    	$profile = Profile::where(DB::raw("CONCAT('first_name','',last_name)"),'like', '%' . $q . '%')->with('user')->get();
   		return ($profile);

    }
}
