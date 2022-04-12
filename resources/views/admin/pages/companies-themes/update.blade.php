@extends('admin.layouts.main')

@section('title',  __('Update Theme'))

@section('style')
    <link href="{{ asset('assets/plugins/colorpicker/bootstrap-colorpicker.css') }}" rel="stylesheet" type="text/css">
@endsection

@section('rightbar-content')
    <div class="contentbar distributors-edit-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <div class="card m-b-30">
                    <div class="card-header">
                        <h5 class="card-title">{{ __('Edit Theme') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col s12">
                                @include('admin.pages.companies-themes.partials._form')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('assets/plugins/colorpicker/bootstrap-colorpicker.js') }}"></script>
    <script src="{{ asset('assets/js/custom/custom-form-colorpicker.js') }}"></script>
@endsection
