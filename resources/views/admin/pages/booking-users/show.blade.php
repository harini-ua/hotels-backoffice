@extends('admin.layouts.main')

@section('title', $user->fullname)

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/pages/booking-users.css') }}">
@endsection

@section('rightbar-content')
    <div class="contentbar booking-users-show-wrapper">
        <div class="row">
            <div class="col-lg-5 col-xl-3">
                <div class="card m-b-30">
                    <div class="card-header">
                        <h5 class="card-title mb-0">{{ __('User Menu') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                            <a class="nav-link mb-2 active" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="true"><i class="feather icon-user mr-2"></i>{{ __('Contact Details') }}</a>
                            <a class="nav-link mb-2" id="v-pills-password-tab" data-toggle="pill" href="#v-pills-password" role="tab" aria-controls="v-pills-password" aria-selected="false"><i class="feather icon-settings mr-2"></i>{{ __('Password') }}</a>
                            <a class="nav-link" href="/#" target="_blank" role="tab"><i class="feather icon-log-in mr-2"></i>{{ __('Login') }}</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-7 col-xl-9">
                <div class="tab-content" id="v-pills-tabContent">
                    <div class="tab-pane fade show active" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                        <div class="card m-b-30">
                            <div class="card-header">
                                <h5 class="card-title mb-0">{{ __('Contact Details') }}</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-borderless mb-0">
                                        <tbody>
                                            <tr>
                                                <th scope="row" class="p-1">{{ __('Company') }} :</th>
                                                <td class="p-1">{{ $user->company ? $user->company->name : '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row" class="p-1">{{ __('Full Name') }} :</th>
                                                <td class="p-1">{{ $user->fullname ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row" class="p-1">{{ __('Address') }} :</th>
                                                <td class="p-1">{{ $user->address ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row" class="p-1">{{ __('City') }} :</th>
                                                <td class="p-1">{{ $user->city ? $user->city->name : '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row" class="p-1">{{ __('Country') }} :</th>
                                                <td class="p-1">{{ $user->country ? $user->country->name : '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row" class="p-1">{{ __('Company') }} :</th>
                                                <td class="p-1">{{ $user->company_name ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row" class="p-1">{{ __('Email') }} :</th>
                                                <td class="p-1">{{ $user->email ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row" class="p-1">{{ __('Mobile') }} :</th>
                                                <td class="p-1">{{ $user->phone ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row" class="p-1">{{ __('Status') }} :</th>
                                                <td class="p-1">
                                                    @if($user->status)
                                                    <span class="badge badge-success">{{ __('Active') }}</span>
                                                    @else
                                                    <span class="badge badge-danger">{{ __('Inactive') }}</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row" class="p-1">{{ __('login Name') }} :</th>
                                                <td class="p-1">{{ $user->username ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row" class="p-1">{{ __('Language') }} :</th>
                                                <td class="p-1">{{ $user->language ? $user->language->name : '-' }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="v-pills-password" role="tabpanel" aria-labelledby="v-pills-password-tab">
                        <div class="card m-b-30">
                            <div class="card-header">
                                <h5 class="card-title mb-0">{{ __('Password') }}</h5>
                            </div>
                            <div class="card-body">
                                <form id="password-user" method="POST" class="handle-submit-form">
                                    @csrf
                                    <div class="form-group row">
                                        <label for="password" class="col-sm-2 col-form-label">{{ __('Password') }}</label>
                                        <div class="input-group col-sm-4 mb-3">
                                            <input type="text" id="password" name="password" class="form-control @error('password') is-invalid @enderror" >
                                            <div class="input-group-append">
                                                <button class="btn btn-light" type="button" id="generate">{{ __('Generate') }}</button>
                                            </div>
                                            @error('password')
                                            <small class="form-text text-danger" role="alert">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-primary change-pass" data-action="{{ route('booking-users.password.change', $user) }}"><i class="feather icon-save mr-2"></i>{{ __('Change Password') }}</button>
                                    <button type="button" class="btn btn-success send-pass" data-action="{{ route('booking-users.password.send', $user) }}"><i class="feather icon-send mr-2"></i>{{ __('Send Password') }}</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{asset('js/scripts/password.js')}}"></script>
    <script src="{{asset('js/pages/booking-users.js')}}"></script>
@endsection
