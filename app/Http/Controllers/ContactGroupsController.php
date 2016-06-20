<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Auth;
use App\Group;
use App\Contacts;
use Response;
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
    public function dropdown(){
        $accountId=Auth::user()->account_id;
        $input = Input::get('option');

        $group_contacts = Group::where('account_id', $accountId)->where('alias', $input)->lists('members');
        //$group_contacts=explode(",", $group_contacts);

        $users = Contacts::where('account_id', $accountId)->lists('contact_name');
        //$users=$users->toArray();

        $availableUsers=array_diff(explode(",", $group_contacts), $users->toArray());

        foreach($availableUsers as &$user){$user=str_replace("1_", "", $user);}

        return Response::json($availableUsers);
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
    public function addUser(Request $request){
        $accountId=Auth::user()->account_id;
        $groupName=$accountId . "_" . $request->group;
        $newMember=$accountId . "_" . $request->member;

        $existingMembers=Group::where('account_id', $accountId)->where('group_name', $groupName)->value('members');

        if(strpos($existingMembers, $newMember) !== false){
            return back()->withErrors(['member' => 'Contact is already a part of this group']);
        }

        if($existingMembers) {
            Group::where('account_id', $accountId)->where('group_name', $groupName)->update(['members' => $existingMembers . "," . $newMember]);
        } else {
            Group::where('account_id', $accountId)->where('group_name', $groupName)->update(['members' => $newMember]);
        }

        $existingGroups=Contacts::where('account_id', $accountId)->where('contact_name', $newMember)->value('contact_groups');

        if($existingGroups){
            Contacts::where('account_id', $accountId)->where('contact_name', $newMember)->update(['contact_groups' => $existingGroups . "," . $groupName]);
        }else{
            Contacts::where('account_id', $accountId)->where('contact_name', $newMember)->update(['contact_groups' => $groupName]);
        }

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
}
