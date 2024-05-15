<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\User;

class MessageController extends Controller
{
    public function sendmessage(Request $request)
    {
        $userId = auth()->user()->id;
        $toUserId = $request->to_user_id;
        $message = $request->message;
        $message = new Message();
        $message->from_user_id = $userId;
        $message->to_user_id = $toUserId;
        $message->body = $message;
        $message->save();
        return redirect()->back();
    }

    public function getmessages()
    {
        $userId = auth()->user()->id;
        $messages = Message::where('to_user_id', $userId)->orderBy('created_at', 'desc')->paginate(100);
        return view('userprofile/message', ['messages' => $messages]);
    }
}
