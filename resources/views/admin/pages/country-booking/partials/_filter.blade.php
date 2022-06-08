<div class="form-group filter-item col-md-3">
    <label for="company">{{ __('Company Site') }}</label>
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
    <label for="country">{{ __('Country') }}</label>
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
    <label for="city">{{ __('City') }}</label>
    <select
        id="city_id"
        name="city"
        class="form-control filter-input select-filter select2-single linked"
        data-table="country-booking-list-datatable"
        data-url="{{ route('reports.country-booking.index') }}"
        data-linked="country_id"
        data-action="/cities/[id]/hotels"
        data-binded-select="hotels_id"
        @if(!count($cities)) disabled @endif
    >
        <option selected value="">{{ __('All') }}</option>
        @foreach($cities as $id => $city)
            <option value="{{ $id }}">{{ $city }}</option>
        @endforeach
    </select>
</div>
<div class="form-group filter-item col-md-3">
    <label for="hotel">{{ __('Hotel') }}</label>
    <select
        id="hotel"
        name="hotel"
        class="form-control filter-input select-filter select2-single"
        data-table="country-booking-list-datatable"
        data-url="{{ route('reports.country-booking.index') }}"
        data-linked="city_id"
        @if(!count($hotels)) disabled @endif
    >
        <option selected value="">{{ __('All') }}</option>
        @foreach($hotels as $id => $hotel)
            <option value="{{ $id }}">{{ $hotel }}</option>
        @endforeach
    </select>
</div>
<div class="form-group filter-item col-md-2">
    <label for="status">{{ __('Booking Status') }}</label>
    <select
        id="status"
        name="status"
        class="form-control filter-input select-filter select2-single"
        data-table="country-booking-list-datatable"
        data-url="{{ route('reports.country-booking.index') }}"
        @if(!count($statuses)) disabled @endif
    >
        <option selected value="">{{ __('All') }}</option>
        @foreach($statuses as $id => $status)
            <option value="{{ $id }}">{{ $status }}</option>
        @endforeach
    </select>
</div>
<div class="form-group filter-item col-md-2">
    <label for="platform">{{ __('Booking Source') }}</label>
    <select
        id="platform"
        name="platform"
        class="form-control filter-input select-filter select2-single"
        data-table="country-booking-list-datatable"
        data-url="{{ route('reports.country-booking.index') }}"
        @if(!count($platforms)) disabled @endif
    >
        <option selected value="">{{ __('All') }}</option>
        @foreach($platforms as $id => $platform)
            <option value="{{ $id }}">{{ $platform }}</option>
        @endforeach
    </select>
</div>
<div class="form-group filter-item col-md-4">
    <label for="device">{{ __('Device Version') }}</label>
    <select
        id="device"
        name="device"
        class="form-control filter-input select-filter select2-single"
        data-table="country-booking-list-datatable"
        data-url="{{ route('reports.country-booking.index') }}"
        @if(!count($devices)) disabled @endif
    >
        <option selected value="">{{ __('All') }}</option>
        @foreach($devices as $id => $device)
            <option value="{{ $id }}">{{ $device }}</option>
        @endforeach
    </select>
</div>
<div class="form-group filter-item col-md-4"></div>
<div class="form-group filter-item col-md-2">
    <label for="date_type">{{ __('Date Type') }}</label>
    <select
        id="date_type"
        name="date_type"
        class="form-control filter-input select-filter select2-single"
        data-table="country-booking-list-datatable"
        data-url="{{ route('reports.country-booking.index') }}"
        @if(!count($dataTypes)) disabled @endif
    >
        @foreach($dataTypes as $id => $type)
            <option value="{{ $id }}">{{ $type }}</option>
        @endforeach
    </select>
</div>
<div class="form-group filter-item mr-1 col-md-3">
    <label for="period">{{ __('Date Period') }}</label>
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
<div class="form-group filter-item mr-1">
    <button class="btn btn-submit" id="submit-btn" style="margin-top: 33px"><i class="feather icon-calendar"></i>{{ __('Search') }}</button>
</div>
