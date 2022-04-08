@extends('admin.layouts.auth')
@section('title',  __('404 Not Found'))

@section('content')
    <div class="auth-box error-box">
        <!-- Start row -->
        <div class="row no-gutters align-items-center justify-content-center">
            <!-- Start col -->
            <div class="col-md-8 col-lg-6">
                <div class="text-center">
                    <img src="assets/images/logo.svg" class="img-fluid error-logo" alt="logo">
                    <img src="assets/images/error/404.svg" class="img-fluid error-image" alt="404">
                    <h4 class="error-subtitle mb-4">Oops! Page not Found</h4>
                    <p class="mb-4">We did not find the page you are looking for. Please return to previous page or visit home page. </p>
                    <a href="{{url('/')}}" class="btn btn-primary font-16"><i class="feather icon-home mr-2"></i> Go back to Dashboard</a>
                </div>
            </div>
            <!-- End col -->
        </div>
        <!-- End row -->
    </div>
@endsection
