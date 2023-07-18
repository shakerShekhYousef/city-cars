@extends('layouts.layout')

@section('content-wrapper')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1> Cards</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Cards</li>
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
                <h3 class="card-title">Cards</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
            
                <table class="table table-bordered card_datatable">
                    <thead>
                        <tr class="text-center">
                            <th style="width: 1%">
                                #
                            </th>
                          
                            <th style="width: 19%">
                                Code
                            </th>
                            <th style="width: 19%">
                                Price
                            </th>

                            <th style="width: 19%">
                               is used
                            </th>
                      
                            <th style="width: 20%" class="text-center">
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
            var table = $('.card_datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('cardslist') }}",
                    data: function(d) {
                       
                        d.search = $('input[type="search"]').val();
                    }
                  
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false
                    },
                    {
                        data: 'code',
                        name: 'code',
                    },
                    {
                        data: 'price',
                        name: 'price',
                    },
                   
                    {
                        data: 'is_used',
                        name: 'is_used',
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
        function deleteCard(id) {
            swal({
                    title: `Are you sure you want to delete this record?`,
                    text: "If you delete this, it will be gone forever.",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true
                })
                .then((willDelete) => {
                    if (willDelete) {
                        var url = "{{ route('cardsdelete', '#id') }}";
                        url = url.replace('#id', id);
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            url: url,
                            type: 'post',
                            success: function() {
                                $('.card_datatable').DataTable().draw();
                            }
                        });
                    }
                });
        }

      
    </script>
@endpush
