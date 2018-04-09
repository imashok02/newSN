<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Conversation;
use App\Message;

class MessageController extends Controller
{

	public function __construct()
	{
		$this->middleware('auth');
	}
	//rendering view for sending message
	public function msg()
	{
		return view('message.create');
	}

	//sending meassage function
    public function send(Request $request)
    {
    	$message = new Message;
    
    	$check = Conversation::where('user_one', Auth::user()->id)->Where('user_two',$request->to)->first();
    	$check2 = Conversation::where('user_one', $request->to)->Where('user_two',Auth::user()->id)->first();
    	if($check || $check2 )
    	{
    		if($check)
    		{
    			$message->from = Auth::user()->id;
				$message->to = $request->to;
				$message->conversation_id = $check->id;
				$message->message = $request->message;

				$message->save();

				return "success";
    		}
    			$message->from = Auth::user()->id;
				$message->to = $request->to;
				$message->conversation_id = $check2->id;
				$message->message = $request->message;

				$message->save();
				return "Message Sent";
    	}

		$conversation= Conversation::create([
    		'user_one' => Auth::user()->id,
    		'user_two' => $request->to
    	]);

		$message->from = Auth::user()->id;
		$message->to = $request->to;
		$message->conversation_id = $conversation->id;
		$message->message = $request->message;

		$message->save();

		return "new Conversation Started!";
    }

    //Finding the conversation with the user.
    public function getConvo($id)
    {
    	$conversation = Conversation::find($id);

    	if($this->permit($id) == 1)
    	{
    		return $conversation->messages()->orderby('id','desc')->get();
    	}
    	return abort(403);
    }

 //Finding the conversation for the authorized user.
    public function permit($id)
    {
    	$check = Conversation::where('id', $id)->where('user_one', Auth::user()->id)->orWhere('user_two',Auth::user()->id)->first();
    	if($check)
    	{
    		return 1;
    	}
    	return 0;
    }

//grabbing all the conversation ids of the authenticated user.
    public function conversation_ids()
    {
    	$convo1 = [];

    	$check1 = Conversation::where('user_one', Auth::user()->id)->get();

    	foreach($check1 as $conversation):
				array_push($convo1, \App\Conversation::find($conversation->id));
		endforeach;

		$convo2 = [];

    	$check2 = Conversation::where('user_two',Auth::user()->id)->get();

    	foreach($check2 as $conversation):
				array_push($convo2, \App\Conversation::find($conversation->id));
		endforeach;

		return array_merge($convo1, $convo2);
    }

    public function check_read($conversation_id, $messageId)
    {
    	$check = Message::find($messageId);
    	dd($check);
    }
}