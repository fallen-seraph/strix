@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Monitoring Users</div>

                    <div class="panel-body">
                        <ul>
                            @foreach ($contacts as $contact)
                                    <li>
                                        {{ $contact }} |
                                        <a href="/monitoring/contacts/{{ $contact }}">Delete</a>
                                    </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
