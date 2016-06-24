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
    }
    public function contactGroupDropdown(){
        $accountId=Auth::user()->account_id;
        $input = Input::get('option');

        $group_contacts = Group::where('account_id', $accountId)->where('alias', $input)->lists('members');

        $users = Contacts::where('account_id', $accountId)->lists('contact_name');

        $group_contacts=$group_contacts->toArray();
        $availableUsers=array_diff($users->toArray(), explode(",", $group_contacts[0]));

        foreach($availableUsers as &$user){$user=str_replace("1_", "", $user);}

        return Response::json($availableUsers);
    }
}
