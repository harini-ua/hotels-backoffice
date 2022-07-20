@extends('admin.layouts.auth')

@section('title',  __('Confirm Password'))

@section('content')
    <div class="auth-box login-box">
        <div class="row no-gutters align-items-center justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="auth-box-right">
                    <div class="card">
                        <div class="card-body">
                            <form method="POST" action="{{ route('password.confirm') }}">
                                @csrf
                                <div class="form-group">
                                    <a href="{{route('home')}}" class="logo"><img src="{{asset('images/admin/logo_hotels_online.png')}}" class="img-fluid" alt="logo"></a>
                                </div>
                                <div class="form-group">
                                    <p>{{ __('Please confirm your password before continuing.') }}</p>
                                    <input
                                        type="password"
                                        class="form-control @error('password'){{'is-invalid'}}@enderror"
                                        id="password"
                                        name="password"
                                        placeholder="{{__('Password')}}"
                                        required
                                        autocomplete="current-password"
                                        autofocus
                                    >
                                    @error('password')<small class="red-text invalid-feedback" role="alert">{{ $message }}</small>@enderror
                                </div>
                                <button type="submit" class="btn btn-submit btn-lg btn-block font-18">{{__('Confirm Password')}}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
