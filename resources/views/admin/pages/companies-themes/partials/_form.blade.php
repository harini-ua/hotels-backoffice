@php($model = $theme ?? null)
<form
    id="company-themes"
    method="POST"
    action="{{ isset($model) ? route('companies.themes.update', $model->id) : route('companies.themes.store') }}"
>
    @csrf
    @if(isset($model)) @method('PUT') @endif
    <div class="form-group row">
        <label for="theme_name" class="col-sm-2 col-form-label">{{ __('Theme Name') }} *</label>
        <div class="col-sm-4">
            <input type="text" id="theme_name" name="theme_name"
                   class="form-control @error('theme_name') is-invalid @enderror"
                   value="{{ old('theme_name') ?? ($model ? $model->theme_name : null ) }}"
            >
            @error('theme_name')
            <small class="form-text text-danger" role="alert">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="theme_color" class="col-sm-2 col-form-label">{{ __('Theme Color') }} *</label>
        <div class="col-sm-4">
            <input type="color" id="theme_color" name="theme_color"
                   class="form-control @error('theme_color') is-invalid @enderror"
                   value="{{ old('theme_color') ?? ($model ? $model->theme_color : null ) }}"
            >
            @error('theme_color')
            <small class="form-text text-danger" role="alert">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="default" class="col-sm-2 col-form-label">{{ __('Use as default') }}</label>
        <div class="input-group col-sm-4">
            <div class="custom-control custom-checkbox custom-control-inline">
                <input type="checkbox" id="default" name="default"
                       value="1"
                       @if($model && $model->default) checked @endif
                       class="custom-control-input @error('default') is-invalid @enderror"
                >
                <label class="custom-control-label" for="default"></label>
            </div>
        </div>
    </div>
    <button class="btn btn-submit">{{ __('Submit') }}</button>
</form>
