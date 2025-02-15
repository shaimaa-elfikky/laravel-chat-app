<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function loadDashboard()
    {
       
        $users = User::whereNotIn('id', [auth()->user()->id])->get();
        return view('home', compact('users'));
    }
}
