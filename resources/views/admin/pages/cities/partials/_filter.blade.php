<div class="form-group filter-item col-md-2">
    <label for="company">{{ __('By Country') }}</label>
    <select
        id="country"
        name="country"
        class="form-control filter-input select-filter select2-single"
        data-table="cities-list-datatable"
        data-url="{{ route('cities.index') }}"
        @if(!count($countries)) disabled @endif
    >
        <option selected value="">{{ __('All') }}</option>
        @foreach($countries as $id => $country)
            <option value="{{ $id }}">{{ $country }}</option>
        @endforeach
    </select>
</div>
