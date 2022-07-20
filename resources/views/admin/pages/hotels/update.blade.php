@extends('admin.layouts.main')

@section('title',  __('Update Hotel'))

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/pages/hotels.css') }}">
@endsection

@section('rightbar-content')
    <div class="contentbar hotels-edit-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <div class="card m-b-30">
                    <div class="card-header">
                        <h5 class="card-title">{{ $hotel->name }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col s12">
                                @include('admin.pages.hotels.partials._form')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{asset('js/pages/hotels.js')}}"></script>
@endsection
