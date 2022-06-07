@extends('admin.layouts.auth')

@section('title',  __('Login'))

@section('content')
    <div class="auth-box login-box">
        <!-- Start row -->
        <div class="row no-gutters align-items-center justify-content-center">
            <!-- Start col -->
            <div class="col-md-6 col-lg-5">
                <!-- Start Auth Box -->
                <div class="auth-box-right">
                    <div class="card">
                        <div class="card-body">
                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="form-group">
                                    <a href="{{route('home')}}" class="logo"><img src="{{asset('images/admin/logo_hotels_online.png')}}" class="img-fluid" alt="logo"></a>
                                </div>
                                <div class="form-group">
                                    <input
                                        type="text"
                                        class="form-control @error('username'){{'is-invalid'}}@enderror"
                                        id="email"
                                        name="email"
                                        placeholder="{{__('Email')}}"
                                        required
                                        autocomplete="email"
                                        autofocus
                                    >
                                    @error('username')<small class="red-text" role="alert">{{ $message }}</small>@enderror
                                </div>
                                <div class="form-group">
                                    <input
                                        type="password"
                                        class="form-control @error('password'){{'is-invalid'}}@enderror"
                                        id="password"
                                        name="password"
                                        placeholder="{{__('Password')}}"
                                        required
                                    >
                                    @error('password')<small class="red-text" role="alert">{{ $message }}</small>@enderror
                                </div>
                                <div class="form-row mb-3">
                                    <div class="col-sm-6">
                                        <div class="custom-control custom-checkbox text-left">
                                            <input type="checkbox" class="custom-control-input" id="rememberme" {{ old('remember') ? 'checked' : '' }}>
                                            <label class="custom-control-label font-14" for="rememberme">{{__('Remember Me')}}</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="forgot-psw">
                                            <a id="forgot-psw" href="{{route('password.request')}}" class="font-14">{{__('Forgot Password?')}}</a>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-submit btn-lg btn-block font-18">{{__('Log in')}}</button>
                            </form>
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
