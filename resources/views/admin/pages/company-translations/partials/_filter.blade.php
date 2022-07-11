<div class="form-group filter-item col-md-3">
    <label for="company">{{ __('Company') }}</label>
    <select
        id="company_id"
        name="company_id"
        class="form-control filter-input select-filter select2-single"
        data-table="company-translations-list-datatable"
        data-url="{{ route('translations.companies.index') }}"
        @if(!count($companies)) disabled @endif
    >
        <option selected value="">- {{ __('Choice Company') }} -</option>
        @foreach($companies as $id => $name)
            <option value="{{ $id }}"
                    @if($company && $company->id == $id) selected @endif
            >{{ $name }}</option>
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
