@extends('admin.layouts.main')

@section('title',  __('Update Company Site'))

@section('style')
    <link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
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
                            @if($model->sub_companies)<a class="nav-link mb-2" href="{{ route('companies.sub-companies.edit', $model) }}">{{ __('Sub Companies') }}</a>@endif
                            <a class="nav-link mb-2" href="{{ route('companies.hotel-distances.edit', $model) }}">{{ __('Hotel Distances') }}</a>
                            <a class="nav-link mb-2" href="{{ route('companies.customer-supports.edit', $model) }}">{{ __('Customer Supports') }}</a>
                            <a class="nav-link mb-2" href="{{ route('companies.commissions.edit', $model) }}">{{ __('Commissions') }}</a>
                            <a class="nav-link mb-2 active" href="{{ route('companies.vat.edit', $model) }}">{{ __('VAT') }}</a>
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
                                <h5 class="card-title mb-0">{{ __('VAT') }}</h5>
                            </div>
                            <div class="card-body">
                                <form
                                    id="company-vat"
                                    method="POST"
                                    action="{{ route('companies.vat.update', $model) }}"
                                >
                                    @csrf
                                    @if(isset($model)) @method('PUT') @endif
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label for="inputCity">{{ __('Citizen') }}</label>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="inputState">{{ __('Country') }}</label>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="inputZip">{{ __('Percentage') }}</label>
                                        </div>
                                    </div>
                                    <div class="vat-repeater">
                                        <div data-repeater-list="vat">
                                            @for($i = 0; $i < $count; $i++)
                                            <div class="form-row vat-wrapper" data-repeater-item>
                                                <div class="form-group col-md-4">
                                                    <select name="vat[{{ $i }}][citizen_id]"
                                                            class="form-control select2-single @error('citizen_id') is-invalid @enderror"
                                                    >
                                                        <option value="">{{ __('Select Citizen') }}</option>
                                                        @php( $citizen_id = old("vat.$i.citizen_id") )
                                                        @php( $citizen_id = $vat && $vat[$i]->citizen_id ? $vat[$i]->citizen_id : null )
                                                        {{ $citizen_id }}
                                                        @foreach($countries as $id => $country)
                                                            <option value="{{ $id }}"
                                                                    @if($id === $citizen_id) selected @endif
                                                            >{{ $country }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('vat.'.$i.'.citizen_id')
                                                    <small class="form-text text-danger" role="alert">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <select name="vat[{{ $i }}][country_id]"
                                                            class="form-control select2-single @error('country_id') is-invalid @enderror"
                                                    >
                                                        <option value="">{{ __('Select Country') }}</option>
                                                        @php( $country_id = old("vat.$i.country_id") )
                                                        @php( $country_id = $vat && $vat[$i]->country_id ? $vat[$i]->country_id : null )
                                                        {{ $country_id }}
                                                        @foreach($countries as $id => $country)
                                                            <option value="{{ $id }}"
                                                                    @if($id === $country_id) selected @endif
                                                            >{{ $country }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('vat.'.$i.'.country_id')
                                                    <small class="form-text text-danger" role="alert">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control"
                                                               name="vat[{{ $i }}][percentage]"
                                                               value="{{ old("vat.$i.percentage")  ?? ((!empty($vat) && $vat[$i]->percentage) ? $vat[$i]->percentage : null) }}">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text">%</span>
                                                        </div>
                                                        @error('vat.'.$i.'.percentage')
                                                        <small class="form-text text-danger" role="alert">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-1">
                                                    <button type="button" class="btn btn-danger" data-repeater-delete>
                                                        <i class="feather icon-trash-2"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            @endfor
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group offset-md-11 col-md-1">
                                                <button type="button" class="btn btn-success" data-repeater-create>
                                                    <i class="feather icon-plus"></i>
                                                </button>
                                            </div>
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
    <script src="{{ asset('assets/plugins/form-repeater/jquery.repeater.min.js') }}"></script>
    <script src="{{ asset('js/pages/vat.js') }}"></script>
@endsection
