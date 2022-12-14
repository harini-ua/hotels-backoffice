@extends('admin.layouts.main')

@section('title',  __('Update Provider'))

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/pages/providers.css') }}">
@endsection

@section('rightbar-content')
    <div class="contentbar providers-edit-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <div class="card m-b-30">
                    <div class="card-header">
                        <h5 class="card-title">{{ __('Provider') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col s12">
                                @include('admin.pages.providers.partials._form')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{asset('js/pages/providers.js')}}"></script>
@endsection
