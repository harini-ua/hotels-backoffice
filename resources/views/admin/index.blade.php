@extends('admin.layouts.main')

@section('title', __('Dashboard'))

@section('style')
<!-- Apex css -->
<link href="{{ asset('assets/plugins/apexcharts/apexcharts.css') }}" rel="stylesheet" type="text/css" />
<!-- jvectormap css -->
<link href="{{ asset('assets/plugins/jvectormap/jquery-jvectormap-2.0.2.css') }}" rel="stylesheet" type="text/css" />
<!-- Slick css -->
<link href="{{ asset('assets/plugins/slick/slick.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/plugins/slick/slick-theme.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('rightbar-content')
<!-- Start Contentbar -->
<div class="contentbar">
    <!-- Start row -->
    <div class="row">
        @foreach($widgets as $widget)
            <div class="col-lg-12 col-xl-2 widget-link-wrapper">
                <a class="btn btn-submit link" href="{{ $widget['route'] }}" role="button">
                    <i class="{{ $widget['icon'] }}"></i> {{ $widget['name'] }}
                </a>
            </div>
        @endforeach
    </div>
    <!-- End row -->
</div>
<!-- End Contentbar -->
@endsection

@section('script')
<!-- Apex js -->
<script src="{{ asset('assets/plugins/apexcharts/apexcharts.min.js') }}"></script>
<script src="{{ asset('assets/plugins/apexcharts/irregular-data-series.js') }}"></script>
<!-- jVector Maps js -->
<script src="{{ asset('assets/plugins/jvectormap/jquery-jvectormap-2.0.2.min.js') }}"></script>
<script src="{{ asset('assets/plugins/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
<!-- Slick js -->
<script src="{{ asset('assets/plugins/slick/slick.min.js') }}"></script>
<!-- Custom Dashboard js -->
<script src="{{ asset('assets/js/custom/custom-dashboard.js') }}"></script>
@endsection
