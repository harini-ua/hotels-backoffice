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
                            <a class="nav-link mb-2 active" href="{{ route('companies.customer-supports.edit', $model) }}">{{ __('Customer Supports') }}</a>
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
                                <h5 class="card-title mb-0">{{ __('Customer Supports') }}</h5>
                            </div>
                            <div class="card-body">
                                <form
                                    id="company-customer-supports"
                                    method="POST"
                                    action="{{ route('companies.customer-supports.update', $model) }}"
                                >
                                    @csrf
                                    @if(isset($model)) @method('PUT') @endif
                                    <div class="form-row">
                                        <div class="form-group col-md-3">
                                            <label for="inputCity">{{ __('Country') }}</label>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="inputState">{{ __('Email') }}</label>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="inputZip">{{ __('Phone') }}</label>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="inputZip">{{ __('Work Hours') }}</label>
                                        </div>
                                    </div>
                                    <div class="supports-repeater">
                                        <div data-repeater-list="supports">
                                            @for($i = 0; $i < $count; $i++)
                                            <div class="form-row supports-wrapper" data-repeater-item>
                                                <div class="form-group col-md-3">
                                                    <select name="supports[{{ $i }}][country_id]"
                                                            class="form-control select2-single @error('country_id') is-invalid @enderror"
                                                    >
                                                        <option value="">{{ __('Select Country') }}</option>
                                                        @php( $country_id = old("supports.$i.country_id") )
                                                        @php( $country_id = $supports && $supports[$i]->country_id ? $supports[$i]->country_id : null )
                                                        {{ $country_id }}
                                                        @foreach($countries as $id => $country)
                                                            <option value="{{ $id }}"
                                                                    @if($id === $country_id) selected @endif
                                                            >{{ $country }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('supports.'.$i.'.country_id')
                                                    <small class="form-text text-danger" role="alert">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <input type="text" class="form-control"
                                                           name="supports[{{ $i }}][email]"
                                                           value="{{ old("supports.$i.email") ?? ((!empty($supports) && $supports[$i]->email) ? $supports[$i]->email : null) }}">
                                                    @error('supports.'.$i.'.email')
                                                    <small class="form-text text-danger" role="alert">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <input type="text" class="form-control"
                                                           name="supports[{{ $i }}][phone]"
                                                           value="{{ old("supports.$i.phone")  ?? ((!empty($supports) && $supports[$i]->phone) ? $supports[$i]->phone : null) }}">
                                                    @error('supports.'.$i.'.phone')
                                                    <small class="form-text text-danger" role="alert">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-md-2">
                                                    <input type="text" class="form-control"
                                                           name="supports[{{ $i }}][work_hours]"
                                                           value="{{ old("supports.$i.work_hours")  ?? ((!empty($supports) && $supports[$i]->work_hours) ? $supports[$i]->work_hours : null) }}">
                                                    @error('supports.'.$i.'.work_hours')
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
                                            <div class="form-group offset-md-11 col-md-1">
                                                <button type="button" class="btn btn-success" data-repeater-create>
                                                    <i class="feather icon-plus"></i>
                                                </button>
                                            </div>
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
    <script src="{{ asset('assets/plugins/form-repeater/jquery.repeater.min.js') }}"></script>
    <script src="{{ asset('js/pages/customer-supports.js') }}"></script>
@endsection
