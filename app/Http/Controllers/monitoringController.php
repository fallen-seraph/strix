<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

class monitoringController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    public function index(){
        return view('monitoring.home');
    }
    public function users(){
        //$user = User::where();
        return view('monitoring.users');
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
