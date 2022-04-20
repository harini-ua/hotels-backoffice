@extends('admin.layouts.main')

@section('title',  __('Update Company Site Default'))

@section('style')

@endsection

@section('rightbar-content')
    <div class="contentbar company-default-edit-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <div class="card m-b-30">
                    <div class="card-header">
                        <h5 class="card-title">{{ __('Edit Company Site Default') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col s12">
                                @include('admin.pages.settings.company-default.partials._form')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('assets/plugins/tinymce/tinymce.min.js') }}"></script>
    <script src="{{asset('js/pages/company-default.js')}}"></script>
@endsection
