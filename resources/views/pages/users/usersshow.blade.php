@extends('layouts.layout')

@section('content-wrapper')
    <!-- Content Header (Page header) -->
    @foreach ($user as $user)
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
                            <li class="breadcrumb-item active">User view</li>
                        </ol>
                    </div>
                </div>

            </div><!-- /.container-fluid -->
        </section>
        <section class="content" style="margin: inherit;">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-8">

                        <!-- Profile Image -->
                        <div class="card card-primary card-outline">
                            <div class="card-body box-profile" style="padding-left: 2.5rem;">
                                <div class="text-center">


                                    {{-- src="{{ asset($user->image) }}"
                         alt="User profile picture"> --}}
                                    {{-- <a href="storage/users/user_images/{{ $user->image }}" target="_blank"> --}}
                                    <img class="profile-user-img img-fluid img-circle" style="width:25%"
                                        src="{{ isset($user->image) ? asset($user->image) : asset('storage/users/user_images/user.png') }}">
                                    {{-- <a href="/user_images/{{ asset($user->image) }}" target="_blank"><img src="/user_images{{ asset($user->image) }}" alt="" width="100px" height="100px"></a> --}}

                                </div>

                                <h3 class="profile-username text-center">{{ $user->name }}</h3>



                                <ul class="list-group list-group-unbordered mb-3">
                                    <li class="list-group-item">
                                        <strong>Name:</strong>
                                        {{ $user->name }}
                                    </li>
                                    <li class="list-group-item">
                                        <strong>email:</strong>
                                        {{ $user->email }}
                                    </li>
                                    <li class="list-group-item">
                                        <strong>country code:</strong>
                                        {{ $user->country_code }}
                                    </li>
                                    <li class="list-group-item">
                                        <strong>phone number:</strong>
                                        {{ $user->phone_number }}
                                    </li>
                                    <li class="list-group-item">
                                        <strong>role:</strong>
                                        {{ $user->role }}
                                    </li>
                                    <li class="list-group-item">
                                        <strong>account type:</strong>
                                        {{ $user->account_type }}
                                    </li>
                                    <li class="list-group-item">
                                        <strong>long:</strong>
                                        {{ $user->long }}
                                    </li>
                                    <li class="list-group-item">
                                        <strong>lat:</strong>
                                        {{ $user->lat }}
                                    </li>

                                </ul>

                                {{-- <a href="{{ route('vehicleinformationshow',$user->uuid)}}" class="btn btn-primary"><b>Show Vehicle Information</b></a> --}}

                                <form action="{{ route('user.user_verified', $user->uuid) }}" method="post">@csrf
                                    @if ($user->role == 'Driver')
                                        <a href="{{ route('vehicleinformationshow', $user->uuid) }}"
                                            class="btn btn-primary"><b>Show Vehicle Information</b></a>
                                        <button name="user_verified" value="1" class="btn btn-success"
                                            style="margin-left: 9rem" <?php if($user->user_verified==1){ ?> hidden
                                            <?php } ?>>Verify</button>
                                    @endif

                                    <td>

                                    </td>
                                </form>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </div>
        </section>
        <!-- Main content -->

        <!-- /.content -->
        </div>
    @endforeach
@endsection
