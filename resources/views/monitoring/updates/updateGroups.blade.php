@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Update Group {{ $group->alias }}</div>
                    <div class="panel-body">

                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/monitoring/groups/update') }}">
                            {{ csrf_field() }}
                            {{ method_field('PATCH') }}

                            <input id="group_id" type="hidden" name="group_id" value="{{ $group->group_id }}">

                            <div class="form-group{{ $errors->has('groupName') ? ' has-error' : '' }}">
                                <label for="groupName" class="col-md-4 control-label">Group Name</label>

                                <div class="col-md-6">
                                    <input id="groupName" class="form-control" name="groupName" value="{{ $group->alias }}">
                                    @if ($errors->has('groupName'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('groupName') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary" id="nameChange">
                                        <i class="fa fa-btn fa-user"></i> Change Group Name
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="panel-body">

                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/monitoring/groups/update') }}">
                            {{ csrf_field() }}
                            {{ method_field('PATCH') }}


                            <input id="group_id" type="hidden" name="group_id" value="{{ $group->group_id }}">

                            <div class="form-group{{ $errors->has('availableMembers') ? ' has-error' : '' }}">
                                <label for="availableMembers" class="col-md-4 control-label">Contact List</label>


                                <div class="col-md-6">
                                    <select id="availableMembers" class="form-control" name="availableMembers">
                                        <option selected disabled>Choose a contact</option>
                                        @foreach($availableContacts as $contact)
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
                                    <button type="submit" class="btn btn-primary" id="add">
                                        <i class="fa fa-btn fa-user"></i> Add Member
                                    </button>
                                </div>
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary" id="remove">
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
@endsection
