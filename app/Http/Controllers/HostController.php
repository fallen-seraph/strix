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

        foreach($hosts as $host){
            if($host->services){
                $host->services=explode(",", $host->services);
            }
            if($host->contacts){
                $host->contacts=explode(",", $host->contacts);
            }
            if($host->contact_groups){
                $host->contact_groups=explode(",", $host->contact_groups);
            }
        }

        $contacts=Contacts::where('account_id', $accountId)->lists('contact_name');
        $contact_groups=Group::where('account_id', $accountId)->lists('group_name');
        $services=Services::select('service_id', 'service_name')->get();

        return view('monitoring.hosts', compact('hosts', 'contacts', 'contact_groups', 'services'));
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
        ]);
        
        return redirect()->action('HostController@hosts');
    }
    public function addContact(Request $request, Host $hostContacts){
        $accountId=Auth::user()->account_id;
		
        Host::where('account_id', $accountId)
                ->where('host_id', $request->host_id)
                ->update([
                   'contacts' => $request->contacts,
                   'contact_groups' => $request->contact_groups,
                ]);
        
        return redirect()->action('HostController@hosts');
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
    public function deleteHost($hostName){
    	$accountId=Auth::user()->account_id;
	    $hostId=Host::where('account_id', $accountId)->where('host_name', $hostName)->value('host_id');
		
		
    	HostService::where('account_id', $accountId)->where('host_id', $hostId)->delete();
    	Host::where('account_id', $accountId)->where('host_id', $hostId)->delete();
    	
    	return redirect()->action('HostController@hosts');
    }
}
