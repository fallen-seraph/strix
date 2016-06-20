<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Host;
use App\Http\Requests;

class HostController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    public function hosts(){
        $accountId=Auth::user()->account_id;
        $hosts=Host::where('account_id', $accountId)->lists('host_name');

        return view('monitoring.hosts', compact('hosts'));
    }
}
