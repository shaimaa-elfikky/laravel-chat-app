<?php

namespace App\Http\Controllers;

use App\User;
use App\Message;
use Illuminate\Http\Request;
use App\Events\MessageEvent;

class UserController extends Controller
{
    public function loadDashboard()
    {

        $users = User::whereNotIn('id', [auth()->user()->id])->get();

        return view('home', compact('users'));
    }

    public function saveMessage(Request $request){

        try{

            $message = Message::create([

                'sender_id' => $request->sender_id,
                'receiver_id' => $request->receiver_id,
                'message'     =>$request->message

            ]);

              event(new MessageEvent($message));

            return response()->json(['success'=>true , 'data'=>$message ]);

        }catch(\Exception $e){

            return response()->json(['success'=>false , 'msg'=>$e->getMessage()]);

        }

    }
}
