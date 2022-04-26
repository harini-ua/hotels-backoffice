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
                            <a class="nav-link mb-2" href="{{ route('companies.homepage.edit', $model) }}">{{ __('Homepage') }}</a>
                            <a class="nav-link mb-2 active" href="{{ route('companies.extra-nights.edit', $model) }}">{{ __('Extra Nights') }}</a>
                            <a class="nav-link mb-2" href="{{ route('companies.prefilled-options.edit', $model) }}">{{ __('Pre Filled Options') }}</a>
                            <a class="nav-link mb-2" href="{{ route('companies.hotel-distances.edit', $model) }}">{{ __('Hotel Distances') }}</a>
                            <a class="nav-link mb-2" href="{{ route('companies.customer-supports.edit', $model) }}">{{ __('Customer Supports') }}</a>
                            <a class="nav-link mb-2" href="{{ route('companies.commissions.edit', $model) }}">{{ __('Commissions') }}</a>
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
                                <h5 class="card-title mb-0">{{ __('Extra Nights') }}</h5>
                            </div>
                            <div class="card-body">
                                <form
                                    id="company-extra-nights"
                                    method="POST"
                                    action="{{ route('companies.extra-nights.update', $model) }}"
                                >
                                    @csrf
                                    @if(isset($model)) @method('PUT') @endif
                                    <div class="form-group row">
                                        <label for="enable" class="col-sm-2 col-form-label">{{ __('Enable') }}</label>
                                        <div class="input-group col-sm-4">
                                            <div class="custom-control custom-checkbox custom-control-inline">
                                                <input type="checkbox" id="enable" name="enable"
                                                       value="1"
                                                       @if($extraNight && $extraNight->enable) checked @endif
                                                       class="custom-control-input @error('enable') is-invalid @enderror"
                                                >
                                                <label class="custom-control-label" for="enable"></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="partner_price" class="col-sm-2 col-form-label">{{ __('Partner Night Price') }}</label>
                                        <div class="col-sm-4">
                                            <input type="number" id="partner_price" name="partner_price" min="0" step="0.5"
                                                   class="form-control @error('partner_price') is-invalid @enderror"
                                                   value="{{ old('partner_price') ?? ($extraNight ? $extraNight->partner_price : null) }}"
                                            >
                                            @error('partner_price')
                                            <small class="form-text text-danger" role="alert">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="customer_price" class="col-sm-2 col-form-label">{{ __('Customer Pay Price') }}</label>
                                        <div class="col-sm-4">
                                            <input type="number" id="customer_price" name="customer_price" min="0" step="0.5"
                                                   class="form-control @error('customer_price') is-invalid @enderror"
                                                   value="{{ old('customer_price') ?? ($extraNight ? $extraNight->customer_price : null) }}"
                                            >
                                            @error('customer_price')
                                            <small class="form-text text-danger" role="alert">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="currency_id" class="col-sm-2 col-form-label">{{ __('Currency') }}</label>
                                        <div class="col-sm-4">
                                            <select id="currency_id"
                                                    name="currency_id"
                                                    class="form-control select2-single @error('currency_id') is-invalid @enderror"
                                            >
                                                @foreach($currencies as $id => $currency)
                                                    <option value="{{ $id }}"
                                                            @if($id == old('currency_id')) selected @endif
                                                            @if($extraNight && $extraNight->currency_id == $id) selected @endif
                                                    >{{ $currency }}</option>
                                                @endforeach
                                            </select>
                                            @error('currency_id')
                                            <small class="form-text text-danger" role="alert">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <button class="btn btn-primary">{{ __('Submit') }}</button>
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
    <script src="{{asset('js/pages/companies.js')}}"></script>
@endsection
