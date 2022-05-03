@extends('admin.layouts.main')

@section('title',  __('Create Popular Hotel'))

@section('style')
    <link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/pages/popular-hotels.css') }}">
@endsection

@section('rightbar-content')
    <div class="contentbar popular-hotels-create-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <div class="card m-b-30">
                    <div class="card-header">
                        <h5 class="card-title">{{ __('New Popular Hotel') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col s12">
                                @include('admin.pages.popular-hotels.partials._form')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('assets/plugins/jquery-bar-rating/jquery.barrating.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/select2/select2.min.js') }}"></script>
    <script src="{{asset('js/pages/popular-hotels.js')}}"></script>
@endsection
