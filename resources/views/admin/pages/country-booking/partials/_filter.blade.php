<div class="form-group filter-item col-md-2">
    <label for="company">{{ __('By Company Site') }}</label>
    <select
        id="company"
        name="company"
        class="form-control filter-input select-filter select2 select2-single"
        data-table="country-booking-list-datatable"
        data-url="{{ route('reports.country-booking.index') }}"
        @if(!count($companies)) disabled @endif
    >
        <option selected value="">{{ __('All') }}</option>
        @foreach($companies as $id => $company)
            <option value="{{ $id }}">{{ $company }}</option>
        @endforeach
    </select>
</div>
<div class="form-group filter-item col-md-3">
    <label for="country">{{ __('By Country') }}</label>
    <select
        id="country_id"
        name="country"
        class="form-control filter-input select-filter select2-single linked"
        data-table="country-booking-list-datatable"
        data-url="{{ route('reports.country-booking.index') }}"
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
        data-table="country-booking-list-datatable"
        data-url="{{ route('reports.country-booking.index') }}"
        data-linked="country_id"
        @if(!count($cities)) disabled @endif
    >
        <option selected value="">{{ __('All') }}</option>
        @foreach($cities as $id => $city)
            <option value="{{ $id }}">{{ $city }}</option>
        @endforeach
    </select>
</div>
<div class="form-group filter-item mr-1 col-md-3">
    <label for="period">{{ __('By Period') }}</label>
    <div class="input-group">
        <input type="text"
               id="period"
               name="period"
               class="form-control datepicker-filter"
               placeholder="{{ __('Choice First Period') }}"
               aria-describedby="basic-addon7"
               data-table="country-booking-list-datatable"
               data-url="{{ route('reports.country-booking.index') }}"
               value=""
        >
        <div class="input-group-append">
            <span class="input-group-text" id="basic-addon7"><i class="feather icon-calendar"></i></span>
        </div>
    </div>
</div>
<div class="form-group filter-item col-md-3">
    <label for="city">{{ __('By Provider') }}</label>
    <select
        id="city"
        name="city"
        class="form-control filter-input select-filter select2-single"
        data-table="country-booking-list-datatable"
        data-url="{{ route('reports.country-booking.index') }}"
        data-linked="country_id"
        @if(!count($providers)) disabled @endif
    >
        <option selected value="">{{ __('All') }}</option>
        @foreach($providers as $id => $provider)
            <option value="{{ $id }}">{{ $provider }}</option>
        @endforeach
    </select>
</div>
<div class="form-group filter-item mr-1">
    <button class="btn btn-submit" id="submit-btn" style="margin-top: 33px">{{ __('Search') }}</button>
</div>
