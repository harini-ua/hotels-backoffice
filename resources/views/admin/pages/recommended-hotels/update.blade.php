@extends('admin.layouts.main')

@section('title',  __('Edit Recommended Hotel'))

@section('style')
    <link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/pages/recommended-hotels.css') }}">
@endsection

@section('rightbar-content')
    <div class="contentbar recommended-hotels-edit-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <div class="card m-b-30">
                    <div class="card-header">
                        <h5 class="card-title">{{ __('Edit Recommended Hotel') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col s12">
                                @include('admin.pages.recommended-hotels.partials._form')
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
    <script src="{{asset('js/pages/recommended-hotels.js')}}"></script>
@endsection
