@extends('layouts.layout')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>
@push('styles')
    <link rel="stylesheet" href="css/intlTelInput.css">
    <link rel="stylesheet" href="css/intlTelInput.min.css">

    <script src="js/intlTelInput.js"></script>
    <script src="js/intlTelInput.min.js"></script>
    <!-- Script -->

    <style>
        .iti {
            width: 100%;
            color: #000
        }

        .iti__country-list--dropup {
            bottom: 100%;
            margin-bottom: -1px;
            color: black;
            z-index: 4000;
        }

        .iti-flag {
            background-image: "public/img/flags.png";
        }



        @media(-webkit-min-device-pixel-ratio:2),
        (min-resolution:192dpi) {
            .iti-flag {
                background-image: "public/img/flags@2x.png";
            }
        }

        /* .select2-container{
                                                      display: none;
                                                         } */
    </style>
@endpush
@section('content-wrapper')
    <!-- Content Header (Page header) -->

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Notifications</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">notifications</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <section class="content">
        <div id="alert_div" hidden></div>
        <form id="mainform" class="needs-validation" novalidate method="POST" action="{{ route('submit') }}"
            enctype="multipart/form-data">
            @csrf
            <div class="row">
                <!-- left column -->

                <div class="col-md-12">
                    <!-- jquery validation -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">notifications</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <div class="card-body" style="padding: 2.25rem">

                            <div class="form-group ">
                                <select id="select1" name="user_select" class="form-control">
                                    <option value="1">custom</option>
                                    <option value="2">all users</option>
                                    <option value="3">all driver</option>
                                    <option value="4">all</option>
                                </select>
                            </div>
                            <div class="form-group">

                                <select id='myselect' name="users[]" multiple="multiple" id="select2">
                                    @foreach ($users as $user)
                                        <option value="{{ $user['uuid'] }}">
                                            {{ $user['name'] }}
                                        </option>
                                    @endforeach
                                </select>
                                <input type="text" class="form-control mt-3" placeholder="Enter your message" name="message">
                            </div>

                        </div>

                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </div>
                <!-- /.card -->
            </div>

        </form>
    </section>
    <!-- Main content -->

    <!-- /.content -->
    <script src="js/intlTelInput-jquery.min.js"></script>
    <script src="js/intlTelInput.js"></script>
    <script src="js/intlTelInput.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $('#myselect').select2({
            width: '100%',
            placeholder: "Select an Option",
            allowClear: true
        });


        $("#select1").change(function() {

            if ($(this).val() == "1") {
                $(".select2-container").show();
            } else {
                $(".select2-container").hide();
            }

        });

        $('form').submit(function(e) {
            e.preventDefault();
            $.ajax({
                type: "post",
                url: "{{ route('submit') }}",
                data: $(this).serialize(),
                complete: function(result) {
                    if (result.responseText == 1) {
                        $('#alert_div').attr('hidden', false);
                        $('#alert_div').attr('class', 'alert alert-success');
                        $('#alert_div').html('Notifications has been sended successfully');
                        $('input[name="message"]').val('');
                        setTimeout(
                            function() {
                                $('#alert_div').attr('hidden', true);
                            }, 5000);
                    } else {
                        $('#alert_div').attr('hidden', false);
                        $('#alert_div').attr('class', 'alert alert-danger');
                        $('#alert_div').html(result.responseText);
                        setTimeout(
                            function() {
                                $('#alert_div').attr('hidden', true);
                            }, 5000);
                    }
                }
            });
        });
    </script>
@endsection
