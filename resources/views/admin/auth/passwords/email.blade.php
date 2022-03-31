@extends('admin.layouts.auth')

@section('title',  __('Forgot Password'))

@section('content')
    <div class="auth-box forgot-password-box">
        <!-- Start row -->
        <div class="row no-gutters align-items-center justify-content-center">
            <!-- Start col -->
            <div class="col-md-6 col-lg-5">
                <!-- Start Auth Box -->
                <div class="auth-box-right">
                    <div class="card">
                        <div class="card-body">
                            <form action="#">
                                <div class="form-head">
                                    <a href="{{url('/')}}" class="logo"><img src="assets/images/logo.svg" class="img-fluid" alt="logo"></a>
                                </div>
                                <h4 class="text-primary my-4">{{__('Forgot Password')}}</h4>
                                <div class="form-group">
                                    <input type="email" class="form-control" id="email" placeholder="{{__('Email address')}}" required>
                                </div>
                                <button type="submit" class="btn btn-success btn-lg btn-block font-18">{{__('Send Email')}}</button>
                            </form>
                            <p class="mb-0 mt-3">{{__('Remember Password?')}} <a href="{{route('login')}}">{{__('Log in')}}</a></p>
                        </div>
                    </div>
                </div>
                <!-- End Auth Box -->
            </div>
            <!-- End col -->
        </div>
        <!-- End row -->
    </div>
@endsection
