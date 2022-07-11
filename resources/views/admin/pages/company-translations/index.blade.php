@extends('admin.layouts.main')

@section('title',  __('Company Site Translation'))

@section('style')
    <link href="{{ asset('assets/plugins/summernote/summernote-bs4.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" type="text/css" href="{{ asset('css/pages/company-translations.css') }}">
@endsection

@section('rightbar-content')
    <div class="contentbar company-translations-edit-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <x-filter
                    title="{{ __('Search Translations') }}"
                    :collapse="false"
                >
                    @include('admin.pages.company-translations.partials._filter')
                </x-filter>
            </div>
            <div class="col-lg-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <div class="row">
                            <div class="col s12" data-pjax>
                                @include('admin.pages.company-translations.partials._form')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('assets/plugins/pjax/jquery.pjax.js') }}"></script>
    <script src="{{ asset('assets/plugins/select2/select2.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/summernote/summernote-bs4.min.js') }}"></script>
    <script src="{{asset('js/pages/company-translations.js')}}"></script>
@endsection
