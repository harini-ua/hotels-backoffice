@php($model = $specialOfferHotel ?? null)
<form
    id="special-offer-hotels"
    method="POST"
    action="{{ isset($model) ? route('settings.special-offer-hotels.update', $model->id) : route('settings.special-offer-hotels.store') }}"
>
    @csrf
    @if(isset($model)) @method('PUT') @endif
    <div class="form-group row">
        <label for="country_id" class="col-sm-2 col-form-label">{{ __('Country') }} *</label>
        <div class="col-sm-4">
            <select id="country_id" name="country_id"
                    class="form-control select2-single @error('country_id') is-invalid @enderror"
            >
                <option value="">{{ '- '.__('Choice Country').' -' }}</option>
                @foreach($countries as $id => $country)
                    <option value="{{ $id }}" @if(old('country_id') == $id) selected @endif>{{ $country }}</option>
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
            <select id="city_id" name="city_id"
                    class="form-control select2-single @error('city_id') is-invalid @enderror"
            >
                <option value="">{{ '- '.__('Choice City').' -' }}</option>
                @foreach($cities as $id => $city)
                    <option value="{{ $id }}" @if(old('city_id') == $id) selected @endif>{{ $city }}</option>
                @endforeach
            </select>
            @error('city_id')
            <small class="form-text text-danger" role="alert">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="hotel_id" class="col-sm-2 col-form-label">{{ __('Hotel') }} *</label>
        <div class="col-sm-4">
            <select id="hotel_id" name="hotel_id"
                    class="form-control select2-single @error('hotel_id') is-invalid @enderror"
            >
                <option value="">{{ '- '.__('Choice Hotel').' -' }}</option>
                @foreach($hotels as $id => $hotel)
                    <option value="{{ $id }}" @if(old('hotel_id') == $id) selected @endif>{{ $hotel }}</option>
                @endforeach
            </select>
            @error('hotel_id')
            <small class="form-text text-danger" role="alert">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="rating" class="col-sm-2 col-form-label">{{ __('Rating') }} *</label>
        <div class="col-sm-4">
            <div class="stars stars-example-fontawesome">
                <select id="rating" name="rating" autocomplete="off">
                    @foreach($ratings as $rating)
                        <option value="{{ $rating }}"
                                @if(old('rating') == $rating) selected @endif
                        >{{ $rating }}</option>
                    @endforeach
                </select>
            </div>
            @error('hotel_id')
            <small class="form-text text-danger" role="alert">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <button class="btn btn-submit" id="submit-btn">{{ __('Submit') }}</button>
</form>
