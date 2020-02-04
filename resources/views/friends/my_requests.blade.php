@extends('layouts.app')
@section('title','Request List')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Received Friend Requests</div>
                    <div class="card-body">
                        <div class="row form-group">
                            <table class="table">
                                <tr>
                                    <th>#</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                                @foreach($my_requests as $request)
                                    <tr>
                                        <td>{{$request->id}}</td>
                                        <td>{{$request->userFrom->first_name}}</td>
                                        <td>{{$request->userFrom->last_name}}</td>
                                        <td>
                                            @if($request->status == Config::get('constants.status.pending'))
                                                <span class="badge badge-primary badge-pill">pending</span>
                                            @elseif($request->status == Config::get('constants.status.approved'))
                                                <span class="badge badge-success badge-pill">approved</span>
                                            @elseif($request->status == Config::get('constants.status.rejected'))
                                                <span class="badge badge-danger badge-pill">rejected</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($request->status == Config::get('constants.status.pending'))
                                                <button class="btn btn-primary btn-sm"
                                                        onclick="confirmRequest({{$request->id}})">Approve
                                                </button>
                                            @elseif($request->status == Config::get('constants.status.approved'))
                                                <button class="btn btn-primary btn-sm" disabled>Approve</button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                        {{ $my_requests->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
<script>

    function confirmRequest(id) {

        Swal.fire({
            title: 'Are you sure?',
            text: "Do you want to confirm request ?",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: '/approve-request/' + id,
                    type: 'GET',
                    success: function (response) {
                        if (response == 200) {
                            Swal.fire(
                                'confirmed!',
                                'request has been confirmed.',
                                'success'
                            )
                            location.reload();
                        } else {
                            Swal.fire(
                                'error!',
                                'error.',
                                'danger'
                            )
                        }
                    }
                });

            }
        })
    }
</script>
