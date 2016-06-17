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
        $contacts = Contacts::where('account_id', Auth::user()->account_id)->get();
        foreach($contacts as $contact){
            $contact->contact_groups=str_replace(",", ", ", $contact->contact_groups);
        }

        return view('monitoring.contacts', compact('contacts'));
    }
    public function newContact(Request $request, Contacts $contact){
        $account_id=Auth::user()->account_id;
        $contactName=$account_id . "_" . $request->alias;
        $request->request->add(['contact_name' => $contactName]);

        $this->validate($request, [
            'alias' => 'required|min:2',
            'email' => 'required|email',
            'contact_name' => 'required|unique:nagidb.nagios_contact,contact_name',
        ]);

        $contact->create([
            'account_id' => $account_id,
            'contact_name' => $contactName,
            'alias' => $request->alias,
            'contact_groups' => $request->contact_groups,
            'email' => $request->email,
            'phone' => $request->phone,
            'misc' => $request->misc,
            'receive' => '1',
        ]);

        return redirect()->action('ContactsController@contacts');
    }
    public function deleteContact($contact){
        $accountId=Auth::user()->account_id;
        $contactName=$accountId . "_" . $contact;
        if(Contacts::where('account_id', $accountId)->where('contact_name', $contactName)->value('contact_name') == $contactName)
        {
            Contacts::where('contact_name', $contactName)->delete();
        }
        return back();
    }
}
