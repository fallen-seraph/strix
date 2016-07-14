<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Auth;
use App\Group;
use App\Contacts;
use Response;
use App\Http\Requests;

class ApiController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
	$this->middleware('type');
    }
    public function contactGroupDropdown(){
        $accountId=Auth::user()->account_id;

        $group = Group::where('account_id', $accountId)->where('alias', Input::get('option'))->first();

        $group->members = str_replace($accountId . "_", "", $group->members);
        $group->members = explode(",", $group->members);

        return Response::json($group->members);
    }
    public function contactGroupButton(){
        $accountId=Auth::user()->account_id;

        $group = Group::where('account_id', $accountId)->where('alias', Input::get('group'))->where('members', 'like', "%" . Input::get('contact') . "%")->first();
    }
}
