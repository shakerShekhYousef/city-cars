@extends('layouts.layout')

@section('content-wrapper')
    <!-- Content Header (Page header) -->

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Create Car Type</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Create Car Type</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <section class="content">
        <form method="POST" action="{{ route('cartypesstore') }}"enctype="multipart/form-data">
            @csrf

            <div class="container-fluid">
                <div class="row">
                    <!-- left column -->

                    <div class="col-md-12">
                        <!-- jquery validation -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Create Car Type</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form id="quickForm">
                                <div class="card-body">



                                    <div class="form-group">
                                        <label for="exampleInputcountry">Display Name:</label>

                                        <input type="text" value="{{ old('display_name') }}" name="display_name"
                                            class="form-control" placeholder="Display Name">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInput">Capacity:</label>

                                        <input type="text" value="{{ old('capacity') }}" name="capacity"
                                            class="form-control" placeholder="Capacity">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInput">Cost Per Minute:</label>

                                        <input type="number" value="{{ old('cost_per_minute') }}" name="cost_per_minute"
                                            class="form-control" placeholder="Cost Per Minute" step="0.01" min="0" max="100">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInput">Cost Per KM:</label>

                                        <input type="number" value="{{ old('cost_per_km') }}" name="cost_per_km"
                                            class="form-control" placeholder="Cost Per KM" step="0.01" min="0" max="100">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInput">Cancellation Fee:</label>

                                        <input type="number" value="{{ old('cancellation_fee') }}" name="cancellation_fee"
                                            class="form-control" placeholder="Cancellation Fee" step="0.01" min="0" max="100">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInput">Initial Fee:</label>

                                        <input type="number" value="{{ old('initial_fee') }}" name="initial_fee"
                                            class="form-control" placeholder="Initial Fee" step="0.01" min="0" max="100">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInput">Description:</label>

                                        <input type="text" value="{{ old('description') }}" name="description"
                                            class="form-control" placeholder="Description">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInput">Image:</label>

                                        <input type="file" value="{{ old('image') }}" name="image"
                                            class="form-control" placeholder="image" required>
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
            </div>

        </form>
    </section>

@endsection
