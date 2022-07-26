<div class="form-group filter-item col-md-2">
    <label for="internal">{{ __('Provider') }}</label>
    <select
        id="provider_id"
        name="provider"
        class="form-control filter-input select-filter custom-select"
        data-url="{{ route('hotels.providers.index') }}"
    >
        <option selected value="">{{ __('All') }}</option>
        @foreach($providers as $id => $provider)
            <option value="{{ $id }}">{{ mb_strtoupper($provider) }}</option>
        @endforeach
    </select>
</div>
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
            data-table="hotels-providers-list-datatable"
            data-url="{{ route('hotels.providers.index') }}"
            style="margin-top: 33px"><i class="feather icon-search"></i> {{ __('Search') }}
    </button>
</div>
