@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Monitoring Groups</div>

                    <div class="panel-body">
                        <ul>
                            @foreach ($groups as $group)
                                <li>{{ $group->alias }}</li>
                                <ul>
                                    Members
                                    @foreach ($group->members as $member)
                                        <li>{{ trim($member, Auth::user()->account_id . "_") }}</li>
                                    @endforeach
                                </ul>
                            @endforeach
                        </ul>
                    </div>

                    <div class="panel-heading">Add Group</div>
                    <div class="panel-body">

                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/monitoring/group') }}">
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('group_name') ? ' has-error' : '' }}">
                                <label for="alias" class="col-md-4 control-label">Group Name</label>

                                <div class="col-md-6">
                                    <input id="alias" type="text" class="form-control" name="alias" value="{{ old('alias') }}">

                                    @if ($errors->has('group_name'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('group_name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-btn fa-user"></i> New Group
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    @if($users->first())
                        <div class="panel-heading">Add User to Group</div>
                        <div class="panel-body">

                            <form class="form-horizontal" role="form" method="POST" action="{{ url('/monitoring/group/user') }}">
                                {{ csrf_field() }}

                                <div class="form-group{{ $errors->has('group') ? ' has-error' : '' }}">
                                    <label for="group" class="col-md-4 control-label">Group</label>

                                    <div class="col-md-6">
                                        <select id="group" class="form-control" name="group" value="{{ old('group') }}">
                                            @foreach($groups as $group)
                                                <option>{{ $group->alias }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('group'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('group') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('member') ? ' has-error' : '' }}">
                                    <label for="member" class="col-md-4 control-label">Member</label>

                                    <div class="col-md-6">
                                        <select id="member" class="form-control" name="member" value="{{ old('member') }}">
                                            @foreach($users as $user)
                                                <option>{{ $user }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('member'))
                                            <span class="help-block">
                                            <strong>{{ $errors->first('member') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-4">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fa fa-btn fa-user"></i> Add Member
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
