@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Welcome</div>

                    <div class="panel-body">
                        <ul>
                            @foreach ($users as $user)
                                <li>
                                    {{ $user }} |
                                    @unless( Auth::user()->email == $user )
                                        <a href="/monitoring/users/{{ $user }}">Delete</a>
                                    @endunless
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection