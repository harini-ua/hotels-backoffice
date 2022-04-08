@extends('admin.layouts.main')

@section('title',  $distributor->name)

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/pages/companies.css') }}">
@endsection

@section('rightbar-content')
    <div class="contentbar companies-show-wrapper">

    </div>
@endsection

@section('script')
    <script src="{{asset('js/pages/companies.js')}}"></script>
    <script src="{{asset('js/scripts/password.js')}}"></script>
@endsection
