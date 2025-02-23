<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class MembersController extends Controller
{


    public function getMembers(Request $request){

        try {
           
            if (!auth()->check()) {
                return response()->json(['success' => false, 'msg' => 'Unauthorized'], 401);
            }
    
          
            $users = User::where('id', '!=', auth()->user()->id)->get();

                return response()->json(['success'=>true ,'data'=>$users]); 
    
            }catch(\Exception $e){
    
                return response()->json(['success'=>false , 'msg'=>$e->getMessage()]);
    
            }
        
    }
}
