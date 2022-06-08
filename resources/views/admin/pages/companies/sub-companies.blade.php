@extends('admin.layouts.main')

@section('title',  __('Update Company Site'))

@section('style')
    <link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/pages/sub-companies.css') }}">
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
                            @if($model->sub_companies)<a class="nav-link mb-2 active" href="{{ route('companies.sub-companies.edit', $model) }}">{{ __('Sub Companies') }}</a>@endif
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
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card m-b-30">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">{{ __('Sub Companies') }}</h5>
                                    </div>
                                    <div class="card-body">
                                        <form
                                            id="company-sub-companies"
                                            method="POST"
                                            action="{{ route('companies.sub-companies.update', $model) }}"
                                        >
                                            @csrf
                                            @if(isset($model)) @method('PUT') @endif
                                            <div class="form-row">
                                                <div class="form-group col-md-4">
                                                    <label>{{ __('Sub Company Name') }}</label>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label>{{ __('Commission') }}</label>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label></label>
                                                </div>
                                            </div>
                                            <div class="sub-companies-repeater">
                                                <div data-repeater-list="sub-companies">
                                                    @for($i = 0; $i < $count; $i++)
                                                        <div class="form-row sub-companies-wrapper" data-repeater-item>
                                                            <div class="form-group col-md-4">
                                                                <input type="text" class="form-control"
                                                                       name="sub-companies[{{ $i }}][company_name]"
                                                                       value="{{ old("sub-companies.$i.company_name") ?? ((!empty($subCompanies) && $subCompanies[$i]->company_name) ? $subCompanies[$i]->company_name : null) }}">
                                                                @error('sub-companies.'.$i.'.company_name')
                                                                <small class="form-text text-danger" role="alert">{{ $message }}</small>
                                                                @enderror
                                                            </div>
                                                            <div class="form-group col-md-4">
                                                                <div class="input-group">
                                                                    <input type="number" class="form-control"
                                                                           step="1" min="0" max="100"
                                                                           name="sub-companies[{{ $i }}][commission]"
                                                                           value="{{ old("sub-companies.$i.commission")  ?? ((!empty($subCompanies) && $subCompanies[$i]->commission) ? $subCompanies[$i]->commission : null) }}">
                                                                    <div class="input-group-append">
                                                                        <span class="input-group-text">%</span>
                                                                    </div>
                                                                    @error('sub-companies.'.$i.'.commission')
                                                                    <small class="form-text text-danger" role="alert">{{ $message }}</small>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="form-group col-md-3">
                                                                <div class="input-group">
                                                                    <div class="custom-control custom-checkbox custom-control-inline">
                                                                        <input type="checkbox"
                                                                               name="sub-companies[{{ $i }}][status] "
                                                                               value="1"
                                                                               @if(((!empty($subCompanies) && $subCompanies[$i]->status) ? $subCompanies[$i]->status : null)) checked @endif
                                                                               class="custom-control-input @error('sub-companies.'.$i.'.status') is-invalid @enderror"
                                                                        >
                                                                        @error('sub-companies.'.$i.'.status')
                                                                        <small class="form-text text-danger" role="alert">{{ $message }}</small>
                                                                        @enderror
                                                                        <label class="custom-control-label" for="sub-companies[{{ $i }}][status]">{{ __('Active') }}</label>
                                                                    </div>
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
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('assets/plugins/select2/select2.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/form-repeater/jquery.repeater.min.js') }}"></script>
    <script src="{{asset('js/pages/sub-companies.js')}}"></script>
@endsection
