@extends('admin.layouts.main')

@section('title',  __('Update Company Site Default'))

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/pages/default-content.css') }}">
@endsection

@section('rightbar-content')
    <div class="contentbar company-default-edit-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <div class="card m-b-30">
                    <div class="card-header">
                        <h5 class="card-title">{{ __('Edit Default Content') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col s12">
                                @include('admin.pages.settings.default-content.partials._form')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('assets/plugins/tinymce/tinymce.min.js') }}"></script>
    <script src="{{asset('js/pages/default-content.js')}}"></script>
@endsection
