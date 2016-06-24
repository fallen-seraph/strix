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
        $contacts=Contacts::where('contact_id', $contact_id)->first();

        return view('monitoring.contacts', compact('contacts'));
    }
    public function updateContact(Request $request){
        Contacts::where('contact_id', $request->contact_id)->update([
            'alias' => $request->alias,
            'email' => $request->email,
            'phone' => $request->phone,
            'misc' => $request->misc,
        ]);

        return redirect()->action('ContactsController@contacts');
    }
}
