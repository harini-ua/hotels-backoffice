@extends('admin.layouts.main')

@section('title',  __('Create Admin'))

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/pages/admins.css') }}">
@endsection

@section('rightbar-content')
    <div class="contentbar admins-create-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <div class="card m-b-30">
                    <div class="card-header">
                        <h5 class="card-title">{{ __('Create Admin') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col s12">
                                @include('admin.pages.admins.partials._form')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{asset('js/pages/admins.js')}}"></script>
@endsection
