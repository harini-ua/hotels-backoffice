@extends('admin.layouts.main')

@section('title',  __('My Profile'))

@section('style')

@endsection

@section('rightbar-content')
    <div class="contentbar profile-edit-wrapper">
        <div class="row">
            <div class="col-lg-6">
                <div class="card m-b-30">
                    <div class="card-header">
                        <h5 class="card-title">{{ __('Edit Profile') }}</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('user-profile-information.update') }}">
                            @csrf
                            @method('PUT')
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-4 col-form-label">{{ __('User Name') }}</label>
                                <div class="col-sm-8">
                                    <input type="text" name="username" value="{{ old('title') ?? $user->title }}" class="form-control @error('title') is-invalid @enderror">
                                    @error('username')
                                    <small class="form-text text-danger" role="alert">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            @if($canEdit)
                                <div class="form-group row">
                                    <label for="current_password" class="col-sm-4 col-form-label">{{ __('Old Password') }}</label>
                                    <div class="col-sm-8">
                                        <input type="password" name="current_password" class="form-control @error('current_password') is-invalid @enderror">
                                        @error('password')
                                        <small class="form-text text-danger" role="alert">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="new_password" class="col-sm-4 col-form-label">{{ __('New Password') }}</label>
                                    <div class="col-sm-8">
                                        <input type="password" name="new_password" class="form-control @error('new_password') is-invalid @enderror">
                                        @error('new_password')
                                        <small class="form-text text-danger" role="alert">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="confirm_password" class="col-sm-4 col-form-label">{{ __('Confirm Password') }}</label>
                                    <div class="col-sm-8">
                                        <input type="password" name="confirm_password" class="form-control @error('confirm_password') is-invalid @enderror">
                                        @error('confirm_password')
                                        <small class="form-text text-danger" role="alert">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            @endif
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-4 col-form-label">{{ __('Email') }}</label>
                                <div class="col-sm-8">
                                    <input type="email" name="email" value="{{ old('email') ?? $user->email }}" class="form-control @error('email') is-invalid @enderror">
                                </div>
                            </div>
                            @if($canEdit)
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-4 col-form-label">{{ __('Last Login in on') }}</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" value="{{ $lastLogin }}" disabled>
                                    </div>
                                </div>
                            @endif
                            <button type="submit" class="btn btn-submit">{{ __('Submit') }}</button>
                        </form>
                    </div>
                </div>
            </div>
            <div @if(auth()->user()->hasRole(\App\Enums\UserRole::ADMIN)) class="col-lg-6">
                <div class="card m-b-30">
                    <div class="card-header">
                        <h5 class="card-title">{{ __('Two Factor Authentication') }}</h5>
                    </div>
                    <div class="card-body">
                        @if (session('status') === "two-factor-authentication-disabled")
                            <div class="alert alert-success" role="alert">
                                {{ __('Two factor Authentication has been disabled.') }}
                            </div>
                        @endif

                        @if (session('status') === "two-factor-authentication-enabled")
                            <div class="alert alert-success" role="alert">
                                {{ __('Two factor Authentication has been enabled.') }}
                            </div>
                        @endif

                        <form method="POST" action="/user/two-factor-authentication">
                            @csrf

                            @if (auth()->user()->two_factor_secret)
                                @method('DELETE')

                                <div class="pb-5">
                                    {!! auth()->user()->twoFactorQrCodeSvg() !!}
                                </div>

                                <div>
                                    <h5>Recovery Codes:</h5>

                                    <ul>
                                        @foreach (json_decode(decrypt(auth()->user()->two_factor_recovery_codes)) as $code)
                                            <li>{{ $code }}</li>
                                        @endforeach
                                    </ul>
                                </div>

                                <button class="btn btn-danger">Disable</button>
                            @else
                                <button class="btn btn-submit">Enable</button>
                            @endif
                        </form>
                    </div>
                </div>
            </div @endif>
        </div>
    </div>
@endsection

@section('script')

@endsection
