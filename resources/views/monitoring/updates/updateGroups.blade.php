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

                            <div class="form-group{{ $errors->has('group') ? ' has-error' : '' }}">
                                <label for="group" class="col-md-4 control-label">Group</label>

                                <div class="col-md-6">
                                    <select id="group" class="form-control" name="group" value="{{ old('group') }}">
                                        <option selected disabled>Choose a Group</option>
                                        @foreach($groups as $group)
                                            <option value="{{ $group->alias }}">{{ $group->alias }}</option>
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
                                    <select required id="member" class="form-control" name="member" value="{{ old('member') }}">
                                        <option selected disabled>Choose a contact</option>
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
        $(document).ready(function($){
            $('#group').change(function(group){
                var group_alias=group.target.value;
                $.get('/group/dropdown', { option: group_alias }, function(data) {
                    $('#member').empty();
                    if(!$.isEmptyObject(data)) {
                        $.each(data, function (index, value) {
                            $('#member').append('<option value="' + value + '">' + value + '</option>');
                        });
                    } else {
                        $('#member').append('<option selected disabled>No Available Contacts</option>');
                    }
                });
            });
        });
    </script>
@endsection
