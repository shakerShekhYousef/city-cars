@extends('layouts.layout')

@section('content-wrapper')
    <!-- Content Header (Page header) -->

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit driver balance</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Edit driver balance</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    @foreach ($user as $user)
        <section class="content">
            <form method="POST" action="{{ route('balanceupdate', $user->uuid) }}"enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <!-- left column -->

                    <div class="col-md-12">
                        <!-- jquery validation -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">driver balance</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form id="quickForm">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="exampleInput">driver balance:</label>

                                        <input type="number" value="{{ $user->driver_credit }}" name="driver_credit"
                                            step="any" class="form-control" placeholder="driver balance">
                                    </div>



                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>


                        </div>
                        <!-- /.card -->
                    </div>
                </div>
                </div>

            </form>

        </section>
    @endforeach
@endsection
