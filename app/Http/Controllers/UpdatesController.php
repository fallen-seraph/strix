<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Auth;
use App\Contacts;
use App\Group;
use App\Http\Requests;

class UpdatesController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    public function contact($alias){
        $accountId=Auth::user()->account_id;
        $contact=Contacts::where('account_id', $accountId)->where('alias', $alias)->first();

        return view('monitoring.updates.updateContacts', compact('contact'));
    }
    public function updateContact(Request $request){
        $accountId=Auth::user()->account_id;
        Contacts::where('account_id', $accountId)->where('contact_id', $request->contact_id)->update([
            'contact_name' => $accountId . "_" . $request->alias,
            'alias' => $request->alias,
            'email' => $request->email,
            'phone' => $request->phone,
            'misc' => $request->misc,
        ]);

        return redirect()->action('ContactsController@contacts');
    }
    public function group($group){
        $accountId=Auth::user()->account_id;
        $group=Group::where('account_id', $accountId)->where('alias', $group)->first();
        
        $group->members=str_replace($accountId . "_", "", $group->members);
        $group->members=explode(",", $group->members);
        
        $contacts=Contacts::where('account_id', $accountId)->lists('alias');
        
        $availableContacts=array_diff($contacts->toArray(), $group->members);
        
        foreach($group->members as $member){
            array_push($availableContacts, $member . "*");
        }
        asort($availableContacts);
        
        return view('monitoring.updates.updateGroups', compact('group', 'availableContacts'));
    }
    public function updateGroup(Request $request){
        $accountId=Auth::user()->account_id;

        if(Input::get('nameChange')){

            Group::where('account_id', $accountId)
                ->where('group_id', $request->group_id)
                ->update([
                    'group_name' => $accountId . "_" . $request->alias,
                    'alias' => $request->alias,
                ]);

        } elseif(Input::get('add')) {
            $group=Group::where('account_id', $accountId)->where('group_id', $request->group_id)->first();
            $contact=Contacts::where('account_id', $accountId)->where('alias', $request->availableMembers)->value('contact_groups');

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

        } elseif(Input::get('remove')) {
            $removedContact=str_replace("*", "", $request->availableMembers);
            $group=Group::where('account_id', $accountId)->where('group_id', $request->group_id)->first();
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
        return redirect()->action('UpdateController@group', [$group->alias]);
    }
}
