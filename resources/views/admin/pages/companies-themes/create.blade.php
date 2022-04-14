@extends('admin.layouts.main')

@section('title',  __('Create Company Theme'))

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/pages/companies-themes.css') }}">
@endsection

@section('rightbar-content')
    <div class="contentbar companies-themes-create-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <div class="card m-b-30">
                    <div class="card-header">
                        <h5 class="card-title">{{ __('Company Theme') }}</h5>
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
    <script src="{{asset('js/pages/companies-themes.js')}}"></script>
@endsection
