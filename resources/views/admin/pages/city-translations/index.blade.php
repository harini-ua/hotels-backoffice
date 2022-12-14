@extends('admin.layouts.main')

@section('title',  __('City Translation'))

@section('style')
    <link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" type="text/css" href="{{ asset('css/pages/city-translations.css') }}">
@endsection

@section('rightbar-content')
    <div class="contentbar city-translations-edit-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <x-filter
                    title="{{ __('Search Translations') }}"
                    :collapse="false"
                >
                    @include('admin.pages.city-translations.partials._filter')
                </x-filter>
            </div>
            <div class="col-lg-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <div class="row">
                            <div class="col s12" data-pjax>
                                @include('admin.pages.city-translations.partials._form')
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
    <script src="{{asset('js/pages/city-translations.js')}}"></script>
@endsection
