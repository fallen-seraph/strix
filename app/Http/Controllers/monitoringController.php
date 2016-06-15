<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\User;
use App\account_information;
use Auth;

class monitoringController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    public function index(){
        return view('monitoring.home');
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

        return redirect()->action('monitoringController@users');
    }
    public function deleteUsers($user){
        if(Auth::user()->type == 'main'){
            if(User::where('account_id', Auth::user()->account_id)->where('email', $user)->value('email') == $user){
                User::where('email', $user)->delete();
            }
        }
        return back();
    }
    public function contacts(){
        return view('monitoring.contacts');
    }
    public function contactgroups(){
        return view('monitoring.contactgroups');
    }
    public function hosts(){
        return view('monitoring.hosts');
    }
    public function settings(){
        return view('monitoring.settings');
    }
    public function detailedOverview(){
        return view('monitoring.detailedoverview');
    }
}
