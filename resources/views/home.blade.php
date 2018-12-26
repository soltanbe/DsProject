@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="col-md-3">
                        <div>name  </div>
                        <div>{{$user->name}}</div>
                    </div>
                        <div class="col-md-3">
                            <div>brithday </div>
                            <div>{{$user->brithday}}</div>
                    </div>
                        <div class="col-md-3">
                            <div>hobbies </div>
                            <div>
                                <ul>
                                    @foreach ($user->hobbies as $u)
                                        <li>{{$u}}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div>frinds </div>
                            <div>
                                <ul>
                                    @foreach ($frinds as $k=>$v)
                                        <li>{{$v->name}}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
