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
                                <li>{{ $group->alias }} | 
                                <a href="/monitoring/groups/rename/{{ $group->alias }}">Rename</a> |
                                <a href="/monitoring/groups/delete/{{ $group->alias }}">Delete</a></li>
                                @if($group->members)
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
                    <div class="panel-heading">Add or Remove Users</div>
                    <div class="panel-body">

                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/monitoring/groups/contactUpdate') }}">
                            {{ csrf_field() }}
                            {{ method_field('PATCH') }}

                            <div class="form-group{{ $errors->has('groupList') ? ' has-error' : '' }}">
                                <label for="groupList" class="col-md-4 control-label">Contact Group</label>

                                <div class="col-md-6">
                                    <select id="groupList" class="form-control" name="groupList">
                                        <option selected disabled>Choose a Group</option>
                                        @foreach ($groups as $group)
                                            <option>{{ $group->alias }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('groupList'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('groupList') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('availableMembers') ? ' has-error' : '' }}">
                                <label id="listlabel" for="availableMembers" class="col-md-4 control-label">Contact List</label>

                                <div class="col-md-6">
                                    <select id="availableMembers" class="form-control" name="availableMembers">
                                        <option selected disabled>Choose a Contact</option>
                                        @foreach ($contacts as $contact)
                                            <option>{{ $contact }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('availableMembers'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('availableMembers') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary" name="add" value="add" id="add">
                                        <i class="fa fa-btn fa-user"></i> Add Member
                                    </button>
                                </div>
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary" name="remove" value="remove" id="remove">
                                        <i class="fa fa-btn fa-user"></i> Delete Member
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
        $(document).ready(function($) {
            $('#add').hide();
            $('#remove').hide();
        });

        $(document).ready(function($) {
            $('#availableMembers').change(function(alias){
                var group_contact=alias.target.value;
                var group_alias=$('#groupList').val();
                $.get('/api/group_contact', { group: group_alias, contact: group_contact }, function(data) {
                   if(data == "") {
                       $('#add').show();
                   } else {
                       $('#remove').show();
                   }
                });
            });
        });
    </script>
@endsection
