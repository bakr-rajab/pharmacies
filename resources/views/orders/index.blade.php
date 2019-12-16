@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        <h2 class="float-left">Medicines</h2>
                        <a href="#"
                           data-toggle="modal"
                           data-target="#modal_create_order" onclick="make_order()"
                           class="btn btn-outline-success float-right">Make Order </a>
                    </div>
                    <div class="card-body">

                        <table id="example" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Price</th>
                                <th>quantity</th>
                                <th>Description</th>
                                <th>
                                    <button type="button" class="btn btn-default btn-sm">
                                        <i class="fas fa-user-cog"></i> edit <br/> delete
                                    </button>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($medicines as $medicine )
                                <tr>
                                    <td>{{ $medicine->id }}</td>
                                    <td>{{ $medicine->name }}</td>
                                    <td>{{ $medicine->price }}</td>
                                    <td>{{ $medicine->quantity }}</td>
                                    <td>{{ $medicine->description }}</td>
                                    <td>
                                        <a href="#" class="btn btn-default btn-sm"
                                           data-toggle="modal" onclick="edit_modal({{$medicine}})"
                                           data-target="#modal_edit_medicine"
                                        >
                                            <i class="fas fa-user-edit"></i>
                                        </a>
                                        &spar;
                                        <a href="#"
                                           class="btn btn-default btn-sm" style="color:red">
                                            <input type="checkbox"
                                                   @if(! $medicine->quantity)
                                                   disabled
                                                   @endif
                                                   id="{{$medicine->id}}" value="{{$medicine}}">
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- Modal create -->
                <div class="modal fade" id="modal_create_order" tabindex="-1" role="dialog"
                     aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel" style="color: blue">Bill medicine</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">

                                <table id="example" class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Price</th>

                                    </tr>
                                    </thead>
                                    <tbody id="orders">

                                    </tbody>
                                    <tfoot id="total_price">

                                    </tfoot>
                                </table>
                            </div>
                            <button type="button" onclick="generate_bill()" class="btn btn-info float-left"
                                    data-dismiss="modal">Print Bill
                            </button>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary close" data-dismiss="modal">Close
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Modal edit -->
                <div class="modal fade" id="modal_edit_medicine" tabindex="-1" role="dialog"
                     aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel" style="color: blue">Edit medicine</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p hidden id="modal_edit_id"></p>
                                <form class="edit" action="javascript:edit_medicine();">

                                    <label for="modal_edit_name">Name</label>
                                    <input type="name" name="edit_name" id="modal_edit_name" class="form-control">

                                    <label for="modal_edit_price">Price</label>
                                    <input type="number" name="edit_price" id="modal_edit_price" class="form-control">

                                    <label for="modal_edit_quantity">Quantity</label>
                                    <input type="number" name="edit_quantity" id="modal_edit_quantity"
                                           class="form-control">

                                    <label for="modal_edit_description">Description</label>
                                    <input type="text" name="edit_description" id="modal_edit_description"
                                           class="form-control">

                                    <br>
                                    <button type="submit" class="btn btn-outline-info">Update</button>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary close" data-dismiss="modal">Close
                                </button>
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

        function generate_bill() {

            $.each($("input:checked"), function () {
                (JSON.parse($(this).val()).id);
                $.ajax({
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{URL::to('/orders/save-bill')}}",
                    data: {
                        id: JSON.parse($(this).val()).id
                    },
                    dataType: "JSON",
                    success: function (data) {
                        $('#modal_create_order').modal('hide');
                        console.log('bill success', data);
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
            });
        }

        function make_order() {
            $('#orders').html("");
            $('#total_price').html("");
            var total = 0;
            $.each($("input:checked"), function () {
                total += JSON.parse($(this).val()).price;
                $('#orders').append(`
                <tr>
                    <td>${JSON.parse($(this).val()).id}</td>
                    <td>${JSON.parse($(this).val()).name}</td>
                    <td>${JSON.parse($(this).val()).price}</td>
                </tr>
                `);
            });
            $('#total_price').append(`
              <tr>
                <th>Total Price</th>
                <th></th>
                <th>${total}</th>
            </tr>
            `);
            console.log(total);
        }

        function edit_modal(row) {
            $('#modal_edit_id').val(row.id);
            $('#modal_edit_name').val(row.name);
            $('#modal_edit_price').val(row.price);
            $('#modal_edit_quantity').val(row.quantity);
            $('#modal_edit_description').val(row.description);
            // console.log($('input:checked'));
        }

        function create_medicine() {
            $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{URL::to('/medicines')}}",
                data: {
                    name: $('#modal_create_name').val(),
                    price: $('#modal_create_price').val(),
                    quantity: $('#modal_create_quantity').val(),
                    description: $('#modal_create_description').val(),
                },
                dataType: "JSON",
                success: function (data) {
                    $('#modal_create_medicine').modal('hide');
                    $("#modal_create_medicine .close").click()
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
                    $("#modal_create_medicine .close").click()
                }
            });
        }

        function edit_medicine() {
            console.log($('#modal_edit_id').val());
            $.ajax({
                type: "PUT",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{URL::to('/medicines')}}" + "/" + $("#modal_edit_id").val(),
                data: {
                    name: $('#modal_edit_name').val(),
                    price: $('#modal_edit_price').val(),
                    quantity: $('#modal_edit_quantity').val(),
                    description: $('#modal_edit_description').val(),
                },
                dataType: "JSON",
                success: function (data) {
                    $('#modal_edit_medicine').modal('hide');
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
