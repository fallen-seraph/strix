<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class ContactGroupsController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    public function contactgroups(){
        return view('monitoring.contactgroups');
    }
    public function newGroup(){
    }
    public function deleteGroup(){
    }
}
