<!DOCTYPE html>
<html lang="en">

@include('layouts.header')

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- Navbar -->
        @include('layouts.navbar')
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        @include('layouts.sidebar')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            @if (session()->has('error'))
                <div class="alert alert-danger">{{ session()->get('error') }}</div>
            @elseif (session()->has('errors'))
                @foreach ($errors->all() as $item)
                    <div class="alert alert-danger">
                        {{ $item }}
                    </div>
                @endforeach
            @elseif (session()->has('success'))
                <div class="alert alert-success">{{ session()->get('success') }}</div>
            @endif
            @yield('content-wrapper')
        </div>

        <!-- Main Footer -->
        @include('layouts.footer')
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->
    @include('layouts.scripts')
</body>

</html>
