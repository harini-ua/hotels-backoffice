@php($model = $partnerProduct ?? null)
<form
    id="company"
    method="POST"
    action="{{ isset($model) ? route('partners.products.update', $model) : route('partners.products.store') }}"
>
    @csrf
    @if(isset($model)) @method('PUT') @endif
    <div class="form-group row">
        <label for="name" class="col-sm-2 col-form-label">{{ __('Product Name') }} *</label>
        <div class="col-sm-4">
            <input type="text" id="name" name="name"
                   value="{{ old('name') ?? ($model ? $model->name : null ) }}"
                   class="form-control @error('name') is-invalid @enderror">
            @error('name')
            <small class="form-text text-danger" role="alert">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="partner_id" class="col-sm-2 col-form-label">{{ __('Partner') }} *</label>
        <div class="col-sm-4">
            <select
                id="partner_id"
                name="partner_id"
                class="form-control select2-single @error('partner_id') is-invalid @enderror"
            >
                <option selected value="">{{ '- '.__('Choose Partner').' -' }}</option>
                @foreach($partners as $id => $partner)
                    <option
                        value="{{ $id }}"
                        @if(old('partner_id') == $id) selected @endif
                        @if($model && $model->partner_id == $id) selected @endif
                    >{{ $partner }}</option>
                @endforeach
            </select>
            @error('partner_id')
            <small class="form-text text-danger" role="alert">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="code" class="col-sm-2 col-form-label">{{ __('Product ID') }} *</label>
        <div class="col-sm-4">
            <input type="text" id="code" name="code"
                   value="{{ old('code') ?? ($model ? $model->code : null ) }}"
                   class="form-control @error('code') is-invalid @enderror">
            @error('code')
            <small class="form-text text-danger" role="alert">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="meal_plan_id" class="col-sm-2 col-form-label">{{ __('Meal Plan') }} *</label>
        <div class="col-sm-4">
            <select
                id="meal_plan_id"
                name="meal_plan_id"
                class="form-control select2-single @error('meal_plan_id') is-invalid @enderror"
            >
                @foreach($mealPlans as $id => $mealPlan)
                    <option
                        value="{{ $id }}"
                        @if(old('meal_plan_id') == $id) selected @endif
                        @if($model && $model->partner_id == $id) selected @endif
                    >{{ $mealPlan }}</option>
                @endforeach
            </select>
            @error('meal_plan_id')
            <small class="form-text text-danger" role="alert">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="price" class="col-sm-2 col-form-label">{{ __('Price') }} *</label>
        <div class="col-sm-4">
            <input type="number" id="price" name="price" min="0.01" step="0.01"
                   class="form-control @error('price') is-invalid @enderror"
                   placeholder="0,00"
                   value="{{ old('price') ?? ($model ? $model->price : null ) }}"
            >
            @error('price')
            <small class="form-text text-danger" role="alert">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="partner_pay_price" class="col-sm-2 col-form-label">{{ __('Partner Price') }}</label>
        <div class="col-sm-4">
            <input type="number" id="partner_pay_price" name="partner_pay_price" min="0.01" step="0.01"
                   class="form-control @error('partner_pay_price') is-invalid @enderror"
                   placeholder="0,00"
                   value="{{ old('partner_pay_price') ?? ($model ? $model->partner_pay_price : null ) }}"
            >
            <small class="form-text text-muted">{{ __('What partner pays to us') }}</small>
            @error('partner_pay_price')
            <small class="form-text text-danger" role="alert">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="currency_id" class="col-sm-2 col-form-label">{{ __('Currency') }} *</label>
        <div class="col-sm-4">
            <select
                id="currency_id"
                name="currency_id"
                class="form-control select2-single @error('currency_id') is-invalid @enderror"
            >
                <option selected value="">{{ '- '.__('Choose Currency').' -' }}</option>
                @foreach($currencies as $id => $currency)
                    <option
                        value="{{ $id }}"
                        @if(old('currency_id') == $id) selected @endif
                        @if($model && $model->currency_id == $id) selected @endif
                    >{{ $currency }}</option>
                @endforeach
            </select>
            @error('currency_id')
            <small class="form-text text-danger" role="alert">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="commission_min" class="col-sm-2 col-form-label">{{ __('Min Commission') }}</label>
        <div class="col-sm-4">
            <input type="number" id="commission_min" name="commission_min" min="1" max="100"
                   class="form-control @error('commission_min') is-invalid @enderror"
                   value="{{ old('commission_min') ?? ($model ? $model->commission_min : 15 ) }}"
            >
            @error('commission_min')
            <small class="form-text text-danger" role="alert">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="price_filter" class="col-sm-2 col-form-label">{{ __('Price Filter') }}</label>
        <div class="input-group col-sm-4">
            <div class="custom-control custom-checkbox custom-control-inline">
                <input type="checkbox" id="price_filter" name="price_filter"
                       value="1"
                       @if(old('price_filter')) checked @endif
                       @if($model && $model->price_filter) checked @endif
                       class="custom-control-input @error('price_filter') is-invalid @enderror"
                >
                <label class="custom-control-label" for="price_filter">{{ __('Active') }}</label>
            </div>
        </div>
    </div>
    <div class="form-group row price_filter_fields">
        <label for="price_min" class="col-sm-2 col-form-label">{{ __('Min Price') }}</label>
        <div class="col-sm-4">
            <input type="number" id="price_min" name="price_min" min="0.01" step="0.01"
                   class="form-control @error('price_min') is-invalid @enderror"
                   placeholder="0,00"
                   value="{{ old('price_min') ?? ($model ? $model->price_min : null ) }}"
            >
            @error('price_min')
            <small class="form-text text-danger" role="alert">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="form-group row price_filter_fields">
        <label for="price_max" class="col-sm-2 col-form-label">{{ __('Max Price') }}</label>
        <div class="col-sm-4">
            <input type="number" id="price_max" name="price_max" min="0.01" step="0.01"
                   class="form-control @error('price_max') is-invalid @enderror"
                   placeholder="0,00"
                   value="{{ old('price_max') ?? ($model ? $model->price_max : null ) }}"
            >
            @error('price_max')
            <small class="form-text text-danger" role="alert">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="star_filter" class="col-sm-2 col-form-label">{{ __('Star Filter') }}</label>
        <div class="input-group col-sm-4">
            <div class="custom-control custom-checkbox custom-control-inline">
                <input type="checkbox" id="star_filter" name="star_filter"
                       value="1"
                       @if(old('star_filter')) checked @endif
                       @if($model && $model->star_filter) checked @endif
                       class="custom-control-input @error('star_filter') is-invalid @enderror"
                >
                <label class="custom-control-label" for="star_filter">{{ __('Active') }}</label>
            </div>
        </div>
    </div>
    <div class="form-group row star_filter_fields">
        <label for="star_min" class="col-sm-2 col-form-label">{{ __('Min Star') }}</label>
        <div class="col-sm-4">
            <input type="number" id="star_min" name="star_min" min="1" max="5"
                   class="form-control @error('star_min') is-invalid @enderror"
                   value="{{ old('star_min') ?? ($model ? $model->star_min : 1 ) }}"
            >
            @error('star_min')
            <small class="form-text text-danger" role="alert">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="form-group row star_filter_fields">
        <label for="star_max" class="col-sm-2 col-form-label">{{ __('Max Star') }}</label>
        <div class="col-sm-4">
            <input type="number" id="star_max" name="star_max" min="1" max="5"
                   class="form-control @error('star_max') is-invalid @enderror"
                   value="{{ old('star_max') ?? ($model ? $model->star_max : 5 ) }}"
            >
            @error('star_max')
            <small class="form-text text-danger" role="alert">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="nights" class="col-sm-2 col-form-label">{{ __('Nights') }}</label>
        <div class="col-sm-4">
            <input type="number" id="nights" name="nights" min="1"
                   class="form-control @error('nights') is-invalid @enderror"
                   value="{{ old('nights') ?? ($model ? $model->nights : 2 ) }}"
            >
            @error('nights')
            <small class="form-text text-danger" role="alert">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="adults" class="col-sm-2 col-form-label">{{ __('Adults') }}</label>
        <div class="col-sm-4">
            <input type="number" id="adults" name="adults" min="1"
                   class="form-control @error('adults') is-invalid @enderror"
                   value="{{ old('adults') ?? ($model ? $model->adults : 2 ) }}"
            >
            @error('adults')
            <small class="form-text text-danger" role="alert">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="sold_online" class="col-sm-2 col-form-label">{{ __('Sold Online') }}</label>
        <div class="input-group col-sm-4">
            <div class="custom-control custom-checkbox custom-control-inline">
                <input type="checkbox" id="sold_online" name="sold_online"
                       value="1"
                       @if(old('sold_online')) checked @endif
                       @if($model && $model->sold_online) checked @endif
                       @if(!old('sold_online') && !$model) checked @endif
                       class="custom-control-input @error('sold_online') is-invalid @enderror"
                >
                <label class="custom-control-label" for="sold_online"></label>
            </div>
        </div>
    </div>
    <div class="form-group row">
        <label for="sold_retail" class="col-sm-2 col-form-label">{{ __('Sold Rental') }}</label>
        <div class="input-group col-sm-4">
            <div class="custom-control custom-checkbox custom-control-inline">
                <input type="checkbox" id="sold_retail" name="sold_retail"
                       value="1"
                       @if(old('sold_retail')) checked @endif
                       @if($model && $model->sold_retail) checked @endif
                       class="custom-control-input @error('sold_retail') is-invalid @enderror"
                >
                <label class="custom-control-label" for="sold_retail"></label>
            </div>
        </div>
    </div>
    <div class="form-group row">
        <label for="sku" class="col-sm-2 col-form-label">{{ __('SKU') }}</label>
        <div class="col-sm-4">
            <input type="text" id="sku" name="sku"
                   value="{{ old('sku') ?? ($model ? $model->sku : null ) }}"
                   class="form-control @error('sku') is-invalid @enderror">
            @error('sku')
            <small class="form-text text-danger" role="alert">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="comment" class="col-sm-2 col-form-label">{{ __('Comment') }}</label>
        <div class="col-sm-4">
            <textarea id="comment" name="comment" rows="5"
                      class="form-control @error('comment') is-invalid @enderror"
            >{{ old('comment') ?? ($model ? $model->comment : null ) }}</textarea>
            @error('comment')
            <small class="form-text text-danger" role="alert">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="include_nrf" class="col-sm-2 col-form-label">{{ __('Include Non-Refundable') }}</label>
        <div class="input-group col-sm-4">
            <div class="custom-control custom-checkbox custom-control-inline">
                <input type="checkbox" id="include_nrf" name="include_nrf"
                       value="1"
                       @if(old('include_nrf')) checked @endif
                       @if($model && $model->include_nrf) checked @endif
                       class="custom-control-input @error('include_nrf') is-invalid @enderror"
                >
                <label class="custom-control-label" for="include_nrf"></label>
            </div>
        </div>
    </div>
    <div class="form-group row">
        <label for="show_all_as_nrf" class="col-sm-2 col-form-label">{{ __('Show All As Non-Refundable') }}</label>
        <div class="input-group col-sm-4">
            <div class="custom-control custom-checkbox custom-control-inline">
                <input type="checkbox" id="show_all_as_nrf" name="show_all_as_nrf"
                       value="1"
                       @if(old('show_all_as_nrf')) checked @endif
                       @if($model && $model->show_all_as_nrf) checked @endif
                       class="custom-control-input @error('show_all_as_nrf') is-invalid @enderror"
                >
                <label class="custom-control-label" for="show_all_as_nrf"></label>
            </div>
        </div>
    </div>
    <button class="btn btn-submit">{{ __('Submit') }}</button>
</form>
