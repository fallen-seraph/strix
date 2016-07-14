<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Auth;
use App\Group;
use App\Contacts;
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
            if($group->members) {
                $group->members = explode(',', $group->members);
            }
        }

        return view('monitoring.contactgroups', compact('groups'));
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
    public function deleteGroup($deletedGroup){
        $accountId=Auth::user()->account_id;
        $groupName=$accountId . "_" . $deletedGroup;

        $contacts = Contacts::where('account_id', '1')->where('contact_groups', 'like', "%" . $deletedGroup . "%")->select('contact_id', 'contact_groups')->get();

        foreach($contacts as $contact) {
            if(strpos($contact->contact_groups, ",") !== false){
                Contacts::where('account_id', $accountId)
                    ->where('contact_id', $contact->contact_id)
                    ->update([
                        'contact_groups' => str_replace($groupName . ",", "", $contact->contact_groups)
                    ]);
            } else {
                Contacts::where('account_id', $accountId)
                    ->where('contact_id', $contact->contact_id)
                    ->update([
                        'contact_groups' => str_replace($groupName, "", $contact->contact_groups)
                    ]);
            }
        };

        Group::where('group_name', $groupName)->where('account_id', $accountId)->delete();
        return redirect()->action('ContactGroupsController@groups');
    }

    public function addOrRemoveContact(Request $request){
        $accountId=Auth::user()->account_id;
        $contact=Contacts::where('account_id', $accountId)->where('alias', $request->availableMembers)->value('contact_groups');
        $group=Group::where('account_id', $accountId)->where('alias', $request->groupList)->first();

        if(Input::get('add') == 'add') {
            if($group->members) {
                Group::where('account_id', $accountId)
                    ->where('group_id', $request->group_id)
                    ->update([
                        'members' => $group->members . "," . $request->availableMembers,
                    ]);
            } else {
                Group::where('account_id', $accountId)
                    ->where('group_id', $request->group_id)
                    ->update([
                        'members' => $request->availableMembers,
                    ]);
            }

            if($contact){
                Contacts::where('account_id', $accountId)
                    ->where('alias', $request->availableMembers)
                    ->update([
                        'contact_groups' => $contact . "," . $group->group_name
                    ]);
            } else {
                Contacts::where('account_id', $accountId)
                    ->where('alias', $request->availableMembers)
                    ->update([
                        'contact_groups' => $group->group_name
                    ]);
            }
        } elseif(Input::get('remove') == 'remove') {
            if(strpos($group->members, ",") !== false) {
                Group::where('account_id', $accountId)->where('group_id', $request->group_id)->update([
                    'members' => str_replace($request->availableMembers . ",", "", $group->members),
                ]);
            } else {
                Group::where('account_id', $accountId)->where('group_id', $request->group_id)->update([
                    'members' => str_replace($request->availableMembers, "", $group->members),
                ]);
            }
            if(strpos($contact, ",") !== false){
                Contacts::where('account_id', $accountId)->where('alias', $request->availableMembers)->update([
                    'contact_groups' => str_replace($request->groupList . ",", "", $contact),
                ]);
            } else {
                Contacts::where('account_id', $accountId)->where('alias', $request->availableMembers)->update([
                    'contact_groups' => str_replace($request->groupList, "", $contact),
                ]);
            }
        }

        return redirect()->action('ContactGroupsController@groups');
}
}
