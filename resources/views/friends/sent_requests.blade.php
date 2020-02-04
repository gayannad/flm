@extends('layouts.app')
@section('title','Request List')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Sent Friend Requests</div>
                    <div class="card-body">
                        <div class="row form-group">
                            <table class="table">
                                <tr>
                                    <th>#</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Status</th>
                                </tr>
                                @foreach($sent_requests as $request)
                                    <tr>
                                        <td>{{$request->id}}</td>
                                        <td>{{$request->user->first_name}}</td>
                                        <td>{{$request->user->last_name}}</td>
                                        <td>
                                            @if($request->status == Config::get('constants.status.pending'))
                                                <span class="badge badge-primary badge-pill">pending</span>
                                            @elseif($request->status == Config::get('constants.status.approved'))
                                                <span class="badge badge-success badge-pill">approved</span>
                                            @elseif($request->status == Config::get('constants.status.rejected'))
                                                <span class="badge badge-danger badge-pill">rejected</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                        {{ $sent_requests->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
