@php($model = $recommendedHotel ?? null)
<form
    id="recommended-hotels"
    method="POST"
    action="{{ isset($model) ? route('settings.recommended-hotels.update', $model) : route('settings.recommended-hotels.store') }}"
>
    @csrf
    @if(isset($model)) @method('PUT') @endif
    <div class="form-group row">
        <label for="country_id" class="col-sm-2 col-form-label">{{ __('Country') }} *</label>
        <div class="col-sm-4">
            <select id="country_id"
                name="country_id"
                class="form-control select2-single linked @error('country_id') is-invalid @enderror"
                data-url="/countries/[id]/cities"
                data-binded-select="city_id"
                @if(!count($countries)) disabled @endif
            >
                @if(!count($countries))
                    <option selected value="">{{ __('No Available') }}</option>
                @else
                    <option value="">{{ '- '.__('Choice Country').' -' }}</option>
                    @foreach($countries as $id => $country)
                        <option value="{{ $id }}"
                                @if(old('country_id') == $id) selected @endif
                                @if($model && $model->country_id == $id) selected @endif
                        >{{ $country }}</option>
                    @endforeach
                @endif
            </select>
            @error('country_id')
            <small class="form-text text-danger" role="alert">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="city_id" class="col-sm-2 col-form-label">{{ __('City') }} *</label>
        <div class="col-sm-4">
            <select id="city_id"
                name="city_id"
                class="form-control select2-single linked @error('city_id') is-invalid @enderror"
                data-url="/cities/[id]/hotels"
                data-binded-select="hotel_id"
                data-linked="country_id"
                @if(!count($cities)) disabled @endif
            >
                @if(!count($cities))
                    <option selected value="">{{ __('No Available') }}</option>
                @else
                    <option value="">{{ '- '.__('Choice City').' -' }}</option>
                    @foreach($cities as $id => $city)
                        <option value="{{ $id }}"
                                @if(old('city_id') == $id) selected @endif
                                @if($model && $model->city_id == $id) selected @endif
                        >{{ $city }}</option>
                    @endforeach
                @endif
            </select>
            @error('city_id')
            <small class="form-text text-danger" role="alert">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="hotel_id" class="col-sm-2 col-form-label">{{ __('Hotel') }} *</label>
        <div class="col-sm-4">
            <select id="hotel_id"
                name="hotel_id"
                class="form-control select2-single @error('hotel_id') is-invalid @enderror"
                data-linked="city_id"
                @if(!count($hotels)) disabled @endif
            >
                @if(!count($hotels))
                    <option selected value="">{{ __('No Available Hotels') }}</option>
                @else
                    <option value="">{{ '- '.__('Choice Hotel').' -' }}</option>
                    @foreach($hotels as $id => $hotel)
                        <option value="{{ $id }}"
                                @if(old('hotel_id') == $id) selected @endif
                                @if($model && $model->hotel_id == $id) selected @endif
                        >{{ $hotel }}</option>
                    @endforeach
                @endif
            </select>
            @error('hotel_id')
            <small class="form-text text-danger" role="alert">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="sort" class="col-sm-2 col-form-label">{{ __('Sort Number') }} *</label>
        <div class="col-sm-1">
            <select id="sort"
                    name="sort"
                    class="form-control custom-select @error('hotel_id') is-invalid @enderror"
            >
                @foreach($sortNumbers as $number)
                    <option value="{{ $number }}"
                            @if(old('sort') == $number) selected @endif
                            @if($model && $model->sort == $number) selected @endif
                    >{{ $number }}</option>
                @endforeach
            </select>
            @error('sort')
            <small class="form-text text-danger" role="alert">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <button class="btn btn-submit" id="submit-btn">{{ __('Submit') }}</button>
</form>
