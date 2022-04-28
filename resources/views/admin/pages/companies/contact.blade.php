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
                            <a class="nav-link mb-2 active" href="{{ route('companies.contact.edit', $model) }}">{{ __('Contact Info') }}</a>
                            <a class="nav-link mb-2" href="{{ route('companies.homepage.edit', $model) }}">{{ __('Homepage') }}</a>
                            <a class="nav-link mb-2" href="{{ route('companies.extra-nights.edit', $model) }}">{{ __('Extra Nights') }}</a>
                            <a class="nav-link mb-2" href="{{ route('companies.prefilled-options.edit', $model) }}">{{ __('Pre Filled Options') }}</a>
                            <a class="nav-link mb-2" href="{{ route('companies.hotel-distances.edit', $model) }}">{{ __('Hotel Distances') }}</a>
                            <a class="nav-link mb-2" href="{{ route('companies.customer-supports.edit', $model) }}">{{ __('Customer Supports') }}</a>
                            <a class="nav-link mb-2" href="{{ route('companies.commissions.edit', $model) }}">{{ __('Commissions') }}</a>
                            <a class="nav-link mb-2" href="{{ route('companies.account.edit', $model) }}">{{ __('Account') }}</a>
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
                                <h5 class="card-title mb-0">{{ __('Contact Info') }}</h5>
                            </div>
                            <div class="card-body">
                                <form
                                    id="company-contact"
                                    method="POST"
                                    action="{{ route('companies.contact.update', $model) }}"
                                >
                                    @csrf
                                    @if(isset($model)) @method('PUT') @endif
                                    <div class="form-group row">
                                        <label for="holder_name" class="col-sm-2 col-form-label">{{ __('Contact Name') }}</label>
                                        <div class="col-sm-4">
                                            <input type="text" id="holder_name" name="holder_name" min="0"
                                                   class="form-control @error('holder_name') is-invalid @enderror"
                                                   value="{{ old('holder_name') ?? ($model ? $model->holder_name : null) }}"
                                            >
                                            @error('holder_name')
                                            <small class="form-text text-danger" role="alert">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="email" class="col-sm-2 col-form-label">{{ __('Contact Email') }}</label>
                                        <div class="col-sm-4">
                                            <input type="email" id="email" name="email"
                                                   class="form-control @error('email') is-invalid @enderror"
                                                   value="{{ old('email') ?? ($model ? $model->email : null) }}"
                                            >
                                            @error('email')
                                            <small class="form-text text-danger" role="alert">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="phone" class="col-sm-2 col-form-label">{{ __('Contact Phone') }}</label>
                                        <div class="col-sm-4">
                                            <input type="text" id="phone" name="phone" min="0"
                                                   class="form-control @error('phone') is-invalid @enderror"
                                                   value="{{ old('phone') ?? ($model ? $model->phone : null) }}"
                                            >
                                            @error('phone')
                                            <small class="form-text text-danger" role="alert">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="address" class="col-sm-2 col-form-label">{{ __('Contact Address') }}</label>
                                        <div class="col-sm-6">
                                            <textarea name="address" rows="3"
                                                class="form-control @error('address') is-invalid @enderror"
                                            >{{ old('address') ?? ($model ? $model->address : null) }}</textarea>
                                            @error('address')
                                            <small class="form-text text-danger" role="alert">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="comment" class="col-sm-2 col-form-label">{{ __('Contact Comment') }}</label>
                                        <div class="col-sm-6">
                                            <textarea name="comment" rows="5"
                                                      class="form-control @error('comment') is-invalid @enderror"
                                            >{{ old('comment') ?? ($model ? $model->comment : null) }}</textarea>
                                            @error('comment')
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
    <script src="{{asset('js/scripts/password.js')}}"></script>
@endsection
