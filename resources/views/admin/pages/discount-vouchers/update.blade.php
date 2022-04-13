@extends('admin.layouts.main')

@section('title',  __('Update Discount Voucher'))

@section('style')
    <link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/plugins/datepicker/datepicker.min.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/pages/discount-vouchers.css') }}">
@endsection

@section('rightbar-content')
    <div class="contentbar discount-vouchers-edit-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <div class="card m-b-30">
                    <div class="card-header">
                        <h5 class="card-title">{{ __('Edit Discount Voucher') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col s12">
                            </div>
                            < @include('admin.pages.discount-vouchers.partials._form')
                           /div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('assets/plugins/select2/select2.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap-inputmask/jquery.inputmask.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datepicker/datepicker.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datepicker/i18n/datepicker.en.js') }}"></script>
    <script src="{{asset('js/pages/discount-vouchers.js')}}"></script>
@endsection
