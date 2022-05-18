@php($model = $country ?? null)
<form
    id="country"
    method="POST"
    action="{{ isset($model) ? route('countries.update', $model->id) : route('countries.store') }}"
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
    <button class="btn btn-submit">{{ __('Submit') }}</button>
</form>
