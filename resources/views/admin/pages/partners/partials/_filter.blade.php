<div class="form-group filter-item col-md-2">
    <label for="internal">{{ __('By API Type') }}</label>
    <select
        id="internal"
        name="internal"
        class="form-control filter-input select-filter custom-select"
        data-table="partners-list-datatable"
        data-url="{{ route('partners.index') }}"
    >
        <option selected value="">{{ __('All') }}</option>
        <option value="0">{{ __('External') }}</option>
        <option value="1">{{ __('Internal') }}</option>
    </select>
</div>
