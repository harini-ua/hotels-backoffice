<div class="form-group filter-item col-md-2">
    <label for="company">{{ __('By Region') }}</label>
    <select
        id="region"
        name="region"
        class="form-control filter-input select-filter select2-single"
        data-table="countries-list-datatable"
        data-url="{{ route('countries.index') }}"
        @if(!count($regions)) disabled @endif
    >
        <option selected value="">{{ __('All') }}</option>
        @foreach($regions as $id => $region)
            <option value="{{ $id }}">{{ $region }}</option>
        @endforeach
    </select>
</div>
<div class="form-group filter-item col-md-2">
    <label for="company">{{ __('By Currency') }}</label>
    <select
        id="currency"
        name="currency"
        class="form-control filter-input select-filter select2-single"
        data-table="countries-list-datatable"
        data-url="{{ route('countries.index') }}"
        @if(!count($currencies)) disabled @endif
    >
        <option selected value="">{{ __('All') }}</option>
        @foreach($currencies as $id => $currency)
            <option value="{{ $id }}">{{ $currency }}</option>
        @endforeach
    </select>
</div>
<div class="form-group filter-item col-md-2">
    <label for="company">{{ __('By Language') }}</label>
    <select
        id="language"
        name="language"
        class="form-control filter-input select-filter select2-single"
        data-table="countries-list-datatable"
        data-url="{{ route('countries.index') }}"
        @if(!count($languages)) disabled @endif
    >
        <option selected value="">{{ __('All') }}</option>
        @foreach($languages as $id => $language)
            <option value="{{ $id }}">{{ $language }}</option>
        @endforeach
    </select>
</div>
