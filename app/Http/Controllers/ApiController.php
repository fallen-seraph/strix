<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Auth;
use App\Group;
use Response;
use App\Http\Requests;

class ApiController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
	    $this->middleware('type');
    }
    public function contactGroupButton(){
        $accountId=Auth::user()->account_id;

        $group_id = Group::where('account_id', $accountId)->where('alias', Input::get('group'))->where('members', 'like', "%" . Input::get('contact') . "%")->value('group_id');

        return Response::json($group_id);
    }
}
