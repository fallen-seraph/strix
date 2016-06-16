<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Group;
use App\Http\Requests;

class ContactGroupsController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    public function groups(){
        $groups = Group::where('account_id', Auth::user()->account_id)->get();
        return view('monitoring.contactgroups', compact('groups'));
    }
    public function newGroup(Request $request, Group $group){
        $account_id=Auth::user()->account_id;
        $groupName=$account_id . "_" . $request->alias;
        $request->request->add(['group_name' => $groupName]);

        $this->validate($request, [
            'alias' => 'required|min:2',
            'group_name' => 'required|unique:nagidb.nagios_contact_group,group_name',
        ]);

        $group->create([
            'account_id' => $account_id,
            'group_name' => $groupName,
            'alias' => $request->alias,
        ]);
    }
    public function addUser(){

    }
    public function deleteGroup(){
    }
}
