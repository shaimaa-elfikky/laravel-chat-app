<?php

namespace App\Http\Controllers;

use App\Group;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function loadGroup()
    {
    
        $groups = Group::where('created_by', auth()->user()->id)->get();
    
        return view('groups', compact('groups') );
    }


    public function createGroup(Request $request)
    {

      try{
        

        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // 2MB max
            'join_limit' => 'required|integer|min:1',
        ]);

        
        $imageName = null;
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images'), $imageName);
            $imageName = 'images/' . $imageName;
        }
        
            Group::create([
               'created_by'=>auth()->user()->id,
               'name'=>$request->name,
               'image'=>$imageName,
               'join_limit'=>$request->join_limit,

          ]);
             return response()->json(['success'=>true ,'msg'=>$request->name.'Group has been Created Successfully !']);

        }catch(\Exception $e){

            return response()->json(['success'=>false , 'msg'=>$e->getMessage()]);

        }

    }
}
