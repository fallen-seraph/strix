@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Nagios Hosts and Services</div>
                    <div class="panel-body">
                        <ul>
                            @foreach ($hosts as $host)
                                <li>{{ $host }} | <a href="/monitoring/hosts/{{ $host }}">Delete</a></li>
                            @endforeach
                        </ul>
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
                                <label for="contacts" class="col-md-4 control-label">contacts</label>

                                <div class="col-md-6">
                                    <select id="contacts" class="form-control" name="contacts">
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
                                <label for="contact_groups" class="col-md-4 control-label">contact_groups</label>

                                <div class="col-md-6">
                                    <select id="contact_groups" class="form-control" name="contact_groups">
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
                </div>
            </div>
        </div>
    </div>
@endsection
