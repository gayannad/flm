@extends('layouts.app')
@section('title','User List')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Find Friends</div>

                    <div class="card-body">
                        <div class="row form-group">
                            <table class="table">
                                <tr>
                                    <th>#</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Action</th>
                                </tr>
                                @foreach($users as $user)
                                    <tr>
                                        <td>{{$user->id}}</td>
                                        <td>{{$user->first_name}}</td>
                                        <td>{{$user->last_name}}</td>
                                        <td>
                                            <button class="btn btn-primary btn-sm" onclick="sendRequest({{$user->id}})">Add Friend
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

<script>

    function sendRequest(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "Do you want to send request ?",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: '/add-friend/' + id,
                    type: 'GET',
                    success: function (response) {
                        if (response == 200){
                            Swal.fire(
                                'sent!',
                                'request has been sent.',
                                'success'
                            )
                        }else{
                            Swal.fire(
                                'error!',
                                'request already sent.',
                                'danger'
                            )
                        }
                    }
                });

            }
        })
    }

</script>
