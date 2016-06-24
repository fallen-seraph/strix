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
    }
    public function contact($contact_id){
        $contact=Contacts::where('contact_id', $contact_id)->first();

        return view('monitoring.updates.updateContacts', compact('contact'));
    }
    public function updateContact(Request $request){
        $accountId=Auth::user()->account_id;
        Contacts::where('contact_id', $request->contact_id)->update([
            'contact_name' => $accountId . "_" . $request->alias,
            'alias' => $request->alias,
            'email' => $request->email,
            'phone' => $request->phone,
            'misc' => $request->misc,
        ]);

        return redirect()->action('ContactsController@contacts');
    }
}
