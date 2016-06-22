@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Nagios Hosts and Services</div>
                    <div class="panel-body">
                        @foreach ($hosts as $host)
                            <ul>
                                Hostname:
                                <ul>
                                    <li>{{ $host->host_name }} | <a href="/monitoring/update/hosts/{{ $host->host_name }}">Update</a> | <a href="/monitoring/hosts/{{ $host->host_name }}">Delete</a></li>
                                </ul>
                                IP Address:
                                <ul>
                                    <li>{{ $host->address }}</li>
                                    @if(isset($host->services))
                                        Services:
                                        <ul>
                                            @foreach($host->services as $service)
                                                <li>{{ $service }}</li>
                                            @endforeach
                                        </ul>
                                    @endif
                                    @if(isset($host->contacts))
                                        Contacts
                                        <ul>
                                            @foreach($host->contacts as $contact)
                                                <li>{{ $contact }}</li>
                                            @endforeach
                                        </ul>
                                    @endif
                                    @if(isset($host->contact_groups))
                                        Contact Groups
                                        <ul>
                                            @foreach($host->contact_groups as $groups)
                                                <li>{{ $groups }}</li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </ul>
                            </ul>
                        @endforeach
                    </div>
					
					<div class="panel-heading">Add Host</div>
                    <div class="panel-body">

                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/monitoring/hosts') }}">
                            {{ csrf_field() }}
                            

                            <div class="form-group{{ $errors->has('host_name') ? ' has-error' : '' }}">
                                <label for="alias" class="col-md-4 control-label">Host Name</label>

                                <div class="col-md-6">
                                    <input id="alias" type="text" class="form-control" name="alias" value="{{ old('alias') }}">

                                    @if ($errors->has('host_name'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('host_name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
							<div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                                <label for="address" class="col-md-4 control-label">Address</label>

                                <div class="col-md-6">
                                    <input id="address" type="text" class="form-control" name="address" value="{{ old('address') }}">

                                    @if ($errors->has('address'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('address') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
							<div class="form-group{{ $errors->has('contacts') ? ' has-error' : '' }}">
                                <label for="contacts" class="col-md-4 control-label">Contacts</label>

                                <div class="col-md-6">
                                    <select id="contacts" class="form-control" name="contacts">
                                        <option selected disabled>Choose a Contact</option>
										@foreach($contacts as $contact)
											<option>{{ trim($contact, Auth::user()->account_id . "_") }}</option>
										@endforeach
									</select>
                                    @if ($errors->has('contacts'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('contacts') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
							
							<div class="form-group{{ $errors->has('contact_groups') ? ' has-error' : '' }}">
                                <label for="contact_groups" class="col-md-4 control-label">Contact Groups</label>

                                <div class="col-md-6">
                                    <select id="contact_groups" class="form-control" name="contact_groups">
                                        <option selected disabled>Choose a Contact Group</option>
										@foreach($contact_groups as $groups)
											<option>{{ trim($groups, Auth::user()->account_id . "_") }}</option>
										@endforeach
									</select>
                                    @if ($errors->has('contact_groups'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('contact_groups') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-btn fa-user"></i> New Host
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="panel-heading">Add Service</div>
                    <div class="panel-body">

                        <form class="form-horizontal" role="form" method="POST" action="{{ url('monitoring/hosts/service') }}">
                            {{ csrf_field() }}
                            {{ method_field('PATCH') }}


                            <div class="form-group{{ $errors->has('host') ? ' has-error' : '' }}">
                                <label for="host" class="col-md-4 control-label">Host Name</label>

                                <div class="col-md-6">

                                    <select id="host" class="form-control" name="host">
                                        @foreach ($hosts as $host)
                                            <option>{{ $host->host_name }}</option>
                                        @endforeach
                                    </select>

                                    @if ($errors->has('host'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('host') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('service') ? ' has-error' : '' }}">
                                <label for="service" class="col-md-4 control-label">Service</label>

                                <div class="col-md-6">
                                    <select id="service" class="form-control" name="service">
                                        <option selected disabled>Choose a Service</option>
                                        @foreach ($services as $service)
                                            <option value="{{ $service->service_id }}">{{ $service->service_name }}</option>
                                        @endforeach
                                    </select>

                                    @if ($errors->has('service'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('service') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-btn fa-user"></i> Add Service
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
