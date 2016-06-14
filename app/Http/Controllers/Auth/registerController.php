<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\account_information;
use App\User;
use Schema;
use Auth;
use Illuminate\Database\Schema\Blueprint;

use App\Http\Requests;

class registerController extends Controller
{
    public function showForm(){
        return view('register');
    }
    public function register(Request $request, account_information $account, User $user){
        $this->validate($request, [
        	'username' => 'required|unique:mysql.users,username',
        	'password' => 'required|min:8|confirmed',
        	'password_confirmation' => 'required|min:8',
        	'email' => 'required|email|unique:mysql.users,email'
        ]);
        
        $account->create([
            'email' => $request->email,
            'first_name' => $request->fname,
            'last_name' => $request->lname,
            'account_type' => $request->account_type,
            'service' => 0,
            'company' => $request->company,
            'phone' => $request->phone,
            'address_one' => $request->addr_one,
            'address_two' => $request->addr_two,
            'city' => $request->city,
            'state' => $request->state,
            'zip' => $request->zip,
            'country' => $request->country
        ]);
        
        $accountId = account_information::where('email', $request->email)->value('account_id');
        
        $user->create([
            'account_id' => $accountId,
            'username' => $request->user,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);
        
        Schema::connection('accountLogs')->create($accountId, function (Blueprint $table) {
            $table->increments('log_num');
            $table->string('type');
            $table->string('value');
            $table->timestamps();
        });
        
        return view('monitoring');
    }
}
