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
                        <li class="breadcrumb-item active">vehicle information</li>
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
                        <h3 class="d-inline-block d-sm-none"></h3>
                        <div class="col-12">
                            <img class="product-image" alt="car Image"
                                src="{{ asset($vehicleinformation->front_image) }}">
                        </div>
                        <div class="col-12 product-image-thumbs">
                            <div class="product-image-thumb active">
                                <img src="{{ asset($vehicleinformation->front_image) }}">
                            </div>
                            <div class="product-image-thumb">
                                <img src="{{ asset($vehicleinformation->back_image) }}">
                            </div>
                            <div class="product-image-thumb">
                                <img src="{{ asset($vehicleinformation->right_image) }}">
                            </div>
                            <div class="product-image-thumb">
                                <img src="{{ asset($vehicleinformation->left_image) }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                        <h3 class="my-3">Vehicle information</h3>
                        <hr>
                        <ul class="nav nav-tabs">
                            <li class="nav-item"><a href="#car_model" data-toggle="tab" class="nav-link active show">Car Model</a></li>
                            <li class="nav-item"><a href="#car_color" data-toggle="tab" class="nav-link">Available Colors</a></li>
                            <li class="nav-item"><a href="#drive_license" data-toggle="tab" class="nav-link">License Plate</a></li>
                            <li class="nav-item"><a href="#no_criminal_record" data-toggle="tab" class="nav-link">No Criminal Record</a></li>
                            <li class="nav-item"><a href="#health_certificate" data-toggle="tab" class="nav-link">Health Certificate</a></li>
                            <li class="nav-item"><a href="#id_photo" data-toggle="tab" class="nav-link">Id Photo</a></li>

                        </ul>
                        <div class="tab-content">
                            <div id="car_model" class="tab-pane fade active show">
                                <div class="car_model_input">
                                    <div class="pt-4 border-bottom-1 pb-4">
                                        <h2 class="mb-0 mt-3">
                                        
                                {{-- <input type="text" name="car-model" id="color_option_b1" autocomplete="off"> --}}
                                {{ $vehicleinformation->carModel != null ? $vehicleinformation->carModel->name : null }}
                              
                               </h2>
                               <hr>
                              </div>
                             </div>
                            </div>
                    
                       
                        <div id="car_color" class="tab-pane fade">
                            <div class="car_color-content pt-3">
                                    <div class="pt-4 border-bottom-1 pb-4">
                                        <h2 class="mb-0 mt-3">
                            <label class="btn btn-default text-center active" style="background-color: {{ $vehicleinformation->car_color }}">
                                <br>
                                {{-- <i class="fas fa-circle fa-2x text-{{ $vehicleinformation->car_color }}"></i> --}}
                            </label>
                             </h2>
                             <hr>

                              </div>
                             </div>
                            </div>
                          
                        @foreach ($driverinformations as $driverinformation)
                        <div id="drive_license" class="tab-pane fade">
                            <div class="drive_license-content pt-3">
                                <div class="drive_license_input">
                                    
                                    <div class="bg-white py-1 px-3 mt-4">
                                        <img src="{{ asset($driverinformation->drive_license_front_photo) }}" alt="" width="200"
                                            height="200">
                                            <img src="{{ asset($driverinformation->drive_license_back_photo) }}" alt="" width="200"
                                            height="200">
            
                                          </div>
                                         </div>
                                        </div>
                                    </div>

                        <div id="no_criminal_record" class="tab-pane fade">
                            <div class="no_criminal_record-content pt-3">
                                <div class="no_criminal_record_input">
                                    
                            
                            <div class="bg-white py-1 px-3 mt-4">
                                <img src="{{ asset($driverinformation->no_criminal_record) }}" alt="" width="200"
                                    height="200">
                                
                                       </div>
                                      </div>
                                     </div>
                                 </div>
                        <div id="health_certificate" class="tab-pane fade">
                            <div class="health_certificate-content pt-3">
                                <div class="health_certificate_input">
                                    
                               <div class="bg-white py-1 px-3 mt-4">
                            
                                <img src="{{ asset($driverinformation->health_certificate) }}" alt="" width="200"
                                height="200">
            
                                  </div>
                                 </div>
                                </div>
                            </div>


                        <div id="id_photo" class="tab-pane fade">
                            <div class="id_photo-content pt-3">
                                <div class="id_photo_input">
                                    
                            <div class="bg-white py-1 px-3 mt-4">
                                <img src="{{ asset($driverinformation->id_photo) }}" alt="" width="200"
                                height="200">
    
                                    </div>
                                  </div>
                                 </div>
                                </div>

                        <div class="col-md-6 mt-3">
                            <a href="{{ route('editvehicleinfo', $vehicleinformation->driver_id) }}"
                                class="btn btn-primary">Edit</a>
                        </div>
                        @endforeach

                        </div>
                    </div> 
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
    </script>
@endsection