@extends('admin.layouts.main')

@section('title',  $distributor->name)

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/pages/distributors.css') }}">
@endsection

@section('rightbar-content')
    <div class="contentbar distributors-show-wrapper">

    </div>
@endsection

@section('script')
    <script src="{{asset('js/pages/users.js')}}"></script>
    <script src="{{asset('js/scripts/password.js')}}"></script>
@endsection
