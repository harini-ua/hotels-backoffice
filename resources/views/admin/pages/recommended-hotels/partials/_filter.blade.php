<div class="form-group filter-item col-md-3">
    <label for="country">{{ __('By Country') }}</label>
    <select
        id="country_id"
        name="country"
        class="form-control filter-input select-filter select2-single linked"
        data-table="recommended-hotels-list-datatable"
        data-url="{{ route('settings.recommended-hotels.index') }}"
        data-action="/countries/[id]/cities"
        data-binded-select="city_id"
        @if(!count($countries)) disabled @endif
    >
        <option selected value="">{{ __('All') }}</option>
        @foreach($countries as $id => $country)
            <option value="{{ $id }}">{{ $country }}</option>
        @endforeach
    </select>
</div>
<div class="form-group filter-item col-md-3">
    <label for="city">{{ __('By City') }}</label>
    <select
        id="city"
        name="city"
        class="form-control filter-input select-filter select2-single"
        data-table="recommended-hotels-list-datatable"
        data-url="{{ route('settings.recommended-hotels.index') }}"
        data-linked="country_id"
        @if(!count($cities)) disabled @endif
    >
        <option selected value="">{{ __('All') }}</option>
        @foreach($cities as $id => $city)
            <option value="{{ $id }}">{{ $city }}</option>
        @endforeach
    </select>
</div>
<div class="form-group filter-item col-md-2">
    <label for="sort">{{ __('By Sort Number') }}</label>
    <select
        id="sort"
        name="sort"
        class="form-control filter-input select-filter select2 custom-select"
        data-table="recommended-hotels-list-datatable"
        data-url="{{ route('settings.recommended-hotels.index') }}"
    >
        <option selected value="">{{ __('All') }}</option>
        @foreach($sortNumbers as $id => $number)
            <option value="{{ $number }}">{{ $number }}</option>
        @endforeach
    </select>
</div>
