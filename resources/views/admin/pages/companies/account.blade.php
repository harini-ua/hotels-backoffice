@extends('admin.layouts.main')
@section('title',  __('Update Company Site'))
@section('style')
    <link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/pages/companies.css') }}">
@endsection
@section('rightbar-content')
    @php($model = $company ?? null)
    <div class="contentbar companies-edit-wrapper">
        <div class="row">
            <div class="col-lg-5 col-xl-3">
                <div class="card m-b-30">
                    <div class="card-header">
                        <h5 class="card-title mb-0">{{ $model->company_name }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                            <a class="nav-link mb-2" href="{{ route('companies.general.edit', $model) }}">{{ __('General') }}</a>
                            <a class="nav-link mb-2" href="{{ route('companies.contact.edit', $model) }}">{{ __('Contact Info') }}</a>
                            <a class="nav-link mb-2" href="{{ route('companies.homepage.edit', $model) }}">{{ __('Homepage') }}</a>
                            <a class="nav-link mb-2" href="{{ route('companies.extra-nights.edit', $model) }}">{{ __('Extra Nights') }}</a>
                            <a class="nav-link mb-2" href="{{ route('companies.prefilled-options.edit', $model) }}">{{ __('Pre Filled Options') }}</a>
                            <a class="nav-link mb-2" href="{{ route('companies.hotel-distances.edit', $model) }}">{{ __('Hotel Distances') }}</a>
                            <a class="nav-link mb-2" href="{{ route('companies.customer-supports.edit', $model) }}">{{ __('Customer Supports') }}</a>
                            <a class="nav-link mb-2" href="{{ route('companies.commissions.edit', $model) }}">{{ __('Commissions') }}</a>
                            <a class="nav-link mb-2" href="{{ route('companies.vat.edit', $model) }}">{{ __('VAT') }}</a>
                            <a class="nav-link mb-2 active" href="{{ route('companies.account.edit', $model) }}">{{ __('Account') }}</a>
                            @if((int) $model->login_type === \App\Enums\AccessCodeType::UNIQUE)
                            <a class="nav-link mb-2" href="{{ route('companies.access-codes.edit', $model) }}">{{ __('Access Codes') }}</a>
                            @endif
                            <a class="nav-link mb-2" href="{{ route('companies.others.edit', $model) }}">{{ __('Others') }}</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-7 col-xl-9">
                <div class="tab-content" id="v-pills-tabContent">
                    <div class="tab-pane fade show active" id="v-pills-extra-nights" role="tabpanel" aria-labelledby="v-pills-extra-nights-tab">
                        <div class="card m-b-30">
                            <div class="card-header">
                                <h5 class="card-title mb-0">{{ __('Account') }}</h5>
                            </div>
                            <div class="card-body">
                                <form
                                    id="company-account"
                                    method="POST"
                                    action="{{ route('companies.account.update', $model) }}"
                                >
                                    @csrf
                                    @if(isset($model)) @method('PUT') @endif
                                    <div class="form-group row">
                                        <label for="username" class="col-sm-2 col-form-label">{{ __('Username') }}</label>
                                        <div class="col-sm-4">
                                            <input type="text" id="username" name="username" min="0"
                                                   class="form-control @error('username') is-invalid @enderror"
                                                   value="{{ old('username') ?? ($user ? $user->username : null) }}"
                                            >
                                            @error('username')
                                            <small class="form-text text-danger" role="alert">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
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
                                    <button class="btn btn-submit">{{ __('Submit') }}</button>
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
    <script src="{{ asset('assets/plugins/select2/select2.min.js') }}"></script>
    <script src="{{asset('js/scripts/password.js')}}"></script>
@endsection
