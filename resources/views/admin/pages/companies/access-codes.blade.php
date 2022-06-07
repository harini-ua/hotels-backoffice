@extends('admin.layouts.main')
@section('title',  __('Update Company Site'))
@section('style')
    <link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/pages/access-codes.css') }}" />
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
                                        <div class="input-group mb-3 col-sm-6">
                                            <input type="number" id="access_codes" name="access_codes" min="1"
                                                   class="form-control @error('access_codes') is-invalid @enderror"
                                                   value="{{ old('access_codes') ?? ($model ? $model->access_codes : null) }}"
                                            >
                                            <div class="input-group-append">
                                                <button class="btn btn-submit" name="update">{{ __('Update Codes') }}</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="input-group col-sm-8">
                                            <table class="table table-hover">
                                                <tbody>
                                                @foreach($accessCodes as $accessCode)
                                                <tr>
                                                    <td class="col-sm-1">{{ __('Date').' :' }}</td>
                                                    <td class="col-sm-2">{{ \App\Services\Formatter::date($accessCode->created_at, 'Y-m-d H:i:s') }}</td>
                                                    <td class="col-sm-2">
                                                        <a class="btn btn-primary-rgba view-access-codes"
                                                           href="{{ route('companies.access-codes.view', [$model, $accessCode]) }}"
                                                        >
                                                            <i class="feather icon-eye"></i>&nbsp;&nbsp;{{ __('View') }}
                                                        </a>
                                                        <a class="btn btn-success-rgba download-access-codes"
                                                                href="{{ route('companies.access-codes.download', [$model, $accessCode]) }}"
                                                        >
                                                            <i class="feather icon-download"></i>&nbsp;&nbsp;{{ __('Download') }}
                                                        </a>
                                                    </td>
                                                </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="codes" class="col-sm-2 col-form-label">{{ __('View Codes').' :' }}</label>
                                        <div class="col-sm-6 mt-1">
                                            <div id="codes" class="form-control textarea-access-codes">{{ '- '.__('No data available').' -' }}</div>
                                        </div>
                                    </div>
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
    <script src="{{asset('js/pages/access-codes.js')}}"></script>
@endsection
