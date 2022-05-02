@extends('admin.layouts.main')

@section('title',  __('Update Commissions'))

@section('style')
    <link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('rightbar-content')
    <div class="contentbar settings-commissions-edit-wrapper">
        <div class="row">
            <div class="col-lg-6">
                <div class="card m-b-30">
                    <div class="card-header">
                        <h5 class="card-title">{{ __('City Commissions') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col s12">
                                <form id="settings-cities-commissions" method="POST"
                                      action="{{ route('settings.commissions.cities.update') }}"
                                >
                                    @csrf
                                    @method('PUT')
                                    <div class="form-row">
                                        <div class="form-group col-md-5">
                                            <label>{{ __('City') }}</label>
                                        </div>
                                        <div class="form-group col-md-5">
                                            <label>{{ __('Commission') }}</label>
                                        </div>
                                    </div>
                                    <div class="cities-commissions-repeater">
                                        <div data-repeater-list="cities-commissions">
                                            @for($i = 0; $i < $citiesCommissionsCount; $i++)
                                                <div class="form-row cities-commissions-wrapper" data-repeater-item>
                                                    <div class="form-group col-md-5">
                                                        <select name="cities-commissions[{{ $i }}][city_id]"
                                                                class="form-control select2-single @error('city_id') is-invalid @enderror"
                                                        >
                                                            <option value="">{{ __('Select Country') }}</option>
                                                            @php( $city_id = old("cities-commissions.$i.city_id") )
                                                            @php( $city_id = $citiesCommissions && $citiesCommissions[$i]->city_id ? $citiesCommissions[$i]->city_id : null )
                                                            {{ $city_id }}
                                                            @foreach($cities as $id => $city)
                                                                <option value="{{ $id }}"
                                                                        @if($id === $city_id) selected @endif
                                                                >{{ $city }}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('cities-commissions.'.$i.'.city_id')
                                                        <small class="form-text text-danger" role="alert">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <div class="input-group">
                                                            <input type="number" class="form-control" min="0"
                                                                   name="cities-commissions[{{ $i }}][commission]"
                                                                   value="{{ old("cities-commissions.$i.commission") ?? ((!empty($citiesCommissions) && $citiesCommissions[$i]->commission) ? $citiesCommissions[$i]->commission : null) }}"
                                                            >
                                                            <div class="input-group-append">
                                                                <span class="input-group-text">%</span>
                                                            </div>
                                                        </div>
                                                        @error('cities-commissions.'.$i.'.commission')
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
                                            <div class="form-group offset-md-8 col-md-1">
                                                <button type="button" class="btn btn-success" data-repeater-create>
                                                    <i class="feather icon-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card m-b-30">
                    <div class="card-header">
                        <h5 class="card-title">{{ __('Country Commissions') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col s12">
                                <form id="settings-companies-commissions" method="POST"
                                      action="{{ route('settings.commissions.countries.update') }}"
                                >
                                    @csrf
                                    @method('PUT')
                                    <div class="form-row">
                                        <div class="form-group col-md-5">
                                            <label>{{ __('Country') }}</label>
                                        </div>
                                        <div class="form-group col-md-5">
                                            <label>{{ __('Commission') }}</label>
                                        </div>
                                    </div>
                                    <div class="countries-commissions-repeater">
                                        <div data-repeater-list="countries-commissions">
                                            @for($i = 0; $i < $countriesCommissionsCount; $i++)
                                                <div class="form-row countries-commissions-wrapper" data-repeater-item>
                                                    <div class="form-group col-md-5">
                                                        <select name="countries-commissions[{{ $i }}][country_id]"
                                                                class="form-control select2-single @error('country_id') is-invalid @enderror"
                                                        >
                                                            <option value="">{{ __('Select Country') }}</option>
                                                            @php( $country_id = old("countries-commissions.$i.country_id") )
                                                            @php( $country_id = $countriesCommissions && $countriesCommissions[$i]->country_id ? $countriesCommissions[$i]->country_id : null )
                                                            {{ $country_id }}
                                                            @foreach($countries as $id => $country)
                                                                <option value="{{ $id }}"
                                                                        @if($id === $country_id) selected @endif
                                                                >{{ $country }}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('countries-commissions.'.$i.'.country_id')
                                                        <small class="form-text text-danger" role="alert">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <div class="input-group">
                                                            <input type="number" class="form-control" min="0"
                                                                   name="countries-commissions[{{ $i }}][commission]"
                                                                   value="{{ old("countries-commissions.$i.commission") ?? ((!empty($countriesCommissions) && $countriesCommissions[$i]->commission) ? $countriesCommissions[$i]->commission : null) }}"
                                                            >
                                                            <div class="input-group-append">
                                                                <span class="input-group-text">%</span>
                                                            </div>
                                                        </div>
                                                        @error('countries-commissions.'.$i.'.commission')
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
                                            <div class="form-group offset-md-8 col-md-1">
                                                <button type="button" class="btn btn-success" data-repeater-create>
                                                    <i class="feather icon-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
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
    <script src="{{asset('js/pages/settings-commissions.js')}}"></script>
@endsection
