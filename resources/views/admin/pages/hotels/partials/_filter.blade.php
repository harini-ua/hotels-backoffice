<div class="form-group filter-item col-md-3">
    <label for="country">{{ __('Country') }}</label>
    <select
        id="country_id"
        name="country"
        class="form-control select2-single linked"
        data-url="/countries/[id]/cities"
        data-binded-select="city_id"
        @if(!count($countries)) disabled @endif
    >
        <option selected value="">{{ __('Choice Country') }}</option>
        @foreach($countries as $id => $country)
            <option value="{{ $id }}">{{ $country }}</option>
        @endforeach
    </select>
</div>
<div class="form-group filter-item col-md-3">
    <label for="city">{{ __('City') }}</label>
    <select
        id="city_id"
        name="city"
        class="form-control select2-single"
        data-linked="country_id"
        @if(!count($cities)) disabled @endif
    >
        <option selected value="">{{ __('Choice City') }}</option>
        @foreach($cities as $id => $city)
            <option value="{{ $id }}">{{ $city }}</option>
        @endforeach
    </select>
</div>
<div class="form-group filter-item mr-1">
    <button class="btn btn-submit"
            id="hotel-submit-btn"
            name="hotel_filter"
            data-type="filter"
            data-table="hotels-list-datatable"
            data-url="{{ route('hotels.index') }}"
            style="margin-top: 33px"><i class="feather icon-search"></i> {{ __('Search') }}
    </button>
</div>
