@extends('admin.layouts.main')

@section('title',  __('Update Partner Product'))

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/pages/partners-products.css') }}">
@endsection

@section('rightbar-content')
    <div class="contentbar partners-products-edit-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <div class="card m-b-30">
                    <div class="card-header">
                        <h5 class="card-title">{{ __('Edit Partner Product') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col s12">
                                @include('admin.pages.partners-products.partials._form')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('assets/plugins/select2/select2.min.js') }}"></script>
    <script src="{{asset('js/pages/partners-products.js')}}"></script>
@endsection
