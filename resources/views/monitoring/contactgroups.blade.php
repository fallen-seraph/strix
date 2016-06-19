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
                                <li>{{ $group->alias }} | <a href="/monitoring/groups/{{ $group->alias }}">Delete</a></li>
                                @if($group->members[0])
                                    <ul>
                                        Members
                                        @foreach ($group->members as $member)
                                            <li>{{ trim($member, Auth::user()->account_id . "_") }}</li>
                                        @endforeach
                                    </ul>
                                @endif
                            @endforeach
                        </ul>
                    </div>

                    <div class="panel-heading">Add Group</div>
                    <div class="panel-body">

                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/monitoring/groups') }}">
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
                    <div class="panel-heading">Add User to Group</div>
                    <div class="panel-body">

                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/monitoring/groups') }}">
                            {{ csrf_field() }}
                            {{ method_field('PATCH') }}

                            <div class="form-group{{ $errors->has('group') ? ' has-error' : '' }}">
                                <label for="group" class="col-md-4 control-label">Group</label>

                                <div class="col-md-6">
                                    <select id="group" class="form-control" name="group" value="{{ old('group') }}">
                                        <option>- - - </option>
                                        @foreach($groups as $group)
                                            <option value="{{ $group->group_name }}">{{ $group->alias }}</option>
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
                                        <option>- - -</option>
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
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
    <script>
        jQuery(document).ready(function($) {
            $('#group').change(function(){
                $.get("{{ url('api/dropdown')}}", { option: $('#group').val() },
                function(data) {
                    console.log( data );
                    var members = $('#member');
                    members.empty();
                    $.each(data, function(key, value) {
                        members.append($("<option></option>")
                                .attr("value",key)
                                .text(value));
                    });
                });
            });
        });
    </script>
@endsection
