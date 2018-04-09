<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Group;
use Auth;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       return view('groups.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $group = new Group;

        $group->name = $request->name;
        $group->user_id = Auth::user()->id;
        $group->description = $request->description;
        $group->visibility = $request->visibility;

        $group->save();

        return "Group Created";
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $group = Group::find($id);

        if(Auth::user()->id === $group->user_id)
            {
                $group->name = $request->name;
                $group->user_id = Auth::user()->id;
                $group->description = $request->description;
                $group->visibility = $request->visibility;

                $group->save();

                return "Group Updated";
            }

        return "Not Authorized to perform this action";
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $group = Group::find($id);

        if(Auth::user()->id === $group->user_id)
            {
               $group->delete();
               return "Group Deleted";
            }

        return "Not Authorized to perform this action";
    }

    public function add_member($groupid, $id)
    {
        $group = Group::find($groupid);

        if($group->user_id === Auth::user()->id)
            {
                $hasJoined = $group->user()->where('user_id', $id)->exists();
                if(!$hasJoined)
                {
                     $group->user()->attach($id);
                    return "Member added successfully";
                }
                return "You already Joined this Group!";
               
            }
            return "No permission to add members to this group!";
    }

    public function remove_member($groupid, $id)
    {
        $group = Group::find($groupid);

        if($group->user_id === Auth::user()->id)
            {
                $checkJoined = $group->user()->where('user_id', $id)->exists();
                if($checkJoined)
                {
                    $group->user()->detach($id);
                    return "Member Removed successfully";
                }
                return "You are not part of this group!";
            }
    }

    public function exit_group($groupid)
    {
        $group = Group::find($groupid);

         $checkJoined = $group->user()->where('user_id', Auth::user()->id)->where('group_id', $groupid)->exists();
         if($checkJoined)
         {
            $group->user()->detach($id);
            return "You have Exited from thr group!";
         }
        return "You are not part of this group!";
    }
}

/**
* 
*/