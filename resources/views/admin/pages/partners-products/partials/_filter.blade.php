<div class="form-group filter-item col-md-2">
    <label for="partner">{{ __('By Partner') }}</label>
    <select
        id="partner"
        name="partner"
        class="form-control filter-input select-filter select2 select2-single"
        data-table="partners-products-list-datatable"
        data-url="{{ route('partners.products.index') }}"
    >
        <option selected value="">{{ __('All') }}</option>
        @foreach($partners as $id => $partner)
            <option value="{{ $id }}">{{ $partner }}</option>
        @endforeach
    </select>
</div>
<div class="form-group filter-item col-md-2">
    <label for="meal_plan">{{ __('By Meal Plan') }}</label>
    <select
        id="meal_plan"
        name="meal_plan"
        class="form-control filter-input select-filter custom-select"
        data-table="partners-products-list-datatable"
        data-url="{{ route('partners.products.index') }}"
    >
        <option selected value="">{{ __('All') }}</option>
        @foreach($mealPlans as $id => $mealPlan)
            <option value="{{ $id }}">{{ $mealPlan }}</option>
        @endforeach
    </select>
</div>
<div class="form-group filter-item col-md-2">
    <label for="currency">{{ __('By Currency') }}</label>
    <select
        id="currency"
        name="currency"
        class="form-control filter-input select-filter select2 select2-single"
        data-table="partners-products-list-datatable"
        data-url="{{ route('partners.products.index') }}"
    >
        <option selected value="">{{ __('All') }}</option>
        @foreach($currencies as $id => $currency)
            <option value="{{ $id }}">{{ $currency }}</option>
        @endforeach
    </select>
</div>
