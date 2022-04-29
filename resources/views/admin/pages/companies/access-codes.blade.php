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
                            <a class="nav-link mb-2" href="{{ route('companies.hotel-distances.edit', $model) }}">{{ __('Hotel Distances') }}</a>
                            <a class="nav-link mb-2" href="{{ route('companies.customer-supports.edit', $model) }}">{{ __('Customer Supports') }}</a>
                            <a class="nav-link mb-2" href="{{ route('companies.commissions.edit', $model) }}">{{ __('Commissions') }}</a>
                            <a class="nav-link mb-2" href="{{ route('companies.vat.edit', $model) }}">{{ __('VAT') }}</a>
                            <a class="nav-link mb-2" href="{{ route('companies.account.edit', $model) }}">{{ __('Account') }}</a>
                            <a class="nav-link mb-2 active" href="{{ route('companies.access-codes.edit', $model) }}">{{ __('Access Codes') }}</a>
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
                                <h5 class="card-title mb-0">{{ __('Access Codes') }}</h5>
                            </div>
                            <div class="card-body">
                                <form
                                    id="company-access-codes"
                                    method="POST"
                                    action="{{ route('companies.access-codes.unique.update', $model) }}"
                                >
                                    @csrf
                                    @if(isset($model)) @method('PUT') @endif
                                    <div class="form-group row">
                                        <label for="access_codes" class="col-sm-2 col-form-label">{{ __('Access Codes') }} *</label>
                                        <div class="col-sm-4">
                                            <input type="number" id="access_codes" name="access_codes" min="1"
                                                   class="form-control @error('access_codes') is-invalid @enderror"
                                                   value="{{ old('access_codes') ?? ($model ? $model->access_codes : null) }}"
                                            >
                                            @error('access_codes')
                                            <small class="form-text text-danger" role="alert">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="updates_by_dates" class="col-sm-2 col-form-label">{{ __('Update By Dates') }} *</label>
                                        <div class="col-sm-4">
                                            <select id="updates_by_dates" name="updates_by_dates"
                                                    class="form-control @error('updates_by_dates') is-invalid @enderror"
                                                    @if(!$updatesByDates->count()) disabled @endif
                                            >
                                                <option value="">{{ '- '.__('Choice Date').' -' }}</option>
                                                @foreach($updatesByDates as $id => $date)
                                                    <option value="{{ $id }}"
                                                            @if($id == old('updates_by_dates')) selected @endif
                                                    >{{ $date }}</option>
                                                @endforeach
                                            </select>
                                            @error('updates_by_dates')
                                            <small class="form-text text-danger" role="alert">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="codes" class="col-sm-2 col-form-label">{{ __('Codes') }}</label>
                                        <div class="col-sm-6">
                                            <textarea id="codes" name="codes" class="form-control" rows="5" disabled
                                            >{{ __('Please сhoice a date to view codes') }}</textarea>
                                        </div>
                                    </div>
                                    <button class="btn btn-primary" name="update">{{ __('Submit') }}</button>
                                    <button class="btn btn-success" name="download">{{ __('Download') }}</button>
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
@endsection
