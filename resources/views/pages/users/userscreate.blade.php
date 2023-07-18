@extends('layouts.layout')
@push('styles')
    <link rel="stylesheet" href="css/intlTelInput.css">
    <link rel="stylesheet" href="css/intlTelInput.min.css">
    <script src="js/intlTelInput.js"></script>
    <script src="js/intlTelInput.min.js"></script>
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

    </style>
@endpush
@section('content-wrapper')
    <!-- Content Header (Page header) -->

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Create Admin</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Create Admin</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <section class="content">

        <form id="mainform" class="needs-validation" novalidate method="POST" action="{{ route('usersstore') }}"
            enctype="multipart/form-data">
            @csrf

            <div class="container-fluid">
                <div class="row">
                    <!-- left column -->

                    <div class="col-md-12">
                        <!-- jquery validation -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Create Admin</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <div class="card-body">
                                {{-- <div class="form-group">
                                    <label for="exampleInputname">Name:</label>
                                    <input type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                        value="{{ old('name') }}" name="name" id="exampleInputname" placeholder="Name">
                                    @if ($errors->has('name'))
                                        <span class="error invalid-feedback">
                                            {{ $errors->first('name') }}
                                        </span>
                                    @endif
                                </div> --}}
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Email address:</label>
                                    <input type="email"
                                        class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                        value="{{ old('email') }}" name="email" for="exampleInputEmail1"
                                        placeholder="Email">

                                    @if ($errors->has('email'))
                                        <span class="error invalid-feedback">{{ $errors->first('email') }}</span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="password"
                                        class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="new-password" placeholder="password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">

                                    <label class="form-label" for="validationTooltip02">Confirm Password</label>
                                    <input id="password-confirm" type="password" class="form-control" password
                                        name="password_confirmation" placeholder="Confirm Password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                {{-- <div class="form-group">
                                    <label for="exampleInputcountry">Country Code:</label>

                                    <input class="form-control" type="tel" value="{{ old('country_code', '+971') }}"
                                        name="country_code" id="pphone" minlength="2" maxlength="4" required />
                                </div>
                                <div class="form-group">
                                    <label for="exampleInput">Phone Number:</label>

                                    <input type="number" value="{{ old('phone_number') }}" name="phone_number"
                                        class="form-control" placeholder="Phone Number">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInput">Image:</label>

                                    <input type="file" value="{{ old('image') }}" name="image" class="form-control"
                                        placeholder="image">
                                </div> --}}
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </form>

    </section>
    <!-- Main content -->

    <!-- /.content -->
    <script src="js/intlTelInput-jquery.min.js"></script>
    <script src="js/intlTelInput.js"></script>
    <script src="js/intlTelInput.min.js"></script>
    <script>
        var input = document.querySelector('#phone');
        var countryData = window.intlTelInputGlobals.getCountryData();
        var addressDropdown = document.querySelector("#address-country");
        var iti = window.intlTelInput(input, {
            utilScript: 'js/utils.js'
        });
        // populate the country dropdown
        for (var i = 0; i < countryData.length; i++) {
            var country = countryData[i];
            var optionNode = document.createElement("option");
            optionNode.value = country.iso2;
            var textNode = document.createTextNode(country.name);
            optionNode.appendChild(textNode);
            addressDropdown.appendChild(optionNode);
        }
        // set it's init1al value
        addressDropdown.value = iti.getSelectedCountryData().iso2;

        // listen to the telephone input for changes
        input.addEventListener('countrychange', function(e) {
            addressDropdown.value = iti.getSelectedCountryData().iso2;
        });

        // listen to the address dropdown for changes
        addressDropdown.addEventListener('change', function() {
            iti.setCountry(this.value);
        });
    </script>
    <script>
        var inputt = document.querySelector('#pphone');
        var countryData = window.intlTelInputGlobals.getCountryData();
        var addressDropdow = document.querySelector("#addresss-country");
        var it2 = window.intlTelInput(inputt, {
            utilScript: 'js/utils.js'
        });
        for (var i = 0; i < countryData.length; i++) {
            var country = countryData[i];
            var optionNode = document.createElement("option");
            optionNode.value = country.iso2;
            var textNode = document.createTextNode(country.name);
            optionNode.appendChild(textNode);
            addressDropdow.appendChild(optionNode);
        }

        addressDropdow.value = it2.getSelectedCountryData().iso2;

        // listen to the telephone input for changes
        inputt.addEventListener('countrychange', function(e) {
            addressDropdow.value = it2.getSelectedCountryData().iso2;
        });

        // listen to the address dropdown for changes
        addressDropdow.addEventListener('change', function() {
            it2.setCountry(this.value);
        });
    </script>
@endsection
