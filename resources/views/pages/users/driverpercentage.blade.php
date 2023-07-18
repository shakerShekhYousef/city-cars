@extends('layouts.layout')

@section('content-wrapper')
    <!-- Content Header (Page header) -->

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Set Driver Percentage</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Set Driver Percentage</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <section class="content">
        <form method="POST" action="{{ route('driverprcentage.post') }}"enctype="multipart/form-data">
            @csrf

            <div class="row">
                <!-- left column -->

                <div class="col-md-12">
                    <!-- jquery validation -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Set Driver Percentage</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form id="quickForm">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="exampleInputcountry">Driver Percentage:</label>

                                    <input type="number" value="{{ $percentage }}" name="percentage" class="form-control"
                                        placeholder="price" step="0.1" min="0" max="100">
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </form>
    </section>
@endsection
