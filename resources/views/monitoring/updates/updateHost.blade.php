@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Rename Host {{ $host_name }}</div>
                    <div class="panel-body">

                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/monitoring/hosts/update') }}">
                            {{ csrf_field() }}
                            {{ method_field('PATCH') }}

                            <input type="hidden" value="{{ $host_id }}" name="host_id" id="host_id">

                            <div class="form-group{{ $errors->has('host_name') ? ' has-error' : '' }}">
                                <label for="alias" class="col-md-4 control-label">Host Name</label>

                                <div class="col-md-6">
                                    <input id="alias" class="form-control" name="alias" value="{{ $alias }}">
                                    @if ($errors->has('alias'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('alias') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                
                                <label for="alias" class="col-md-4 control-label">IP Address</label>

                                <div class="col-md-6">
                                    <input id="address" class="form-control" name="address" value="{{ $address }}">
                                    @if ($errors->has('address'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('address') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary" name="updateHost" value="updateHost">
                                        <i class="fa fa-btn fa-user"></i>Update Host
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
