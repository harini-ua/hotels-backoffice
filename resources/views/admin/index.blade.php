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
        <!-- Start col -->
        <div class="col-lg-12">
            <!-- Start row -->
            <div class="row justify-content-center">
                <!-- Start col -->
                <div class="col-lg-4">
                    <div class="onboard-content text-center my-5">
                        <img src="{{asset('assets/images/ui-onboard/unboard.svg')}}" class="img-fluid mb-5" alt="onboard">
                    </div>
                </div>
            </div>
            <!-- End row -->
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
