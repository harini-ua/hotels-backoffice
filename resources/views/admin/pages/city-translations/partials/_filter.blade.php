<div class="form-group filter-item col-md-3">
    <label for="company">{{ __('Country') }}</label>
    <select
        id="country_id"
        name="country_id"
        class="form-control filter-input select-filter select2-single"
        data-table="city-translations-list-datatable"
        data-url="{{ route('translations.cities.index') }}"
        @if(!count($countries)) disabled @endif
    >
        <option selected value="">- {{ __('Choice Country') }} -</option>
        @foreach($countries as $id => $country_name)
            <option value="{{ $id }}"
                    @if($country && $country->id == $id) selected @endif
            >{{ $country_name }}</option>
        @endforeach
    </select>
</div>
<div class="form-group filter-item col-md-3">
    <label for="company">{{ __('Language') }}</label>
    <select
        id="language_id"
        name="language_id"
        class="form-control filter-input select-filter select2-single"
        data-table="city-translations-list-datatable"
        data-url="{{ route('translations.cities.index') }}"
        @if(!count($languages)) disabled @endif
    >
        <option selected value="">- {{ __('Choice Language') }} -</option>
        @foreach($languages as $id => $language_name)
            <option value="{{ $id }}"
                    @if($language && $language->id == $id) selected @endif
            >{{ $language_name }}</option>
        @endforeach
    </select>
</div>
<div class="form-group filter-item mr-1">
    <button
        class="btn btn-submit"
        id="get_translations"
        name="get_translations"
        style="margin-top: 33px"
    ><i class="feather icon-search"></i> {{ __('Search') }}</button>
</div>
