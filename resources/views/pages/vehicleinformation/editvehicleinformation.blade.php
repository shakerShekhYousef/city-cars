@extends('layouts.layout')

@section('content-wrapper')
    <!-- Content Header (Page header) -->

    <section class="content-header">
        <div class="container-fluid">

            <div class="row mb-2">
                <div class="col-sm-6">
                    <div class="form-group">

                    </div>
                </div>

                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">edit vehicle information</li>
                    </ol>
                </div>
            </div>

        </div><!-- /.container-fluid -->
    </section>
    <section class="content">
        <!-- Default box -->
        <div class="card card-solid">
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <h3 class="my-3">Vehicle information</h3>
                        <hr>
                        <form method="POST" action="{{ route('updatevehicleinfo', $vehicleinformation->driver_id) }}"
                            enctype="multipart/form-data">
                            @csrf
                            <label for="">Car Model</label>
                            <select name="car_model" id="" class="form-control">
                                @foreach ($models as $model)
                                    <option {{ $model->uuid == $vehicleinformation->carModel ? 'active' : null }}
                                        value="{{ $model->uuid }}">{{ $model->name }}</option>
                                @endforeach
                            </select>
                            <hr>
                            {{-- <input class="form-control" type="text" name="car_model" id="color_option_b1"
                                autocomplete="off"
                                value="{{ $vehicleinformation->carModel != null ? $vehicleinformation->carModel->name : null }}">
                            <hr> --}}
                            {{-- <h4>Available Colors</h4> --}}
                            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                <label class="btn btn-default text-center active">Available Colors
                                    <hr>
                                    <select class="form-control" name="color_option" id="color_option_a1">
                                        <option value=""></option>
                                        <option value="#F44336">RED</option>
                                        <option value="#E91E63">Pink</option>
                                        <option value="#9C27B0">Purble</option>
                                        <option value="#673AB7">Darkpurble</option>
                                        <option value="#3F51B5">DarkBlue</option>
                                        <option value="#2196F3">Blue</option>
                                        <option value="#03A9F4">LightBlue</option>
                                        <option value="#00BCD4">Turquoise</option>
                                        <option value="#009688">DarkGreen</option>
                                        <option value="#4CAF50">Green</option>
                                        <option value="#8BC34A">LightGreen</option>
                                        <option value="#CDDC39">Phosphoric</option>
                                        <option value="#FFEB3B">Yellow</option>
                                        <option value="#FFC107">LightOrange</option>
                                        <option value="#FF9800">Orange</option>
                                        <option value="#FF5722">Drk</option>
                                        <option value="#795548">Brown</option>
                                        <option value="#9E9E9E">Gray</option>
                                        <option value="#607D8B">DarkGray</option>
                                        <option value="#000000">Black</option>
                                    </select>
                                    {{-- <input type="color" name="color_option" id="color_option_a1" autocomplete="off"
                                        value="{{ $vehicleinformation->car_color }}"> --}}
                                    <br>
                                    <div id="show_color" style="width: 100px;color: white">######</div>
                                </label>
                            </div>
                            <hr>
                            <div>
                             @foreach ($driverinformations as $driverinformation)

                            <label for="">License Plate Front Photo:</label>
                            <input type="file" name="drive_license_front_photo"  class="form-control"  value="{{ $driverinformation->drive_license_front_photo }}" id="drive_license_front_photo">
                            <img src="{{  asset($driverinformation->drive_license_front_photo)}}" width="80">
                            
                            </div>
                            <hr>
                            <div>
                            <label for="">License Plate Back photo:</label>
                            <input type="file" name="drive_license_back_photo" class="form-control" id="drive_license_back_photo">
                            <img src="{{  asset($driverinformation->drive_license_back_photo) }}" width="80">

                            </div>
                            <hr>
                            <div>
                            <label for="">No Criminal Record: </label>
                            <input type="file" name="no_criminal_record" class="form-control" id="no_criminal_record">
                            <img src="{{  asset($driverinformation->no_criminal_record) }}" width="80">

                            </div>
                            <hr>
                            <div>
                            <label for="">Health Certificate:</label>
                            <input type="file" name="health_certificate" class="form-control" id="health_certificate">
                            <img src="{{ asset($driverinformation->health_certificate) }}" width="80">

                            </div>
                            <hr>
                            <div>
                            <label for="">Id Photo:</label>
                            <input type="file" name="id_photo" class="form-control" id="id_photo">
                            <img src="{{ asset($driverinformation->id_photo) }}" width="80">

                            </div>
                            <hr>
                            @endforeach
                            {{-- <input type="file" name="licenc_plate" class="form-control" id="licenc_plate"> --}}

                            {{-- <input class="form-control" type="text" name="licenc_plate" id="licenc_plate"
                                autocomplete="off" value="{{ $vehicleinformation->license_plate }}"> --}}
                            <div class="col-md-6 mt-3">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>
                        {{-- <a href="{{ asset($vehicleinformation->license_plate) }}" target="blank"><img
                                src="{{ asset($vehicleinformation->license_plate) }}" alt="hello" height="200"
                                width="200"></a> --}}
                        {{-- <a href="" target="blank"><img src="" alt="hello1" height="200" width="200"></a> --}}
                    </div>
                
        </div>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </section>
    <!-- jQuery -->
    <script src="../../plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../../dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="../../dist/js/demo.js"></script>
    <script>
        $(document).ready(function() {
            $('.product-image-thumb').on('click', function() {
                var $image_element = $(this).find('img')
                $('.product-image').prop('src', $image_element.attr('src'))
                $('.product-image-thumb.active').removeClass('active')
                $(this).addClass('active')
            })
        })

        $('#color_option_a1').change(function() {
            $('#show_color').css('background-color', $(this).val()).text($(this).val());
        });
    </script>
@endsection
