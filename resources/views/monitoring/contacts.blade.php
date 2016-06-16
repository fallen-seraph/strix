@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Monitoring Contacts</div>

                    <div class="panel-body">
                        <ul>
                            @foreach ($contacts as $contact)
                                    <li>
                                        {{ $contact->alias }} |
                                        <a href="/monitoring/contacts/update/{{ $contact->alias }}">Update</a> |
                                        <a href="/monitoring/contacts/{{ $contact->alias }}">Delete</a>
                                        <ul>
                                            <li>Email  | {{ $contact->email }}</li>
                                            @if(is_null($contact->phone))
                                                <li>Phone | {{ $contact->phone }}</li>
                                            @endif
                                            @if(is_null($contact->misc))
                                                <li>Misc    | {{ $contact->misc }}</li>
                                            @endif
                                        </ul>
                                    </li>
                            @endforeach
                        </ul>
                    </div>
                    
                    <div class="panel-heading">Add Contact</div>
                    <div class="panel-body">

                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/monitoring/contacts') }}">
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('alias') ? ' has-error' : '' }}">
                                <label for="alias" class="col-md-4 control-label">Contact Name</label>

                                <div class="col-md-6">
                                    <input id="alias" type="text" class="form-control" name="alias" value="{{ old('alias') }}">

                                    @if ($errors->has('alias'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('alias') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="email" class="col-md-4 control-label">Email</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}">

                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                                <label for="password-confirm" class="col-md-4 control-label">Phone</label>

                                <div class="col-md-6">
                                    <input id="phone" type="text" class="form-control" name="phone" value="{{ old('phone') }}">

                                    @if ($errors->has('phone'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="form-group{{ $errors->has('misc') ? ' has-error' : '' }}">
                                <label for="password-confirm" class="col-md-4 control-label">Misc</label>

                                <div class="col-md-6">
                                    <input id="misc" type="text" class="form-control" name="misc" value="{{ old('misc') }}">

                                    @if ($errors->has('misc'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('misc') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-btn fa-user"></i> New Contact
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
