<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>@yield('title') - {{ config('app.name') }}</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('assets/admin/css/style.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/admin/css/toastr.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/admin/css/sweetalert2.min.css') }}" rel="stylesheet" type="text/css">

    <!-- Add any custom styles in the header -->
    @yield('css-header')
    @yield('css')

    <script>
        var url = "{{ url('') }}/";
        var serverUrl = "{{ url('admin') }}/";
        var app_url = "{{ url('app') }}/";
        var __token = "{{ csrf_token() }}";
        var requestToken = "{{ csrf_token() }}";
    </script>

    <!-- Add any custom scripts in the header -->
    @yield('js-header')
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">
        @include('admin.layouts.sidebar')

        <div id="content-wrapper" class="d-flex flex-column">

            @include('admin.layouts.header')

            <!-- Main Content -->
            <div id="content">
                @yield('content')
            </div>

            @include('admin.layouts.footer')

        </div>
    </div>

    <!-- Footer Scripts -->
    <script src="{{ asset('assets/admin/js/all-scripts.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/custom-plugin.js') }}"></script>

    <!-- Optional Scripts (like toastr or sweetalert, uncomment if needed) -->
    {{-- <script src="{{ asset('assets/admin/js/toastr.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/sweetalert2.all.min.js') }}"></script> --}}

    <!-- Add any custom scripts in the footer -->
    @yield('js-footer')

</body>

</html>
