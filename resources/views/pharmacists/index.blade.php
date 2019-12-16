@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h2 class="float-left">Pharmacists</h2>
                        <a href="{{ url('/pharmacists/create')}} " class="btn btn-outline-success float-right">Add Pharmacist</a>
                    </div>
                    <div class="card-body">

                        <table id="example" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Start date</th>
                                <th>
                                    <button type="button" class="btn btn-default btn-sm">
                                        <i class="fas fa-user-cog"></i> edit <br/> delete
                                    </button>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($pharmacists as $pharmacist )
                                <tr>
                                    <td>{{ $pharmacist->id }}</td>
                                    <td>{{ $pharmacist->name }}</td>
                                    <td>{{ $pharmacist->email }}</td>
                                    <td>{{ $pharmacist->created_at->diffForHumans() }}</td>
                                    <td>
                                        <a href="#" class="btn btn-default btn-sm"
                                           data-toggle="modal" onclick="edit_modal({{$pharmacist}})"
                                           data-target="#modal_edit_pharmacist"
                                        >
                                            <i class="fas fa-user-edit"></i>
                                        </a>
                                        &spar;
                                        <a href="#" data-toggle="modal" onclick="delete_modal({{$pharmacist->id}})"
                                           data-target="#modal_delete_pharmacist"
                                           class="btn btn-default btn-sm" style="color:red">
                                            <i class="fas fa-user-times"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach


                            </tbody>
                        </table>
                    </div>
                </div>


                <!-- Modal Delete -->
                <div class="modal fade" id="modal_delete_pharmacist" tabindex="-1" role="dialog"
                     aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel" style="color: red">Delete pharmacist</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p hidden id="modal_delete_id"></p>
                                <form class="edit" action="javascript:delete_pharmacist();">
                                    {{--                                {{ csrf_field() }}--}}
                                    <button type="submit" class="btn btn-outline-danger">Delete</button>
                                </form>

                                <p class="text-center">Are You Sure Want To Delete ?</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>

             <!-- Modal Delete -->
                <div class="modal fade" id="modal_edit_pharmacist" tabindex="-1" role="dialog"
                     aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel" style="color: blue">Edit pharmacist</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p hidden id="modal_edit_id"></p>
                                <form class="edit" action="javascript:edit_pharmacist();">

                                    <label for="modal_edit_name">Name</label>
                                    <input type="name" name="edit_name" id="modal_edit_name" class="form-control">

                                    <label for="modal_edit_email">Email</label>
                                    <input type="email" name="edit_email" id="modal_edit_email" class="form-control">
                                    <br>
                                    <button type="submit" class="btn btn-outline-info">Update</button>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $('#example').DataTable();
        });
        function delete_modal(id) {
            $('#modal_delete_id').val(id);
            console.log('dl', id);
        }
        function delete_pharmacist() {
            console.log($('#modal_delete_id').val());
            $.ajax({
                type: "DELETE",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{URL::to('/pharmacists')}}" + "/" + $("#modal_delete_id").val(),
                data: {},
                dataType: "JSON",
                success: function (data) {
                    $('#modal_delete_pharmacist').modal('hide');
                    console.log('deleted success', data);
                },
                error: function (data) {
                    var msg = 'fail to update post';
                    if (data.status === 422) {
                        msg = 'place fill all filed !'
                    } else if (data.status === 403) {
                        msg = 'access not allowed !!'
                    } else if (data.status === 500) {
                        msg = 'server down !!!'
                    }
                    console.log(msg, data);
                }
            });
        }

        function edit_modal(row) {
            $('#modal_edit_id').val(row.id);
            $('#modal_edit_name').val(row.name);
            $('#modal_edit_email').val(row.email);
            // console.log('dl', id.name);
        }
        function edit_pharmacist() {
            console.log($('#modal_edit_id').val());
            $.ajax({
                type: "PUT",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{URL::to('/pharmacists')}}" + "/" + $("#modal_edit_id").val(),
                data: {
                    name: $('#modal_edit_name').val(),
                    email: $('#modal_edit_email').val()
                },
                dataType: "JSON",
                success: function (data) {
                    $('#modal_edit_pharmacist').modal('hide');
                    console.log('Edit success', data);
                },
                error: function (data) {
                    var msg = 'fail to update post';
                    if (data.status === 422) {
                        msg = 'place fill all filed !'
                    } else if (data.status === 403) {
                        msg = 'access not allowed !!'
                    } else if (data.status === 500) {
                        msg = 'server down !!!'
                    }
                    console.log(msg, data);
                }
            });
        }

    </script>
@endsection
