@extends('layouts.layout')

@section('content-wrapper')
    <!-- Content Header (Page header) -->

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Car Model</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Edit Car Model</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    @foreach ($carmodel as $carmodel)
        <section class="content">
            <form method="POST" action="{{ route('carmodelsupdate', $carmodel->uuid) }}" enctype="multipart/form-data">
                @csrf


                <div class="container-fluid">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <strong>Whoops!</strong> There were some problems with your input.<br><br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif


                    <div class="row">
                        <!-- left column -->

                        <div class="col-md-12">
                            <!-- jquery validation -->
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Edit Car Model</h3>
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <form id="quickForm">
                                    <div class="card-body">



                                        <div class="form-group">
                                            <label for="exampleInputcountry">Name:</label>

                                            <input type="text" value="{{ $carmodel->name }}" name="name"
                                                class="form-control" placeholder="Name">
                                        </div>

                                        <div class="form-group">
                                            <label class="form-label">Car type:</label>


                                            <select class="form-control" aria-label="Default select example"
                                                name="car_type">
                                                {{-- <option selected>{{ $carmodel['car_type'] }}</option> --}}
                                                @forelse ($cartypes as $cartype)
                                                    {{-- <option value="{{ $carmodel->uuid }}"
                      {{ $carmodel->car_type == $cartype->uuid ? 'selected' : '' }}>
                      {{ $cartype['display_name'] }}
                  </option> --}}
                                                    <option
                                                        {{ $cartype->uuid == $carmodel['car_type'] ? 'selected' : null }}
                                                        value="{{ $cartype->uuid }}">
                                                        {{ $cartype->display_name }}</option>

                                                @empty
                                                    <h6>No car type found</h6>
                                                @endforelse
                                            </select>
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
