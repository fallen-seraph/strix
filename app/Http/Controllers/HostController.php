<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Host;
use App\Contacts;
use App\Group;
use App\Http\Requests;

class HostController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    public function hosts(){
        $accountId=Auth::user()->account_id;
        $hosts=Host::where('account_id', $accountId)->lists('host_name');

        $hosts=$hosts->toArray();
        foreach($hosts as &$host){$host=trim($host, $accountId . "_");}
        
        $contacts=Contacts::where('account_id', $accountId)->lists('contact_name');
        $contact_groups=Group::where('account_id', $accountId)->lists('group_name');

        return view('monitoring.hosts', compact('hosts', 'contacts', 'contact_groups'));
    }
    public function newHost(Request $request, Host $host){
        $accountId=Auth::user()->account_id;
        $hostName=$account_id . "_" . $request->alias;
        $request->request->add(['host_name' => $hostName]);
		
        $this->validate($request, [
            'group_name' => 'required|unique:nagidb.nagios_host,host_name',
			'address' => 'required',
			'contacts' => 'exists:nagidb.nagios_contact,account_id, $accountId',
			'contact_groups' => 'exists:nagidb.nagios_contact_group,account_id,$accountId',
			
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
		
        $hostName=$accountId . "_" . $request->host;
		
        $host=Host::where('account_id', $accountId)->where('host_name', $hostName)->get();
		$service=Service::where('service_id', $request->service_id)->select('check_command', 'description');
		
        if(strpos($existingServices->services, $newService) !== false){
            return back()->withErrors(['service' => 'This service is already being monitored on this host.']);
        }
		
		if($existingServices){
			Host::where('account_id', $accountId)
				->where('host_name, $hostName)
				->update([
					'services' => $existingServices . "," . $request->service,
				]);
		} else {
			Host::where('account_id', $accountId)
				->where('host_name, $hostName)
				->update([
					'services' => $request->service,
				]);
		}
		
		$hostService->create([
			'host_id' => $host->host_id,
			'account_id' => $accountId,
			'service_id' => $request->service_id,
			'host_name' => $host->host_name,
			'service_description' => $service->description,
			'check_command' => $service->check_command,
			'arg_one' => $request->arg_one,
			'arg_two' => $request->arg_two,
			'arg_three' => $request->arg_three,
			'arg_four' => $request->arg_four,
			'arg_five' => $request->arg_five,
			'contacts' => $host->contacts,
			'contact_groups' => $host->contact_groups,
		]);
		
        return redirect()->action('HostController@hosts');
    }
}
