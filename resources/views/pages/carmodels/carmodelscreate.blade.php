@extends('layouts.layout')

@section('content-wrapper')
    <!-- Content Header (Page header) -->

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Create Car Model</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Create Car Model</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <section class="content">
        <form method="POST" action="{{ route('carmodelsstore') }}"enctype="multipart/form-data">
            @csrf

            <div class="container-fluid">
                <div class="row">
                    <!-- left column -->

                    <div class="col-md-12">
                        <!-- jquery validation -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Create Car Model</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form id="quickForm">
                                <div class="card-body">



                                    <div class="form-group">
                                        <label for="exampleInputcountry">Name:</label>

                                        <input type="text" value="{{ old('name') }}" name="name"
                                            class="form-control" placeholder=" Name">
                                    </div>

                                    <label for="exampleInputcountry">Car type:</label>


                                    <select class="form-control" aria-label="Default select example" name="car_type"
                                        required>
                                        <option value="{{ old('car_type') }}">Select car type</option>
                                        @forelse ($cartypes as $cartype)
                                            <option value="{{ $cartype->uuid }}">{{ $cartype->display_name }}</option>

                                        @empty
                                            <h6>No cartypes found</h6>
                                        @endforelse
                                    </select>


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
            </div>

        </form>

    </section>

@endsection
