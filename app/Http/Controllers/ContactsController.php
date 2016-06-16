<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Contacts;
use App\Http\Requests;

class ContactsController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    public function contacts(){
        $contacts = Contacts::where('account_id', Auth::user()->account_id)->lists('alias');
        return view('monitoring.contacts', compact('contacts'));
    }
    public function newContact(Request $request, Contacts $contact){
        $request->request->add(['contact_name' => Auth::user()->account_id . "_" . $request->alias]);

        $this->validate($request, [
            'alias' => 'required|min:3',
            'contact_name' => 'required|unique:nagidb.nagios_contact,contact_name',
            'email' => 'required|email',
        ]);

        $contact->create([
            'account_id' => Auth::user()->account_id,
            'contact_name' => Auth::user()->account_id . "_" . $request->alias,
            'alias' => $request->alias,
            'contact_groups' => $request->contact_groups,
            'email' => $request->email,
            'phone' => $request->phone,
            'misc' => $request->misc,
            'receive' => '1',
        ]);

        return redirect()->action('monitoringController@contacts');
    }
    public function deleteContact($contact){
        if(Contacts::where('account_id', Auth::user()->account_id)->where('contact_name', Auth::user()->account_id . "_" . $contact)->value('contact_name') == $contact){
            Contacts::where('contact_name', $contact)->delete();
        }
        return back();
    }
}
