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

        $group = Group::where('account_id', $accountId)->where('alias', Input::get('option'))->get();

        $group->members = str_replace($accountId . "_", "", $group->members);
        $group->members = explode(",", $group->members);

        $contacts = Contacts::where('account_id', $accountId)->lists('alias');

        $availableContacts = array_diff($contacts->toArray(), $group->members);

        foreach ($group->members as $member) {
            array_push($availableContacts, $member . "*");
        }
        asort($availableContacts);

        return Response::json($availableContacts);
    }
}
