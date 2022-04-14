@extends('admin.layouts.main')

@section('title',  __('Company Sites'))

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/pages/companies.css') }}">
@endsection

@section('rightbar-content')
    <div class="contentbar companies-list-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <x-filter>
                    @include('admin.pages.companies.partials._filter')
                </x-filter>
            </div>
            <div class="col-lg-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <div class="table-responsive">
                            {{ $dataTable->table() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    {{ $dataTable->scripts() }}
    <script src="{{asset('js/pages/companies.js')}}"></script>
    <script src="{{asset('js/scripts/datatable.js')}}"></script>
    <script src="{{asset('js/scripts/filters.js')}}"></script>
@endsection
