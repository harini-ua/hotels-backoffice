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
                            @if($model->sub_companies)<a class="nav-link mb-2" href="{{ route('companies.sub-companies.edit', $model) }}">{{ __('Sub Companies') }}</a>@endif
                            <a class="nav-link mb-2 active" href="{{ route('companies.hotel-distances.edit', $model) }}">{{ __('Hotel Distances') }}</a>
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
                                <h5 class="card-title mb-0">{{ __('Hotel Distances') }}</h5>
                            </div>
                            <div class="card-body">
                                <form
                                    id="company-hotel-distances"
                                    method="POST"
                                    action="{{ route('companies.hotel-distances.update', $model) }}"
                                >
                                    @csrf
                                    @if(isset($model)) @method('PUT') @endif
                                    @foreach($hotelDistances as $i => $item)
                                        <input type="hidden"
                                               name="distances[{{ $i }}][name]"
                                               value="{{ $item->name }}"
                                        >

                                        <div class="input-group mb-3">
                                            <div class="col-sm-3" style="margin: 5px 0px;">
                                                <div class="custom-control custom-checkbox custom-control-inline">
                                                    <input type="checkbox"
                                                           class="custom-control-input"
                                                           id="distances[{{ $i }}][status]"
                                                           name="distances[{{ $i }}][status]"
                                                           value="1"
                                                           @if($item->status) checked @endif
                                                    >
                                                    <label for="distances[{{ $i }}][status]" class="custom-control-label"> {{ \App\Enums\HotelDistanceFilters::getDescription($item->name) }}</label>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <input type="number" min="0"
                                                       name="distances[{{ $i }}][value]"
                                                       class="form-control @error($item->name) is-invalid @enderror"
                                                       value="{{ old($item->name) ?? $item->value }}"
                                                >
                                            </div>
                                            @error($item->name)
                                            <small class="form-text text-danger" role="alert">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    @endforeach
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
