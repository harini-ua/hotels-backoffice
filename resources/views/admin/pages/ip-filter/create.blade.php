@extends('admin.layouts.main')

@section('title',  __('IP Filter'))

@section('style')
    <link href="{{ asset('assets/plugins/datepicker/datepicker.min.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/pages/ip-filter.css') }}">
@endsection

@section('rightbar-content')
    <div class="contentbar ip-filter-create-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <div class="card m-b-30">
                    <div class="card-header">
                        <h5 class="card-title">{{ __('IP Filter') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col s12">
                                @include('admin.pages.ip-filter.partials._form')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('assets/plugins/bootstrap-inputmask/jquery.inputmask.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datepicker/datepicker.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datepicker/i18n/datepicker.en.js') }}"></script>
    <script src="{{asset('js/pages/ip-filter.js')}}"></script>
@endsection
