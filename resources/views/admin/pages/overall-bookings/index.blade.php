@extends('admin.layouts.main')

@section('title',  __('Overall Bookings'))

@section('style')
    <link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/plugins/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/plugins/datatables/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/plugins/datatables/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />

    <link href="{{ asset('css/pages/overall-bookings.css') }}" rel="stylesheet" type="text/css">
@endsection

@section('rightbar-content')
    <div class="contentbar overall-bookings-list-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <x-filter>
                    @include('admin.pages.overall-bookings.partials._filter')
                </x-filter>
            </div>
            <div class="col-lg-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <div class="table-responsive">
                            {{ $dataTable->table([], true) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

{{--<tr>--}}
{{--    <th colspan="4" rowspan="2"></th>--}}
{{--    <th colspan="8" class="text-center">Current Year</th>--}}
{{--    <th colspan="8" class="text-center">Previous Year</th>--}}
{{--</tr>--}}
{{--<tr>--}}
{{--    <th colspan="2" class="text-center">Today</th>--}}
{{--    <th colspan="2" class="text-center">This Week</th>--}}
{{--    <th colspan="2" class="text-center">This Month</th>--}}
{{--    <th colspan="2" class="text-center">This Year</th>--}}
{{--    <th colspan="2" class="text-center">Same Day</th>--}}
{{--    <th colspan="2" class="text-center">Same Week</th>--}}
{{--    <th colspan="2" class="text-center">Same Month</th>--}}
{{--    <th colspan="2" class="text-center">Same Year</th>--}}
{{--</tr>--}}

@section('script')
    {{ $dataTable->scripts() }}
    <script src="{{ asset('assets/plugins/select2/select2.min.js') }}"></script>
    <script src="{{asset('js/scripts/datatable.js')}}"></script>
    <script src="{{asset('js/scripts/filters.js')}}"></script>
    <script src="{{asset('js/pages/overall-bookings.js')}}"></script>
@endsection

