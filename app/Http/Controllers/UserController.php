<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;

class UserController extends Controller
{
    
    public function index(Request $request)
    {
        if(Auth::user()->role_id!==1){
            return redirct('/');
        }
        $user   = User::all();
        return view('users.user',compact('user'));
    }

    public function hapus($id)
    {
        $user = User::find($id);
    	$user->delete();
        return redirect('/user');
    }
}
