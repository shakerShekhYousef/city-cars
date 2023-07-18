@extends('layouts.layout')

@section('content-wrapper')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1> Trip Reports</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active"> Trip Reports</li>
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
                <h3 class="card-title"> Trip Reports</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">

                <table class="table table-bordered trip_datatable">
                    <thead>
                        <tr class="text-center">
                            <th style="width: 1%">
                                #
                            </th>

                            <th style="width: 12%">
                                User Name
                            </th>
                            <th style="width: 12%">
                                Driver Name
                            </th>

                            <th style="width: 12%">
                                Pickup Point
                            </th>
                            <th style="width: 12%">
                                Destination
                            </th>
                            <th style="width: 12%">
                                Trip Distance
                            </th>
                            <th style="width: 10%">
                                Trip cost
                            </th>
                            <th style="width: 12%">
                                Driver Prcentage
                            </th>
                            <th style="width: 12%">
                                Company Prcentage
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
            var table = $('.trip_datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('tripreports') }}"
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'name',
                        name: 'users.name'
                    },
                    {
                        data: 'drname',
                        name: 'drivers.name'
                    },
                    {
                        data: 'pickup_name',
                        name: 'estimates.pickup_name'
                    },
                    {
                        data: 'dropoff_name',
                        name: 'estimates.dropoff_name'
                    },
                    {
                        data: 'distance_estimate',
                        name: 'estimates.distance_estimate',
                        searchable:false,
                        orderable: false
                    },
                    {
                        data: 'estimated_value',
                        name: 'estimates.estimated_value',
                        searchable:false,
                        orderable: false
                    },
                    {
                        data: 'Driver_Prcentage',
                        name: 'Driver_Prcentage',
                        searchable:false,
                        orderable: false
                    },
                    {
                        data: 'Driver_Company_Prcentage',
                        name: 'Driver_Company_Prcentage',
                        searchable:false,
                        orderable: false
                    }
                ]
            });

        });
    </script>
@endpush
