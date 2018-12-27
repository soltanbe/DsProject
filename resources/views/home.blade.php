@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    <div class="col-md-4">
                        <h3>Name</h3>
                      {{--  <div id="name">{{$user->name}}</div>--}}
                        <div id="name"></div>
                    </div>
                        <div class="col-md-4">
                            <h3>brithday </h3>
                          {{--  <div id="brithday">{{$user->brithday}}</div>--}}
                            <div id="brithday"></div>
                    </div>
                        <div class="col-md-4">
                            <h3>hobbies </h3>
                            <div id="hobbies">
                                {{--<ul>
                                    @foreach ($user->hobbies as $u)
                                        <li>{{$u}}</li>
                                    @endforeach
                                </ul>--}}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h3>frinds </h3>
                            <div id=frinds>
                               {{-- <ul class="list-frinds">
                                    @foreach ($user->frinds as $k=>$v)
                                        <li>{{$v->name}}</li>
                                    @endforeach
                                </ul>--}}
                            </div>
                        </div>
                    <div class="col-md-6">
                                <h3>other</h3>
                                <div  class="other-frinds" id=other>
                                {{--<ul class="list-frinds">
                                    @foreach ($user->notFrinds as $k=>$v)
                                        <li>
                                            <div class="col-md-6">
                                                {{$v->name}}
                                            </div>
                                            <div class="col-md-6">
                                                <button>Add Frind<i class="fa fa-plus"></i></button>
                                            </div>
                                        </li>

                                    @endforeach
                                </ul>--}}
                                </div>
                        </div>

                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">Action</div>

                <div class="panel-body">
                    <div class="col-md-12">
                        <button type="button" class="btn btn-primary">Primary</button>
                        <button type="button" class="btn btn-secondary">Secondary</button>
                        <button type="button" class="btn btn-success">Success</button>
                        <button type="button" class="btn btn-danger">Danger</button>
                    </div>



                </div>
            </div>
        </div>
    </div>
</div>
@endsection
