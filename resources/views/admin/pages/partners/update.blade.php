@extends('admin.layouts.main')

@section('title',  __('Update Distributor'))

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/pages/partners.css') }}">
@endsection

@section('rightbar-content')
    <div class="contentbar partners-edit-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <div class="card m-b-30">
                    <div class="card-header">
                        <h5 class="card-title">{{ __('Edit Partner') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col s12">
                                @include('admin.pages.partners.partials._form')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{asset('js/pages/partners.js')}}"></script>
@endsection
