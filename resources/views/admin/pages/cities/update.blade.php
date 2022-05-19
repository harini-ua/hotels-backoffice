@extends('admin.layouts.main')

@section('title',  __('Update City'))

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/pages/cities.css') }}">
@endsection

@section('rightbar-content')
    <div class="contentbar cities-edit-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <div class="card m-b-30">
                    <div class="card-header">
                        <h5 class="card-title">{{ $city->name }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col s12">
                                @include('admin.pages.cities.partials._form')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{asset('js/pages/cities.js')}}"></script>
@endsection
