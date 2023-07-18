@extends('layouts.layout')

@section('content-wrapper')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Users</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Users</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Users</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 col-12 mt-2 mb-3">
                        <label for="role">Select Role</label>
                        <div class="group">

                            <select name="role" id="role" class="form-control" placeholder="Role">
                                <option value=""></option>
                                <option value="Admin">Admin</option>
                                <option value="Driver">Driver</option>
                                <option value="User">User</option>
                            </select>

                        </div>
                    </div>
                </div>
                <table class="table table-bordered user_datatable">
                    <thead>
                        <tr class="text-center">
                            <th style="width: 1%">
                                #
                            </th>
                            <th style="width: 10%">
                                Name
                            </th>
                            <th style="width: 19%">
                                Email
                            </th>
                            <th style="width: 12%">
                                Country Code
                            </th>
                            <th style="width: 12%">
                                Phone Number
                            </th>

                            <th style="width: 10%" class="text-center">
                                Role
                            </th>

                            <th style="width: 12%" class="text-center">
                                Driver Balance
                            </th>

                            <th style="width: 12%" class="text-center">
                                Rate
                            </th>
                            <th style="width: 25%" class="text-center">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->

    </section>

    <!-- /.content -->
@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>

    <script type="text/javascript">
        $(function() {
            var table = $('.user_datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('userslist') }}",
                    data: function(d) {
                        d.role = $('#role').val();
                        d.search = $('input[type="search"]').val();
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'country_code',
                        name: 'country_code'
                    },
                    {
                        data: 'phone_number',
                        name: 'phone_number'
                    },
                    {
                        data: 'role',
                        name: 'role'
                    },
                    {
                        data: 'driver_credit',
                        name: 'driver_credit'
                    },
                    {
                        data: 'rate',
                        name: 'rate'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });

        });
    </script>
    <script type="text/javascript">
        function deleteUser(id) {
            swal({
                    title: `Are you sure you want to delete this record?`,
                    text: "If you delete this, it will be gone forever.",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true
                })
                .then((willDelete) => {
                    if (willDelete) {
                        var url = "{{ route('usersdelete', '#id') }}";
                        url = url.replace('#id', id);
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            type: 'post',
                            url: url,
                            contentType: "application/json",
                            dataType: 'json',
                            complete: function(result) {
                                if (result.responseJSON == 1) {
                                    $('.user_datatable').DataTable().draw();
                                } else {
                                    swal({
                                        title: `You cannot delete current admin!`,
                                        icon: "warning",
                                        dangerMode: true,
                                    })
                                }
                            }
                        });
                    }
                });
        }
    </script>

    <script>
        $('#role').change(function() {
            $('.user_datatable').DataTable().draw();
        });
    </script>
@endpush
