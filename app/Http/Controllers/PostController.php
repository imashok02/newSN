<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use Auth;
use Storage;
use App\Like;

class PostController extends Controller
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
        $post = new Post;

        $post->text= $request->text;
        $post->user_id = Auth::user()->id;
       /**
        if($request->hasFile('image'))
        {
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $location = public_path('media/' . $filename);
            $uploaded = Storage::disk('local')->put($location, file_get_contents($image->getRealPath()));


            $post->image = $filename;
        };

        if($request->hasFile('video'))
        {
            $video = $request->file('video');
            $filename = time() . '.' . $video->getClientOriginalExtension();
            $location = public_path('media/' . $filename);
            $uploaded = Storage::disk('local')->put($location, file_get_contents($image->getRealPath()));


            $post->video = $filename;
        };

        **/

        $post->save();
        echo "saved";
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
        $post = Post::find($id);

        $post->text= $request->text;
        $post->user_id = Auth::user()->id;
        if($request->hasFile('image'))
        {
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $location = public_path('media/' . $filename);
            $uploaded = Storage::disk('local')->put($location, file_get_contents($image->getRealPath()));


            $post->image = $filename;
        };

        if($request->hasFile('video'))
        {
            $video = $request->file('video');
            $filename = time() . '.' . $video->getClientOriginalExtension();
            $location = public_path('media/' . $filename);
            $uploaded = Storage::disk('local')->put($location, file_get_contents($image->getRealPath()));


            $post->video = $filename;
        };

        $post->save();
        echo "saved";
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function like($postId)
    {
        $post = Post::find($postId);
        if(!$post)
        {
            return "NOt a valid post to like";
        }

        // if(!Auth::user()->is_friends_with($post->user->id))
        // {
        //     return "Not friends so cant like his/her post";
        // }

        if(Auth::user()->hasLikedPost($post))
        {
            return "Already liked";
        }

        $like = $post->likes()->create([
            'user_id' => Auth::user()->id
        ]);
        

        Auth::user()->likes()->save($like);

        return "Like Added";
    }

    public function unlike($postId)
    {
        $post = Post::find($postId);
        if(!$post)
        {
            return "NOt a valid post to like";
        }

        // if(!Auth::user()->is_friends_with($post->user->id))
        // {
        //     return "Not friends so cant like his/her post";
        // }

        if(Auth::user()->hasLikedPost($post))
        {
            $like = Like::where('user_id' , Auth::user()->id)->where('likeable_id' , $post->id)->first();
            $like->delete();

            return "Like removed";
        }

        return "Not allowed!";

        
    }

    public function share($postId)
    {
        $post = Post::find($postId);
        if(!$post)
        {
            return "NOt a valid post to share";
        }

        $like = $post->shares()->create([
            'user_id' => Auth::user()->id
        ]);
        

        Auth::user()->shares()->save($like);

        return "Shared";
    }

    
}
