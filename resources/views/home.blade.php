@extends('layouts.app')
@section('title','Home')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Dashboard</div>

                    <div class="card-body">
                        <div class="row form-group">
                            <div class="col-md-3">
                                <a href="{{route('user-list')}}">
                                    <div class="card-counter primary">
                                        <i class="fa fa-user-plus"></i>
                                        <span class="count-name">Find Friends</span>
                                    </div>
                                </a>
                            </div>

                            <div class="col-md-3">
                                <a href="{{route('sent-requests')}}">
                                    <div class="card-counter primary">
                                        <i class="fa fa-send"></i>
                                        <span class="count-numbers">{{$sent_request}}</span>
                                        <span class="count-name">Sent Requests</span>
                                    </div>
                                </a>
                            </div>

                            <div class="col-md-3">
                                <a href="{{route('my-requests')}}">
                                    <div class="card-counter primary">
                                        <i class="fa fa-inbox"></i>
                                        <span class="count-numbers">{{$my_request}}</span>
                                        <span class="count-name">My Requests</span>
                                    </div>
                                </a>
                            </div>

                            <div class="col-md-3">
                                <a href="{{route('friend-list')}}">
                                    <div class="card-counter primary">
                                        <i class="fa fa-list-alt"></i>
                                        <span class="count-numbers">{{$friends}}</span>
                                        <span class="count-name">My Friend List</span>
                                    </div>
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
