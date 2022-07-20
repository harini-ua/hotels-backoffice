@extends('admin.layouts.auth')

@section('title',  __('Two Factor Authentication'))

@section('content')
    <div class="auth-box login-box">
        <div class="row no-gutters align-items-center justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="auth-box-right">
                    <div class="card">
                        <div class="card-body">
                            <form method="POST" action="{{ route('two-factor.login') }}">
                                @csrf
                                <div class="form-group">
                                    <a href="{{route('home')}}" class="logo"><img src="{{asset('images/admin/logo_hotels_online.png')}}" class="img-fluid" alt="logo"></a>
                                </div>
                                <div class="form-group">
                                    <p>{{ __('Please enter your authentication code to login.') }}</p>
                                    <input
                                        type="text"
                                        class="form-control @error('code'){{'is-invalid'}}@enderror"
                                        id="code"
                                        name="code"
                                        placeholder="{{__('Code')}}"
                                        autocomplete="current-code"
                                        required
                                        autofocus
                                    >
                                    @error('code')<small class="red-text invalid-feedback" role="alert">{{ $message }}</small>@enderror
                                </div>
                                <button type="submit" class="btn btn-submit btn-lg btn-block font-18">{{__('Submit')}}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
