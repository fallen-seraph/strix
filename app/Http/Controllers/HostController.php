<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Host;
use App\Contacts;
use App\Group;
use App\Services;
use App\HostService;
use App\Http\Requests;

class HostController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    public function hosts(){
        $accountId=Auth::user()->account_id;
        $hosts=Host::where('account_id', $accountId)->get();

        return view('monitoring.hosts', compact('hosts'));
    }
    public function newHost(Request $request, Host $host){
        $accountId=Auth::user()->account_id;
        $hostName=$request->alias;
        $request->request->add(['host_name' => $hostName]);
		
        $this->validate($request, [
            'host_name' => 'required',
			'address' => 'required',
        ]);
		
        $host->create([
            'account_id' => $accountId,
            'host_name' => $hostName,
            'alias' => $request->alias,
			'address' => $request->address,
			'contacts' => $request->contacts,
			'contact_groups' => $request->contact_groups,
        ]);
        
        return redirect()->action('HostController@hosts');
    }
	public function addContacts(Request $request){
	
	}
	public function addService(Request $request, HostService $hostService){
        $accountId=Auth::user()->account_id;
		
        $host=Host::where('account_id', $accountId)->where('host_name', $request->host)->first();
        $service=Services::where('service_id', $request->service)->select('command_name', 'description')->first();

        if($host->services != null){
            if(strpos($host->services, $service->command_name) !== false){
                return back()->withErrors(['service' => 'This service is already being monitored on this host.']);
            } else {
                Host::where('account_id', $accountId)
                    ->where('host_name', $request->host)
                    ->update([
                        'services' => $host->services . "," . $service->command_name,
                    ]);
            }
        } else {
			Host::where('account_id', $accountId)
				->where('host_name', $request->host)
				->update([
					'services' => $service->command_name,
				]);
		}
		
		$hostService->create([
			'host_id' => $host->host_id,
			'account_id' => $accountId,
			'service_id' => $request->service,
			'host_name' => $host->host_name,
			'service_description' => $service->description,
			'check_command' => $service->command_name,
			'argument_one' => $request->arg_one,
			'argument_two' => $request->arg_two,
			'argument_three' => $request->arg_three,
			'argument_four' => $request->arg_four,
			'argument_five' => $request->arg_five,
			'contacts' => $accountId . "_" . $host->contacts,
			'contact_groups' => $accountId . "_" . $host->contact_groups,
		]);
		
        return redirect()->action('HostController@hosts');
    }
}
