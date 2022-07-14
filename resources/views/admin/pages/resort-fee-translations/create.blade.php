@extends('admin.layouts.main')

@section('title',  __('Create Resort Fee Translation'))

@section('style')
    <link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" type="text/css" href="{{ asset('css/pages/resort-fee-translations.css') }}">
@endsection

@section('rightbar-content')
    <div class="contentbar resort-fee-translations-create-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <div class="card m-b-30">
                    <div class="card-header">
                        <h5 class="card-title">{{ __('Resort Fee Translation') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col s12">
                                <form
                                    id="page-field"
                                    method="POST"
                                    action="{{ route('translations.resort-fee.store') }}"
                                >
                                    @csrf
                                    <div class="form-group row">
                                        <label for="country_id" class="col-sm-2 col-form-label">{{ __('Country') }} *</label>
                                        <div class="col-sm-4">
                                            <select
                                                id="country_id"
                                                name="country_id"
                                                class="form-control select2-single linked @error('country_id') is-invalid @enderror"
                                                data-url="/countries/[id]/cities"
                                                data-binded-select="city_id"
                                                @if(!count($countries)) disabled @endif
                                            >
                                                <option selected value="">-- {{ __('Choice Country') }} --</option>
                                                @foreach($countries as $id => $country)
                                                    <option
                                                        value="{{ $id }}"
                                                        @if(old('country_id') == $id) selected @endif
                                                    >{{ $country }}</option>
                                                @endforeach
                                            </select>
                                            @error('country_id')
                                            <small class="form-text text-danger" role="alert">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="city_id" class="col-sm-2 col-form-label">{{ __('City') }} *</label>
                                        <div class="col-sm-4">
                                            <select
                                                id="city_id"
                                                name="city_id"
                                                class="form-control select2-single"
                                                data-linked="country_id"
                                                disabled
                                            >
                                                <option selected value="">{{ __('Choice City') }}</option>
                                                @foreach($cities as $id => $city)
                                                    <option
                                                        value="{{ $id }}"
                                                        @if(old('city_id') == $id) selected @endif
                                                    >{{ $city }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="translation" class="col-sm-2 col-form-label">{{ __('Resort Fee') }} *</label>
                                        <div class="col-sm-4">
                                            <input type="text" id="translation" name="translation"
                                                   value="{{ old('translation') }}"
                                                   class="form-control @error('name') is-invalid @enderror">
                                            @error('name')
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
    <script src="{{asset('js/scripts/related-select.js')}}"></script>
    <script src="{{asset('js/pages/resort-fee-translations.js')}}"></script>
@endsection
