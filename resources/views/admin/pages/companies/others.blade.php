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
                            <a class="nav-link mb-2" href="{{ route('companies.hotel-distances.edit', $model) }}">{{ __('Hotel Distances') }}</a>
                            <a class="nav-link mb-2" href="{{ route('companies.customer-supports.edit', $model) }}">{{ __('Customer Supports') }}</a>
                            <a class="nav-link mb-2" href="{{ route('companies.commissions.edit', $model) }}">{{ __('Commissions') }}</a>
                            <a class="nav-link mb-2" href="{{ route('companies.vat.edit', $model) }}">{{ __('VAT') }}</a>
                            <a class="nav-link mb-2" href="{{ route('companies.account.edit', $model) }}">{{ __('Account') }}</a>
                            @if((int) $model->login_type === \App\Enums\AccessCodeType::UNIQUE)
                                <a class="nav-link mb-2" href="{{ route('companies.access-codes.edit', $model) }}">{{ __('Access Codes') }}</a>
                            @endif
                            <a class="nav-link mb-2 active" href="{{ route('companies.others.edit', $model) }}">{{ __('Others') }}</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-7 col-xl-9">
                <div class="tab-content" id="v-pills-tabContent">
                    <div class="tab-pane fade show active" id="v-pills-extra-nights" role="tabpanel" aria-labelledby="v-pills-extra-nights-tab">
                        <div class="card m-b-30">
                            <div class="card-header">
                                <h5 class="card-title mb-0">{{ __('Other Options') }}</h5>
                            </div>
                            <div class="card-body">
                                <form
                                    id="company-others"
                                    method="POST"
                                    action="{{ route('companies.others.update', $model) }}"
                                >
                                    @csrf
                                    @if(isset($model)) @method('PUT') @endif
                                    <div class="form-group row">
                                        <label for="chat_enabled" class="col-sm-2 col-form-label">{{ __('Enable Chat') }}</label>
                                        <div class="input-group col-sm-1">
                                            <div class="custom-control custom-checkbox custom-control-inline">
                                                <input type="checkbox" id="chat_enabled" name="chat_enabled"
                                                       value="1"
                                                       @if(old('chat_enabled')) checked @endif
                                                       @if($mainOptions && $mainOptions->chat_enabled) checked @endif
                                                       class="custom-control-input @error('chat_enabled') is-invalid @enderror"
                                                >
                                                <label class="custom-control-label" for="chat_enabled"></label>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <button type="button"
                                                    id="default_chat"
                                                    class="btn btn-submit"
                                                    data-default="{{ 'https://embed.tawk.to/5947c22350fd5105d0c81c75/default' }}"
                                            >{{ __('Insert Default Chat') }}</button>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="chat_script" class="col-sm-2 col-form-label">{{ __('Chat Script') }}</label>
                                        <div class="col-sm-6">
                                            <textarea id="chat_script" name="chat_script" rows="5"
                                                      class="form-control @error('chat_script') is-invalid @enderror"
                                            >{{ old('chat_script') ?? ($mainOptions ? $mainOptions->chat_script : null ) }}</textarea>
                                            @error('chat_script')
                                            <small class="form-text text-danger" role="alert">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="adobe_enabled" class="col-sm-2 col-form-label">{{ __('Enable Adobe') }}</label>
                                        <div class="input-group col-sm-1">
                                            <div class="custom-control custom-checkbox custom-control-inline">
                                                <input type="checkbox" id="adobe_enabled" name="adobe_enabled"
                                                       value="1"
                                                       @if(old('adobe_enabled')) checked @endif
                                                       @if($mainOptions && $mainOptions->adobe_enabled) checked @endif
                                                       class="custom-control-input @error('adobe_enabled') is-invalid @enderror"
                                                >
                                                <label class="custom-control-label" for="adobe_enabled"></label>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <button type="button"
                                                    id="default_adobe"
                                                    class="btn btn-submit"
                                                    data-default="{{ 'https://assets.adobedtm.com/fdd3d8394b31/69dad4fc44e1/launch-a37b8e230322.min.js' }}"
                                            >{{ __('Insert Default Chat') }}</button>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="adobe_script" class="col-sm-2 col-form-label">{{ __('Adobe Script') }}</label>
                                        <div class="col-sm-6">
                                            <textarea id="adobe_script" name="adobe_script" rows="5"
                                                      class="form-control @error('adobe_script') is-invalid @enderror"
                                            >{{ old('adobe_script') ?? ($mainOptions ? $mainOptions->adobe_script : null ) }}</textarea>
                                            @error('adobe_script')
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
    <script src="{{asset('js/pages/company-other.js')}}"></script>
@endsection
