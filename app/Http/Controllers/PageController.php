<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Page;
use Auth;
use App\Like;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $page = new Page;
        $page->name = $request->name;
        $page->user_id = Auth::user()->id;
        $page->location = $request->location;
        $page->description = $request->description;
        $page->save();

        return "New Page Created!";
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
        $page = Page::find($id);


        if($page->user_id === Auth::user()->id) {
            $page->name = $request->name;
            $page->user_id = Auth::user()->id;
            $page->location = $request->location;
            $page->description = $request->description;
            $page->save();

            return "Page Updated!";
        }

        return "Not authorized to perform this change";
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $page = Page::find($id);


        if($page->user_id === Auth::user()->id) {
            $page->delete();

            return "Page Deleted!";
        }

        return "Not authorized to perform this change";
    }

    public function like($pageId)
    {
        $page = Page::find($pageId);
        if(!$page)
        {
            return "Not a valid page to like";
        }

        // if(!Auth::user()->is_friends_with($post->user->id))
        // {
        //     return "Not friends so cant like his/her post";
        // }

        if(Auth::user()->hasLikedPage($page))
        {
            return "Already liked";
        }

        $like = $page->likes()->create([
            'user_id' => Auth::user()->id
        ]);
        

        Auth::user()->likes()->save($like);

        return "Like Added";
    }

    public function unlike($pageId)
    {
        $page = Page::find($pageId);
        if(!$page)
        {
            return "NOt a valid page to like";
        }

        // if(!Auth::user()->is_friends_with($post->user->id))
        // {
        //     return "Not friends so cant like his/her post";
        // }

        if(Auth::user()->hasLikedPage($page))
        {
            $like = Like::where('user_id' , Auth::user()->id)->where('likeable_id' , $page->id)->first();
            $like->delete();

            return "Like removed";
        }

        return "Not allowed!";

        
    }

    public function share($pageId)
    {
        $page = Page::find($pageId);
        if(!$page)
        {
            return "Not a valid page to like";
        }

        $share = $page->shares()->create([
            'user_id' => Auth::user()->id
        ]);
        

        Auth::user()->shares()->save($share);

        return "Shared";
    }

    public function test()
    {
        return Auth::user()->pages_likes_list();
    }
}