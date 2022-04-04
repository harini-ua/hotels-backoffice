@extends('admin.layouts.main')

@section('title',  __('Admins'))

@section('style')
{{--    <!-- Apex css -->--}}
{{--    <link href="{{ asset('assets/plugins/apexcharts/apexcharts.css') }}" rel="stylesheet" type="text/css" />--}}
{{--    <!-- jvectormap css -->--}}
{{--    <link href="{{ asset('assets/plugins/jvectormap/jquery-jvectormap-2.0.2.css') }}" rel="stylesheet" type="text/css" />--}}
{{--    <!-- Slick css -->--}}
{{--    <link href="{{ asset('assets/plugins/slick/slick.css') }}" rel="stylesheet" type="text/css" />--}}
{{--    <link href="{{ asset('assets/plugins/slick/slick-theme.css') }}" rel="stylesheet" type="text/css" />--}}
@endsection

@section('rightbar-content')
    <!-- Start Contentbar -->
    <div class="contentbar">
        <div class="row">
            <div class="col-lg-12">
                <div class="card m-b-30">
{{--                    <div class="card-header">--}}
{{--                        <h5 class="card-title">Default Data Table</h5>--}}
{{--                    </div>--}}
                    <div class="card-body">
{{--                        <h6 class="card-subtitle">With DataTables you can alter the ordering characteristics of the table at initialisation time.</h6>--}}
                        <div class="table-responsive">
                            {{ $dataTable->table() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Contentbar -->
@endsection

@section('script')
{{--    <!-- Apex js -->--}}
{{--    <script src="{{ asset('assets/plugins/apexcharts/apexcharts.min.js') }}"></script>--}}
{{--    <script src="{{ asset('assets/plugins/apexcharts/irregular-data-series.js') }}"></script>--}}
{{--    <!-- jVector Maps js -->--}}
{{--    <script src="{{ asset('assets/plugins/jvectormap/jquery-jvectormap-2.0.2.min.js') }}"></script>--}}
{{--    <script src="{{ asset('assets/plugins/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>--}}
{{--    <!-- Slick js -->--}}
{{--    <script src="{{ asset('assets/plugins/slick/slick.min.js') }}"></script>--}}
{{--    <!-- Custom Dashboard js -->--}}
{{--    <script src="{{ asset('assets/js/custom/custom-dashboard.js') }}"></script>--}}
{{--    <script src="../../../../../node_modules/datatables.net/js/jquery.dataTables.min.js"></script>--}}
    {{ $dataTable->scripts() }}
@endsection

