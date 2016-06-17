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
        $accountId=Auth::user()->account_id;
        $groups = Group::where('account_id', $accountId)->get();

        foreach($groups as $group){
            $group->members = explode(',', $group->members);
        }

        $users = \App\Contacts::where('account_id', $accountId)->lists('alias');

        return view('monitoring.contactgroups', compact('groups', 'users'));
    }
    public function newGroup(Request $request, Group $group){
        $account_id=Auth::user()->account_id;
        $groupName=$account_id . "_" . $request->alias;
        $request->request->add(['group_name' => $groupName]);

        $this->validate($request, [
            'group_name' => 'required|unique:nagidb.nagios_contact_group,group_name',
        ]);

        $group->create([
            'account_id' => $account_id,
            'group_name' => $groupName,
            'alias' => $request->alias,
        ]);
        
        return redirect()->action('ContactGroupsController@groups');
    }
    public function addUser(){

    }
    public function deleteGroup($deletedGroup){
        $accountId=Auth::user()->account_id;
        $groupName=$accountId . "_" . $deletedGroup;
        $contacts = \App\Contacts::where('account_id', '1')->where('contact_groups', 'like', "%" . 'alpha' . "%")->list('contact_groups');

        foreach($contacts as $contact_groups)
            \App\Contacts::where('account_id', $accountId)->where('contact_groups', 'like', "%" . $groupName . "%")->update('contact_groups', str_replace($groupName . ",", "", $contact_groups));

        );
            
        Group::where('group_name', $groupName)->where('account_id', $accountId)->delete();
        return back();
    }
}
