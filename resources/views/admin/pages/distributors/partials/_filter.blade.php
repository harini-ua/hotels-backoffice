<div class="form-group filter-item col-md-2">
    <label for="company">{{ __('By Company Site') }}</label>
    <select
        id="company"
        name="company"
        class="form-control filter-input select-filter select2 select2-single"
        data-table="distributors-list-datatable"
        data-url="{{ route('distributors.index') }}"
        @if(!count($companies)) disabled @endif
    >
        <option selected value="">{{ __('All') }}</option>
        @foreach($companies as $id => $company)
            <option value="{{ $id }}">{{ $company }}</option>
        @endforeach
    </select>
</div>
<div class="form-group filter-item col-md-2">
    <label for="company">{{ __('By Country') }}</label>
    <select
        id="country"
        name="country"
        class="form-control filter-input select-filter select2 select2-single"
        data-table="distributors-list-datatable"
        data-url="{{ route('distributors.index') }}"
        @if(!count($countries)) disabled @endif
    >
        <option selected value="">{{ __('All') }}</option>
        @foreach($countries as $id => $country)
            <option value="{{ $id }}">{{ $country }}</option>
        @endforeach
    </select>
</div>
<div class="form-group filter-item col-md-2">
    <label for="company">{{ __('By Language') }}</label>
    <select
        id="language"
        name="language"
        class="form-control filter-input select-filter select2 select2-single"
        data-table="distributors-list-datatable"
        data-url="{{ route('distributors.index') }}"
        @if(!count($languages)) disabled @endif
    >
        <option selected value="">{{ __('All') }}</option>
        @foreach($languages as $id => $language)
            <option value="{{ $id }}">{{ $language }}</option>
        @endforeach
    </select>
</div>
