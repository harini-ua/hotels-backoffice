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
                            @if($model->mainOption->sub_companies)<a class="nav-link mb-2" href="{{ route('companies.sub-companies.edit', $model) }}">{{ __('Sub Companies') }}</a>@endif
                            <a class="nav-link mb-2" href="{{ route('companies.hotel-distances.edit', $model) }}">{{ __('Hotel Distances') }}</a>
                            <a class="nav-link mb-2" href="{{ route('companies.customer-supports.edit', $model) }}">{{ __('Customer Supports') }}</a>
                            <a class="nav-link mb-2 active" href="{{ route('companies.commissions.edit', $model) }}">{{ __('Commissions') }}</a>
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
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card m-b-30">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">{{ __('Services Commissions') }}</h5>
                                    </div>
                                    <div class="card-body">
                                        <form
                                            id="company-booking-commissions"
                                            method="POST"
                                            action="{{ route('companies.commissions.update.booking', $model) }}"
                                        >
                                            @csrf
                                            @if(isset($model)) @method('PUT') @endif
                                            <div class="form-group row">
                                                <label for="standard_commission" class="col-sm-3 col-form-label">{{ __('Standard Commission') }}</label>
                                                <div class="col-sm-4">
                                                    <div class="input-group">
                                                        <input type="number" id="standard_commission" name="standard_commission" min="0"
                                                               class="form-control @error('standard_commission') is-invalid @enderror"
                                                               value="{{ old('standard_commission') ?? ($bookingCommission ? $bookingCommission->standard_commission : null) }}"
                                                        >
                                                        <div class="input-group-append">
                                                            <span class="input-group-text">%</span>
                                                        </div>
                                                    </div>
                                                    @error('standard_commission')
                                                    <small class="form-text text-danger" role="alert">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="booking_commission" class="col-sm-3 col-form-label">{{ __('Booking Commission') }}</label>
                                                <div class="col-sm-4">
                                                    <div class="input-group">
                                                        <input type="number" id="booking_commission" name="booking_commission" min="0"
                                                               class="form-control @error('booking_commission') is-invalid @enderror"
                                                               value="{{ old('booking_commission') ?? ($bookingCommission ? $bookingCommission->booking_commission : null) }}"
                                                        >
                                                        <div class="input-group-append">
                                                            <span class="input-group-text">%</span>
                                                        </div>
                                                    </div>
                                                    @error('booking_commission')
                                                    <small class="form-text text-danger" role="alert">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="payback_to_client" class="col-sm-3 col-form-label">{{ __('Payback To Client') }}</label>
                                                <div class="col-sm-4">
                                                    <div class="input-group">
                                                        <input type="number" id="payback_to_client" name="payback_to_client" min="0"
                                                               class="form-control @error('payback_to_client') is-invalid @enderror"
                                                               value="{{ old('payback_to_client') ?? ($bookingCommission ? $bookingCommission->payback_to_client : null) }}"
                                                        >
                                                        <div class="input-group-append">
                                                            <span class="input-group-text">%</span>
                                                        </div>
                                                    </div>
                                                    @error('payback_to_client')
                                                    <small class="form-text text-danger" role="alert">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="minimal_commission" class="col-sm-3 col-form-label">{{ __('Minimal Commission') }}</label>
                                                <div class="col-sm-4">
                                                    <div class="input-group">
                                                        <input type="number" id="minimal_commission" name="minimal_commission" min="0"
                                                               class="form-control @error('minimal_commission') is-invalid @enderror"
                                                               value="{{ old('minimal_commission') ?? ($bookingCommission ? $bookingCommission->minimal_commission : null) }}"
                                                        >
                                                        <div class="input-group-append">
                                                            <span class="input-group-text">%</span>
                                                        </div>
                                                    </div>
                                                    @error('minimal_commission')
                                                    <small class="form-text text-danger" role="alert">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="use_minimal_commission" class="col-sm-3 col-form-label">{{ __('Use Minimal Commission') }}</label>
                                                <div class="input-group col-sm-4">
                                                    <div class="custom-control custom-checkbox custom-control-inline">
                                                        <input type="checkbox" id="use_minimal_commission" name="use_minimal_commission"
                                                               value="1"
                                                               @if($bookingCommission && $bookingCommission->use_minimal_commission) checked @endif
                                                               class="custom-control-input @error('use_minimal_commission') is-invalid @enderror"
                                                        >
                                                        <label class="custom-control-label" for="use_minimal_commission"></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <button class="btn btn-submit">{{ __('Submit') }}</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="card m-b-30">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">{{ __('Sales Office Level #1') }}</h5>
                                    </div>
                                    <div class="card-body">
                                        <form
                                            id="company-sale-office-level-1-commissions"
                                            method="POST"
                                            action="{{ route('companies.commissions.sale-office.update.level.1', $model) }}"
                                        >
                                            @csrf
                                            @if(isset($model)) @method('PUT') @endif
                                            <div class="form-row">
                                                <div class="form-group col-md-5">
                                                    <label for="inputCity">{{ __('Country') }}</label>
                                                </div>
                                                <div class="form-group col-md-5">
                                                    <label for="inputState">{{ __('Commission') }}</label>
                                                </div>
                                            </div>
                                            <div class="level1-commissions-repeater">
                                                <div data-repeater-list="level1-commissions">
                                                    @for($i = 0; $i < $level1CommissionsCount; $i++)
                                                        <div class="form-row level1-commissions-wrapper" data-repeater-item>
                                                            <div class="form-group col-md-5">
                                                                <select name="level1-commissions[{{ $i }}][sale_office_country_id]"
                                                                        class="form-control select2-single @error('sale_office_country_id') is-invalid @enderror"
                                                                >
                                                                    <option value="">{{ __('Select Country') }}</option>
                                                                    @php( $sale_office_country_id = old("level1commissions.$i.sale_office_country_id") )
                                                                    @php( $sale_office_country_id = $level1Commissions && $level1Commissions[$i]->sale_office_country_id ? $level1Commissions[$i]->sale_office_country_id : null )
                                                                    @foreach($countries as $id => $country)
                                                                        <option value="{{ $id }}"
                                                                                @if($id === $sale_office_country_id) selected @endif
                                                                        >{{ $country }}</option>
                                                                    @endforeach
                                                                </select>
                                                                @error('level1commissions.'.$i.'.sale_office_country_id')
                                                                <small class="form-text text-danger" role="alert">{{ $message }}</small>
                                                                @enderror
                                                            </div>
                                                            <div class="form-group col-md-5">
                                                                <div class="input-group">
                                                                    <input type="number" class="form-control" min="0"
                                                                           name="level1-commissions[{{ $i }}][commission]"
                                                                           value="{{ old("level1commissions.$i.commission") ?? ((!empty($level1Commissions) && $level1Commissions[$i]->commission) ? $level1Commissions[$i]->commission : null) }}"
                                                                    >
                                                                    <div class="input-group-append">
                                                                        <span class="input-group-text">%</span>
                                                                    </div>
                                                                </div>
                                                                @error('level1commissions.'.$i.'.commission')
                                                                <small class="form-text text-danger" role="alert">{{ $message }}</small>
                                                                @enderror
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
                                                    <div class="form-group offset-md-10 col-md-1">
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
                            <div class="col-lg-6">
                                <div class="card m-b-30">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">{{ __('Sales Office Level #2') }}</h5>
                                    </div>
                                    <div class="card-body">
                                        <form
                                            id="company-sale-office-level-2-commissions"
                                            method="POST"
                                            action="{{ route('companies.commissions.sale-office.update.level.2', $model) }}"
                                        >
                                            @csrf
                                            @if(isset($model)) @method('PUT') @endif
                                            <div class="form-row">
                                                <div class="form-group col-md-5">
                                                    <label for="inputCity">{{ __('Country') }}</label>
                                                </div>
                                                <div class="form-group col-md-5">
                                                    <label for="inputState">{{ __('Commission') }}</label>
                                                </div>
                                            </div>
                                            <div class="level2-commissions-repeater">
                                                <div data-repeater-list="level2-commissions">
                                                    @for($i = 0; $i < $level2CommissionsCount; $i++)
                                                        <div class="form-row level2-commissions-wrapper" data-repeater-item>
                                                            <div class="form-group col-md-5">
                                                                <select name="level2-commissions[{{ $i }}][sale_office_country_id]"
                                                                        class="form-control select2-single @error('sale_office_country_id') is-invalid @enderror"
                                                                >
                                                                    <option value="">{{ __('Select Country') }}</option>
                                                                    @php( $sale_office_country_id = old("level2commissions.$i.sale_office_country_id") )
                                                                    @php( $sale_office_country_id = $level2Commissions && $level2Commissions[$i]->sale_office_country_id ? $level2Commissions[$i]->sale_office_country_id : null )
                                                                    @foreach($countries as $id => $country)
                                                                        <option value="{{ $id }}"
                                                                                @if($id === $sale_office_country_id) selected @endif
                                                                        >{{ $country }}</option>
                                                                    @endforeach
                                                                </select>
                                                                @error('level2commissions.'.$i.'.sale_office_country_id')
                                                                <small class="form-text text-danger" role="alert">{{ $message }}</small>
                                                                @enderror
                                                            </div>
                                                            <div class="form-group col-md-5">
                                                                <div class="input-group">
                                                                    <input type="number" class="form-control" min="0"
                                                                           name="level2-commissions[{{ $i }}][commission]"
                                                                           value="{{ old("level2commissions.$i.commission") ?? ((!empty($level2Commissions) && $level2Commissions[$i]->commission) ? $level2Commissions[$i]->commission : null) }}"
                                                                    >
                                                                    <div class="input-group-append">
                                                                        <span class="input-group-text">%</span>
                                                                    </div>
                                                                </div>
                                                                @error('level2commissions.'.$i.'.commission')
                                                                <small class="form-text text-danger" role="alert">{{ $message }}</small>
                                                                @enderror
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
                                                    <div class="form-group offset-md-10 col-md-1">
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
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('assets/plugins/select2/select2.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/form-repeater/jquery.repeater.min.js') }}"></script>
    <script src="{{asset('js/pages/company-commissions.js')}}"></script>
@endsection
