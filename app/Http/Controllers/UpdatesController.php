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
    public function groupName($alias){
        $group_id=Group::where('account_id', Auth::user()->account_id)->where('alias', $alias)->value('group_id');
        return view('monitoring.updates.updateGroups', compact('alias', 'group_id'));
    }
    public function renameGroup(Request $request){
        $accountId=Auth::user()->account_id;
        $oldName=Group::where('account_id', $accountId)->where('group_id', $request->group_id)->value('alias');

        Group::where('account_id', $accountId)->where('group_id', $request->group_id)->update([
            'alias' => $request->alias,
            'group_name' => $accountId . "_" . $request->alias,
        ]);

        $contact=Contacts::where('account_id', $accountId)->where('contact_groups', 'like', "%" . $oldName . "%")->select('contact_groups', 'contact_id')->first();

        Contacts::where('contact_id', $contact->contact_id)->update([
           'contact_groups' => str_replace($oldName, $request->alias, $contact->contact_groups),
        ]);

    }
}
