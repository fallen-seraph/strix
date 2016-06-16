<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\User;
use App\Contacts;
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
            if(User::where('account_id', Auth::user()->account_id)->where('email', $user)->where('type', 'sub')->value('email') == $user){
                User::where('email', $user)->delete();
            }
        }
        return back();
    }
    public function contacts(){
        $contacts = Contacts::where('account_id', Auth::user()->account_id)->lists('alias');
        return view('monitoring.contacts', compact('contacts'));
    }
    public function newContact(Request $request, Contacts $contact){
		$request->add(['contact_name' => Auth::user()->account_id . "_" . $request->alias]);
		
		dd($request);
			
	        $this->validate($request, [
	        	'alias' => 'required|min:3',
	        	'contact_name' => 'required|unique:nagidb.contacts,contact_name',
			'email' => 'required|email',
	        ]);
			
		$contact->create([
	        'account_id' => Auth::user()->account_id,
	        'contact_name' => Auth::user()->account_id . "_" . $request->alias,
	        'alias' => $request->alias,
	        'contact_groups' => $request->contact_groups,
	        'email' => $request->email,
	        'phone' => $request->phone,
	        'misc' => $request->misc,
		'receive' => '1',
	    ]);
        
        return redirect()->action('monitoringController@contacts');
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
