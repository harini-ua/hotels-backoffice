@php($model = $partner ?? null)
<form
    id="company"
    method="POST"
    action="{{ isset($model) ? route('partners.update', $model) : route('partners.store') }}"
>
    @csrf
    @if(isset($model)) @method('PUT') @endif
    <div class="form-group row">
        <label for="name" class="col-sm-2 col-form-label">{{ __('Name') }} *</label>
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
        <label for="description" class="col-sm-2 col-form-label">{{ __('Description') }}</label>
        <div class="col-sm-4">
            <textarea id="description" name="description"
                      class="form-control @error('description') is-invalid @enderror"
            >{{ old('description') ?? ($model ? $model->description : null ) }}</textarea>
            @error('description')
            <small class="form-text text-danger" role="alert">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="internal" class="col-sm-2 col-form-label">{{ __('Internal') }}</label>
        <div class="input-group col-sm-4">
            <div class="custom-control custom-checkbox custom-control-inline">
                <input type="checkbox" id="internal" name="internal"
                       value="1"
                       @if($model && $model->internal) checked @endif
                       class="custom-control-input @error('internal') is-invalid @enderror"
                >
                <label class="custom-control-label" for="internal"></label>
            </div>
        </div>
    </div>
    <button class="btn btn-primary">{{ __('Submit') }}</button>
</form>
