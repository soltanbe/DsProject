@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-7">
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
        <div class="col-md-5">
            <div class="panel panel-default">
                <div class="panel-heading">Action</div>

                <div class="panel-body">
                    <div class="col-md-12">
                        <button type="button" id="show_all_friends" class="btn btn-primary">Show All Friend</button>
                        <button type="button" id="show_brithdays" class="btn btn-secondary">Show Brithdays</button>
                        <button type="button" id="show_potenial_friends" class="btn btn-success">Show potenial Friends</button>
                        <button type="button" id="show_upcoming_brithdays" class="btn btn-danger">Show Upcoming Brithdays</button>
                    </div>

                    <div class="col-md-12">
                        <h3 id="action_name"></h3>
                        {{--  <div id="name">{{$user->name}}</div>--}}
                        <div class="other-frinds" id="action_data"></div>
                    </div>



                </div>
            </div>
        </div>
    </div>
</div>
@endsection
