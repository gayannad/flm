@extends('layouts.app')
@section('title','Friend List')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">List of Friends</div>

                    <div class="card-body">
                        <form action="{{route('friend-search')}}" method="post">
                            <div class="form-group row">
                                {{csrf_field()}}
                                <div class="col-md-9">
                                    <input type="text" name="search" class="form-control" placeholder="SEARCH">
                                </div>
                                <div class="col-md-3">
                                    <button type="submit" class="btn btn-primary btn-sm float-left"><i
                                            class="fa fa-search">Search</i></button>
                                </div>
                            </div>
                        </form>
                        <div class="row form-group">
                            <table class="table">
                                <tr>
                                    <th>#</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Action</th>
                                </tr>
                                @foreach($friends as $friend)
                                    <tr>
                                        <td>{{$friend->id}}</td>
                                        <td>{{$friend->friendUser->first_name}}</td>
                                        <td>{{$friend->friendUser->last_name}}</td>
                                        <td>
                                            <button class="btn btn-danger btn-sm"
                                                    onclick="removeFriend({{$friend->id}})">Remove
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                        {{ $friends->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

<script>
    function removeFriend(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "Do you want to remove  ?",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: '/remove-friend/' + id,
                    type: 'GET',
                    success: function (response) {
                        location.reload();
                    }
                });
                Swal.fire(
                    'removed!',
                    'friend has been removed.',
                    'success'
                )
            }
        })
    }
</script>
