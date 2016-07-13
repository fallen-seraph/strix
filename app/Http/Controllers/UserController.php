<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Http\Requests;

class UserController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
	$this->middleware('type');
    }
    public function users(){
        $users = User::where('account_id', Auth::user()->account_id)->lists('email');
        return view('monitoring.users', compact('users'));
    }
    public function newUser(Request $request, User $user){
        $this->validate($request, [
            'email' => 'required|email|unique:mysql.users,email',
            'password' => 'required|min:8|confirmed',
        ]);

        $user->create([
            'account_id' => Auth::user()->account_id,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'type' => 'sub'
        ]);

        return redirect()->action('UserController@users');
    }
    public function deleteUsers($user){
        if(Auth::user()->type == 'main'){
            if(User::where('account_id', Auth::user()->account_id)->where('email', $user)->where('type', 'sub')->value('email') == $user){
                User::where('email', $user)->delete();
            }
        }
        return back();
    }
}
