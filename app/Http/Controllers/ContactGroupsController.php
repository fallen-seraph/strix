<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
            $group->members = explode(',', $group->members);
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
    public function renameGroup(){

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
        $group=Group::where('account_id', $accountId)->where('group_id', $request->group_id)->first();

        if(Input::get('nameChange') == 'nameChange'){
            Group::where('account_id', $accountId)
                ->where('group_id', $request->group_id)
                ->update([
                    'group_name' => $accountId . "_" . $request->alias,
                    'alias' => $request->alias,
                ]);

        } elseif(Input::get('add') == 'add') {
            $contact=Contacts::where('account_id', $accountId)->where('alias', $request->availableMembers)->value('contact_groups');
            $group=Group::where('account_id', $accountId)->where('alias', $group)->first();

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
            $removedContact=str_replace("*", "", $request->availableMembers);
            $contact=Contacts::where('account_id', $accountId)->where('alias', $request->availableMembers)->value('contact_groups');

            if(str_pos(",", $group->members) !== false) {
                Group::where('account_id', $accountId)->where('group_id', $request->group_id)->update([
                    'members' => str_replace($removedContact . ",", "", $group->members),
                ]);
            } else {
                Group::where('account_id', $accountId)->where('group_id', $request->group_id)->update([
                    'members' => str_replace($removedContact, "", $group->members),
                ]);
            }
            if(str_pos(",", $contact) !== false){
                Contacts::where('account_id', $accountId)->where('alias', $request->availableMembers)->update([
                    'contact_groups' => str_replace($group->group_name . ",", "", $contact),
                ]);
            } else {
                Contacts::where('account_id', $accountId)->where('alias', $request->availableMembers)->update([
                    'contact_groups' => str_replace($group->group_name, "", $contact),
                ]);
            }
        }

        return redirect()->action('ContactGroupsController@groups');
}
}
