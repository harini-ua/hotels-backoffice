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
                            <a class="nav-link mb-2 active" href="{{ route('companies.prefilled-options.edit', $model) }}">{{ __('Pre Filled Options') }}</a>
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
                                <h5 class="card-title mb-0">{{ __('Pre Filled Options') }}</h5>
                            </div>
                            <div class="card-body">
                                <form
                                    id="company-prefilled-options"
                                    method="POST"
                                    action="{{ route('companies.prefilled-options.update', $model) }}"
                                >
                                    @csrf
                                    @if(isset($model)) @method('PUT') @endif
                                    <div class="form-group row">
                                        <label for="adults_count" class="col-sm-2 col-form-label">{{ __('Adults Count') }}</label>
                                        <div class="col-sm-4">
                                            <input type="number" id="adults_count" name="adults_count" min="0"
                                                   class="form-control @error('adults_count') is-invalid @enderror"
                                                   value="{{ old('adults_count') ?? ($prefilledOptions ? $prefilledOptions->adults_count : null) }}"
                                            >
                                            @error('adults_count')
                                            <small class="form-text text-danger" role="alert">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="nights_count" class="col-sm-2 col-form-label">{{ __('Nights Count') }}</label>
                                        <div class="col-sm-4">
                                            <input type="number" id="nights_count" name="nights_count" min="0"
                                                   class="form-control @error('nights_count') is-invalid @enderror"
                                                   value="{{ old('nights_count') ?? ($prefilledOptions ? $prefilledOptions->nights_count : null) }}"
                                            >
                                            @error('nights_count')
                                            <small class="form-text text-danger" role="alert">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="rooms_count" class="col-sm-2 col-form-label">{{ __('Rooms Count') }}</label>
                                        <div class="col-sm-4">
                                            <input type="number" id="rooms_count" name="rooms_count" min="1" max="3"
                                                   class="form-control @error('rooms_count') is-invalid @enderror"
                                                   value="{{ old('rooms_count') ?? ($prefilledOptions ? $prefilledOptions->rooms_count : null) }}"
                                            >
                                            @error('rooms_count')
                                            <small class="form-text text-danger" role="alert">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="checkout_editable" class="col-sm-2 col-form-label">{{ __('Is Checkout Date Editable') }}</label>
                                        <div class="input-group col-sm-4">
                                            <div class="custom-control custom-checkbox custom-control-inline">
                                                <input type="checkbox" id="checkout_editable" name="checkout_editable"
                                                       value="1"
                                                       @if(old('checkout_editable')) checked @endif
                                                       @if($prefilledOptions && $prefilledOptions->checkout_editable) checked @endif
                                                       class="custom-control-input @error('checkout_editable') is-invalid @enderror"
                                                >
                                                <label class="custom-control-label" for="checkout_editable"></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="country_id" class="col-sm-2 col-form-label">{{ __('Country') }}</label>
                                        <div class="col-sm-4">
                                            <select id="country_id" name="country_id"
                                                    class="form-control select2-single @error('country_id') is-invalid @enderror"
                                            >
                                                <option value="">{{ '- '.__('Choice Country').' -' }}</option>
                                                @foreach($countries as $id => $country)
                                                    <option value="{{ $id }}"
                                                            @if($id == old('country_id')) selected @endif
                                                            @if($prefilledOptions && $prefilledOptions->country_id == $id) selected @endif
                                                    >{{ $country }}</option>
                                                @endforeach
                                            </select>
                                            @error('country_id')
                                            <small class="form-text text-danger" role="alert">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="city_id" class="col-sm-2 col-form-label">{{ __('City') }}</label>
                                        <div class="col-sm-4">
                                            <select id="city_id" name="city_id"
                                                    class="form-control select2-single @error('city_id') is-invalid @enderror"
                                            >
                                                <option value="">{{ '- '.__('Choice City').' -' }}</option>
                                                @foreach($cities as $id => $city)
                                                    <option value="{{ $id }}"
                                                            @if($id == old('city_id')) selected @endif
                                                            @if($prefilledOptions && $prefilledOptions->city_id == $id) selected @endif
                                                    >{{ $city }}</option>
                                                @endforeach
                                            </select>
                                            @error('city_id')
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
    <script src="{{asset('js/pages/companies.js')}}"></script>
@endsection
