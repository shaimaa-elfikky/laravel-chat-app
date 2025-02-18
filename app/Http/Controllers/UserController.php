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



    public function loadMessages(Request $request){

        try{

            $messages = Message::where(function ($query) use ($request) {
                $query->where('sender_id', $request->sender_id)
                      ->where('receiver_id', $request->receiver_id);
            })->orWhere(function ($query) use ($request) {
                $query->where('sender_id', $request->receiver_id)
                      ->where('receiver_id', $request->sender_id);
            })->get();

            return response()->json(['success'=>true , 'data'=> $messages  ]);

        }catch(\Exception $e){

            return response()->json(['success'=>false , 'msg'=>$e->getMessage()]);

        }

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
