<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Contacts;
use App\Group;
use App\Http\Requests;

class UpdatesController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
        $this->$accountId=Auth::user()->account_id;
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
        //$accountId=Auth::user()->account_id;
        $group=Group::where('account_id', $accountId)->where('alias', $group)->first();
        
        return view('monitoring.updates.updateGroups', compact('group'));
    }
    public function updateGroup(Request $request){
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
}
