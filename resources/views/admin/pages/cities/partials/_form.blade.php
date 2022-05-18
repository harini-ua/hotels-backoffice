@php($model = $city ?? null)
<form
    id="city"
    method="POST"
    action="{{ isset($model) ? route('cities.update', $model->id) : route('cities.store') }}"
>
    @csrf
    @if(isset($model)) @method('PUT') @endif
    <div class="form-group row">
        <label for="active" class="col-sm-2 col-form-label">{{ __('Active') }}</label>
        <div class="input-group col-sm-4">
            <div class="custom-control custom-checkbox custom-control-inline">
                <input type="checkbox" id="active" name="active"
                       value="1"
                       @if($model->active) checked @endif
                       class="custom-control-input @error('active') is-invalid @enderror"
                >
                <label class="custom-control-label" for="active"></label>
            </div>
        </div>
    </div>
    <div class="form-group row">
        <label for="position" class="col-sm-2 col-form-label">{{ __('Location') }}</label>
        <div class="col-sm-4">
            <input type="text" id="position" name="position"
                   value="{{ old('position') }}"
                   class="form-control @error('position') is-invalid @enderror">
            <small class="form-text text-muted">{{ __('Latitude and longitude separated by commas') }}</small>
            @error('position')
            <small class="form-text text-danger" role="alert">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <button class="btn btn-submit">{{ __('Submit') }}</button>
</form>
