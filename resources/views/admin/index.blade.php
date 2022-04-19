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
        <div class="col-lg-12 col-xl-2 widget-link-wrapper">
            <a class="btn btn-primary link" href="{{ route('statistics.index') }}" role="button">
                <i class="feather icon-file-text"></i> {{ __('Booking Report') }}
            </a>
        </div>
        <div class="col-lg-12 col-xl-2 widget-link-wrapper">
            <a class="btn btn-primary link" href="{{ route('statistics.index') }}" role="button">
                <i class="feather icon-file-text"></i> {{ __('Commission Report') }}
            </a>
        </div>
        <div class="col-lg-12 col-xl-2 widget-link-wrapper">
            <a class="btn btn-primary link" href="{{ route('users.index') }}" role="button">
                <i class="feather icon-users"></i> {{ __('Booking Users') }}
            </a>
        </div>
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
