@extends('layouts.layout')

@section('content-wrapper')
    <!-- Content Header (Page header) -->

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Contact Us</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Contact Us</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <section class="content">
        <div id="alert_div" hidden></div>
        <form id="form_about">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Contact Us</h3>
                        </div>
                        <div class="card-body" style="padding: 2.25rem">
                            <label  class="form-label mt-1">English Contact Us </label>
                            <textarea class="form-control" name="contact_us_en"  col="30" rows="5">@if($contactus)@if($contactus->contact_us_en){{$contactus->contact_us_en}}@else Enter English Contact Us  @endif @else Enter English Contact Us @endif</textarea>
                            <label  class="form-label mt-4">Arabic Contact Us </label>
                            <textarea dir="rtl" style="text-align: right" class="form-control" name="contact_us_ar"  cols="30" rows="5">@if($contactus)@if($contactus->contact_us_ar){{$contactus->contact_us_ar}}@else Enter Arabic Contact Us  @endif @else Enter Arabic Contact Us @endif</textarea>

                        </div>

                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="button" class="btn btn-primary Update">Update</button>
                        </div>
                    </div>
                </div>
                <!-- /.card -->
            </div>

        </form>
    </section>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function(){
            $('.Update').click(function(e) {
                e.preventDefault();
                var formdata=new FormData($('#form_about')[0]);
                formdata.append("_token", "{{ csrf_token() }}");
                $.ajax({
                    method: "post",
                    dataType:"json",
                    processData: false,
                    contentType: false,
                    cache: false,
                    url: "{{ route('contactusupdate') }}",
                    data:formdata,
                    success: function(result) {
                        if (result.status) {
                            $('#alert_div').empty();
                            $('#alert_div').attr('hidden', false);
                            $('#alert_div').attr('class', 'alert alert-success');
                            $('#alert_div').append('<p>'+result.message+'</p>');

                        } else{
                            $('#alert_div').empty();
                            $.each(result.error, function(key,value ){
                                $('#alert_div').attr('hidden', false);
                                $('#alert_div').attr('class', 'alert alert-danger');
                  			    $('#alert_div').append('<p>'+value+'</p>');
                  		    });
                        }
                    },
                });
            });
        });

    </script>
@endsection
