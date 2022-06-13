@extends('admin.layouts.main')

@section('title',  __('Booking VAT'))

@section('style')
    <link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/plugins/datepicker/datepicker.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/plugins/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/plugins/datatables/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/plugins/datatables/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />

    <link href="{{ asset('css/pages/booking-vat.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('rightbar-content')
    <div class="contentbar report-booking-vat-list-datatable">
        <div class="row">
            <div class="col-lg-12">
                <x-filter
                    title="{{ __('Quick Filter') }}"
                    :collapse="false"
                >
                    @include('admin.pages.booking-customer.partials._quick-filter')
                </x-filter>
            </div>
            <div class="col-lg-12">
                <x-filter
                    title="{{ __('Advanced Filter') }}"
                >
                    @include('admin.pages.booking-customer.partials._advanced-filter')
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

@section('script')
    @include('admin.datatables.datatable-scripts')
    {{ $dataTable->scripts() }}
    <script src="{{ asset('assets/plugins/select2/select2.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datepicker/datepicker.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datepicker/i18n/datepicker.en.js') }}"></script>
    <script src="{{asset('js/scripts/datatable.js')}}"></script>
    <script src="{{asset('js/scripts/filters.js')}}"></script>
    <script src="{{asset('js/pages/booking-vat.js')}}"></script>
@endsection

