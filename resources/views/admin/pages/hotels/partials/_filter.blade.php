<div class="form-group filter-item col-md-2">
    <label for="company">{{ __('Country') }}</label>
    <select
        id="country"
        name="country"
        class="form-control filter-input select-filter select2-single"
        data-table="hotels-list-datatable"
        data-url="{{ route('hotels.index') }}"
        @if(!count($countries)) disabled @endif
    >
        <option selected value="">{{ __('All') }}</option>
        @foreach($countries as $id => $country)
            <option value="{{ $id }}">{{ $country }}</option>
        @endforeach
    </select>
</div>
<div class="form-group filter-item col-md-2">
    <label for="company">{{ __('City') }}</label>
    <select
        id="city"
        name="city"
        class="form-control filter-input select-filter select2-single"
        data-table="hotels-list-datatable"
        data-url="{{ route('hotels.index') }}"
        @if(!count($cities)) disabled @endif
    >
        <option selected value="">{{ __('All') }}</option>
        @foreach($cities as $id => $city)
            <option value="{{ $id }}">{{ $city }}</option>
        @endforeach
    </select>
</div>
