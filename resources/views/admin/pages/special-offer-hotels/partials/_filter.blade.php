<div class="form-group filter-item col-md-3">
    <label for="company">{{ __('By Country') }}</label>
    <select
        id="country"
        name="country"
        class="form-control filter-input select-filter select2 select2-single"
        data-table="special-offer-hotels-list-datatable"
        data-url="{{ route('settings.special-offer-hotels.index') }}"
        @if(!count($countries)) disabled @endif
    >
        <option selected value="">{{ __('All') }}</option>
        @foreach($countries as $id => $country)
            <option value="{{ $id }}">{{ $country }}</option>
        @endforeach
    </select>
</div>
<div class="form-group filter-item col-md-3">
    <label for="discount_type">{{ __('By City') }}</label>
    <select
        id="city"
        name="city"
        class="form-control filter-input select-filter select2 select2-single"
        data-table="special-offer-hotels-list-datatable"
        data-url="{{ route('settings.special-offer-hotels.index') }}"
        @if(!count($cities)) disabled @endif
    >
        <option selected value="">{{ __('All') }}</option>
        @foreach($cities as $id => $city)
            <option value="{{ $id }}">{{ $city }}</option>
        @endforeach
    </select>
</div>
<div class="form-group filter-item col-md-2">
    <label for="rating">{{ __('By Rating') }}</label>
    <select
        id="rating"
        name="rating"
        class="form-control filter-input select-filter select2 custom-select"
        data-table="special-offer-hotels-list-datatable"
        data-url="{{ route('settings.special-offer-hotels.index') }}"
    >
        <option selected value="">{{ __('All') }}</option>
        @foreach($ratings as $id => $rating)
            <option value="{{ $id }}">{{ $rating.' '.\Illuminate\Support\Str::plural('Star', $rating) }}</option>
        @endforeach
    </select>
</div>
