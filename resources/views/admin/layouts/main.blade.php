<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title> {{config('admin.templation.title.prefix')}} {{config('admin.templation.title.separator')}} @yield('title') </title>
        <!-- Favicon -->
        <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">
        <!-- Start CSS -->
        @include('admin.panels.styles')
        <!-- End CSS -->
    </head>
    <body class="horizontal-layout">
        @include('sweetalert::alert')
        <!-- Start Containerbar -->
        <div id="containerbar">
            <!-- Start Rightbar -->
            @include('admin.layouts.rightbar')
            <!-- End Rightbar -->
        </div>
        <!-- End Containerbar -->
        <!-- Start JavaScript -->
        @include('admin.panels.scripts')
        <!-- End JavaScript -->

{{--        <script src="{{ mix('/js/app.js') }}"></script>--}}
{{--        <script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>--}}
{{--        @stack('script')--}}
{{--        @yield('script')--}}
    </body>
</html>
