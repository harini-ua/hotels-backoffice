@extends('admin.layouts.main')

@section('title',  __('Resort Fee Translation'))

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/pages/resort-fee-translations.css') }}">
@endsection

@section('rightbar-content')
    <div class="contentbar resort-fee-translations-edit-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <x-filter
                    title="{{ __('Search Translations') }}"
                    :collapse="false"
                >
                </x-filter>
            </div>
            <div class="col-lg-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <div class="row">
                            <div class="col s12" data-pjax>
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
    <script src="{{asset('js/pages/resort-fee-translations.js')}}"></script>
@endsection
