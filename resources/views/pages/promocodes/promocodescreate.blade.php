@extends('layouts.layout')

@push('styles')
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
@endpush

@section('content-wrapper')
    <!-- Content Header (Page header) -->

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Create Promo Code</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Create Promo Code</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <section class="content">
        <form method="POST" action="{{ route('promocodesstore') }}"enctype="multipart/form-data">
            @csrf
            <div class="row">
                <!-- left column -->

                <div class="col-md-12">
                    <!-- jquery validation -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Create Promo Code</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form id="quickForm">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="exampleInputcountry">Promo Code:</label>

                                    <input type="text" value="{{ old('promo_code') }}" name="promo_code"
                                        class="form-control" placeholder="promo code" required>
                                </div>
                                <div class="form-group">

                                    <label for="exampleInputcountry">Type:</label>

                                    <select class="form-control" aria-label="Default select example" name="type"
                                        required>
                                        <option value="" selected>Select Type</option>
                                        <option value="value" {{ old('type') == 1 ? 'selected' : '' }}>value</option>
                                        <option value="percentage" {{ old('type') == 2 ? 'selected' : '' }}>percentage
                                        </option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputcountry">Value:</label>

                                    <input type="number" value="{{ old('value') }}" name="value" class="form-control"
                                        placeholder="value" required>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputcountry">Expiry Date:</label>

                                    <input type="text" value="{{ old('expiry_date') }}" name="expiry_date"
                                        class="form-control datepicker pl-3" placeholder="expiry date" required>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputcountry">Usage Limit:</label>

                                    <input type="number" value="{{ old('usage_limit') }}" name="usage_limit"
                                        class="form-control" placeholder="usage limit" required>
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

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script>
        jQuery(function() {
            var datepicker = $('input.datepicker');

            if (datepicker.length > 0) {
                datepicker.datepicker({
                    format: "yyyy-mm-dd",
                    startDate: new Date()
                });
            }
        });
    </script>
@endpush
