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
                   value="{{ old('name') ?? ($model ? $model->theme_name : null ) }}"
            >
            @error('name')
            <small class="form-text text-danger" role="alert">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <button class="btn btn-primary">{{ __('Submit') }}</button>
</form>
