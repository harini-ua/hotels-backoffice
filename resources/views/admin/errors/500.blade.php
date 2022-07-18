@extends('admin.layouts.auth')
@section('title',  __('500 | Internal Server Error'))

@section('content')
    <div class="auth-box error-box">
        <!-- Start row -->
        <div class="row no-gutters align-items-center justify-content-center">
            <!-- Start col -->
            <div class="col-md-8 col-lg-6">
                <div class="text-center">
                    <img src="{{ asset('assets/images/error/internal-server.svg') }}" class="img-fluid error-image" alt="500">
                    <h4 class="error-subtitle mb-4">{{ __('500 Internal Server Error') }}</h4>
                    <p class="mb-4">{{ __('The server encountered an internal error or misconfiguration and was unable to complete your request.') }}</p>
                    <a href="{{ url()->previous() }}" class="btn btn-submit font-16"><i class="feather icon-home mr-2"></i> {{ __('Go Back') }}</a>
                </div>
            </div>
            <!-- End col -->
        </div>
        <!-- End row -->
    </div>
@endsection
