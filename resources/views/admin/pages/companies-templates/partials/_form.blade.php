@php($model = $template ?? null)
<form
    id="company-themes"
    method="POST"
    action="{{ isset($model) ? route('companies.templates.update', $model->id) : route('companies.templates.store') }}"
>
    @csrf
    @if(isset($model)) @method('PUT') @endif
    <div class="form-group row">
        <label for="name" class="col-sm-2 col-form-label">{{ __('Template Name') }} *</label>
        <div class="col-sm-4">
            <input type="text" id="name" name="name"
                   class="form-control @error('name') is-invalid @enderror"
                   value="{{ old('name') ?? ($model ? $model->name : null) }}"
            >
            @error('name')
            <small class="form-text text-danger" role="alert">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="client_level" class="col-sm-2 col-form-label">{{ __('Client Level') }} *</label>
        <div class="col-sm-4">
            <input type="text" id="client_level" name="client_level"
                   class="form-control @error('client_level') is-invalid @enderror"
                   value="{{ old('client_level') ?? ($model ? $model->client_level : 'level2d') }}"
            >
            @error('client_level')
            <small class="form-text text-danger" role="alert">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="meal_plan_id" class="col-sm-2 col-form-label">{{ __('Meal Plan') }} *</label>
        <div class="col-sm-4">
            <select id="meal_plan_id" name="meal_plan_id" class="form-control @error('meal_plan_id') is-invalid @enderror">
                @foreach($mealPlans as $id => $name)
                    <option value="{{ $id }}"
                            @if($id == old('meal_plan_id')) selected @endif
                            @if($model && $model->meal_plan_id == $id) selected @endif
                    >{{ $name }}</option>
                @endforeach
            </select>
            @error('meal_plan_id')
            <small class="form-text text-danger" role="alert">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="spa_pool_filter" class="col-sm-2 col-form-label">{{ __('Spa, Pool Filters') }} *</label>
        <div class="col-sm-4">
            <select id="spa_pool_filter" name="spa_pool_filter" class="form-control @error('spa_pool_filter') is-invalid @enderror">
                @foreach($spaPoolFilters as $id => $name)
                    <option value="{{ $id }}"
                            @if($id == old('spa_pool_filter')) selected @endif
                            @if($model && $model->spa_pool_filter == $id) selected @endif
                    >{{ $name }}</option>
                @endforeach
            </select>
            @error('spa_pool_filter')
            <small class="form-text text-danger" role="alert">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="system" class="col-sm-2 col-form-label">{{ __('System') }} *</label>
        <div class="col-sm-4">
            <select id="system" name="system" class="form-control @error('system') is-invalid @enderror">
                @foreach($systemTypes as $id => $name)
                    <option value="{{ $id }}"
                            @if($id == old('system')) selected @endif
                            @if($model && $model->system == $id) selected @endif
                    >{{ $name }}</option>
                @endforeach
            </select>
            @error('system')
            <small class="form-text text-danger" role="alert">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="language_id" class="col-sm-2 col-form-label">{{ __('Language') }} *</label>
        <div class="col-sm-4">
            <select id="language_id" name="language_id" class="form-control @error('language_id') is-invalid @enderror">
                @foreach($languages as $id => $name)
                    <option value="{{ $id }}"
                            @if($id == old('language_id')) selected @endif
                            @if($model && $model->language_id == $id) selected @endif
                    >{{ $name }}</option>
                @endforeach
            </select>
            @error('language_id')
            <small class="form-text text-danger" role="alert">{{ $message }}</small>
            @enderror
        </div>
    </div>
    @foreach(\App\Models\CompanyTemplate::getBooleanFoields() as $field => $label)
    <div class="form-group row">
        <label for="{{ $field }}" class="col-sm-2 col-form-label">{{ $label }}</label>
        <div class="input-group col-sm-4">
            <div class="custom-control custom-checkbox custom-control-inline">
                <input type="checkbox" id="{{ $field }}" name="{{ $field }}"
                       value="1"
                       @if(old($field)) checked @endif
                       @if($model && $model->{$field}) checked @endif
                       class="custom-control-input @error('invoice_allowed') is-invalid @enderror"
                />
                <label class="custom-control-label" for="{{ $field }}"></label>
            </div>
        </div>
    </div>
    @endforeach
    <button class="btn btn-submit">{{ __('Submit') }}</button>
</form>
