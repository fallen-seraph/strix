<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Host;
use App\Http\Requests;

class HostController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    public function hosts(){
        $accountId=Auth::user()->account_id;
        $groups = Group::where('account_id', $accountId)->get();

        foreach($groups as $group){
            $group->members = explode(',', $group->members);
        }

        return view('monitoring.contactgroups', compact('hosts'));
    }
}
