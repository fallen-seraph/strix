<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\User;
use App\account_information;

class monitoringController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    public function index(){
        return view('monitoring.home');
    }
    public function users(){
        $accountId = account_information::where('email', 'Auth::user()->email')->value('account_id');
        $users = User::where('account_id', $accountId)->lists('email');
        dd($users);
        return view('monitoring.users')->with('users', $users);//, compact('users'));
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
