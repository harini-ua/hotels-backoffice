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
                            <a class="nav-link mb-2 active" href="{{ route('companies.general.edit', $model) }}">{{ __('General') }}</a>
                            <a class="nav-link mb-2" href="{{ route('companies.contact.edit', $model) }}">{{ __('Contact Info') }}</a>
                            <a class="nav-link mb-2" href="{{ route('companies.homepage.edit', $model) }}">{{ __('Homepage') }}</a>
                            <a class="nav-link mb-2" href="{{ route('companies.extra-nights.edit', $model) }}">{{ __('Extra Nights') }}</a>
                            <a class="nav-link mb-2" href="{{ route('companies.prefilled-options.edit', $model) }}">{{ __('Pre Filled Options') }}</a>
                            @if($model->mainOption->sub_companies)<a class="nav-link mb-2" href="{{ route('companies.sub-companies.edit', $model) }}">{{ __('Sub Companies') }}</a>@endif
                            <a class="nav-link mb-2" href="{{ route('companies.hotel-distances.edit', $model) }}">{{ __('Hotel Distances') }}</a>
                            <a class="nav-link mb-2" href="{{ route('companies.customer-supports.edit', $model) }}">{{ __('Customer Supports') }}</a>
                            <a class="nav-link mb-2" href="{{ route('companies.commissions.edit', $model) }}">{{ __('Commissions') }}</a>
                            <a class="nav-link mb-2" href="{{ route('companies.vat.edit', $model) }}">{{ __('VAT') }}</a>
                            <a class="nav-link mb-2" href="{{ route('companies.account.edit', $model) }}">{{ __('Account') }}</a>
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
                                <h5 class="card-title mb-0">{{ __('General Options') }}</h5>
                            </div>
                            <div class="card-body">
                                <form
                                    id="company-general"
                                    method="POST"
                                    action="{{ route('companies.general.update', $model) }}"
                                >
                                    @csrf
                                    @if(isset($model)) @method('PUT') @endif
                                    @if((int) $model->login_type === \App\Enums\AccessCodeType::FIXED)
                                    <div class="form-group row">
                                        <label for="access_code" class="col-sm-2 col-form-label">{{ __('Access Code') }}</label>
                                        <div class="input-group col-sm-5">
                                            <input type="text"
                                                   id="access_code"
                                                   name="access_code"
                                                   class="form-control"
                                                   value="{{ old('access_code') ?? $accessCode ? $accessCode->code : null }}"
                                            />
                                            <div class="input-group-append">
                                                <button type="button"
                                                        class="btn btn-light update_access_code"
                                                        data-action="{{ route('companies.access-codes.fixed.update', $model) }}"
                                                >{{ __('Update Code') }}</button>
                                            </div>
                                        </div>
                                        @error('access_code')
                                        <small class="form-text text-danger" role="alert">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group row">
                                        <label for="access_code_last_update" class="col-sm-2 col-form-label">{{ __('Last Modified') }}</label>
                                        <div class="input-group col-sm-5">
                                            <input type="text"
                                                   id="access_code_last_update"
                                                   name="access_code_last_update"
                                                   class="form-control-plaintext"
                                                   value="{{ \App\Services\Formatter::date($accessCode->created_at, 'Y-m-d H:i:s') }}"
                                                   disabled
                                            />
                                        </div>
                                    </div>
                                    @endif
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
    <script src="{{asset('js/pages/company-general.js')}}"></script>
@endsection
