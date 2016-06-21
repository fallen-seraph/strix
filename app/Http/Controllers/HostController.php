<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Host;
use App\Contacts;
use App\Group;
use App\Services;
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
		
        if(strpos($host->services, $request->service_id) !== false){
            return back()->withErrors(['service' => 'This service is already being monitored on this host.']);
        }
		
		if($host->services){
			Host::where('account_id', $accountId)
				->where('host_name', $hostName)
				->update([
					'services' => $host->services . "," . $request->service_id,
				]);
		} else {
			Host::where('account_id', $accountId)
				->where('host_name', $hostName)
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
			'argument_one' => $request->arg_one,
			'argument_two' => $request->arg_two,
			'argument_three' => $request->arg_three,
			'argument_four' => $request->arg_four,
			'argument_five' => $request->arg_five,
			'contacts' => $host->contacts,
			'contact_groups' => $host->contact_groups,
		]);
		
        return redirect()->action('HostController@hosts');
    }
}
