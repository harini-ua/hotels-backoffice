@php($model = $provider ?? null)
<form
    id="provider"
    method="POST"
    action="{{ isset($model) ? route('providers.update', $model->id) : route('providers.store') }}"
>
    @csrf
    @if(isset($model)) @method('PUT') @endif
    <div class="form-group row">
        <label for="name" class="col-sm-2 col-form-label">{{ __('Name') }} *</label>
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
        <label for="description" class="col-sm-2 col-form-label">{{ __('Description') }}</label>
        <div class="col-sm-4">
            <textarea id="description" name="description" rows="3"
                      class="form-control @error('description') is-invalid @enderror"
            >{{ old('description') ?? ($model ? $model->description : null ) }}</textarea>
            @error('description')
            <small class="form-text text-danger" role="alert">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="email" class="col-sm-2 col-form-label">{{ __('Email') }}</label>
        <div class="col-sm-4">
            <input type="email" id="email" name="email"
                   value="{{ old('email') ?? ($model ? $model->email : null ) }}"
                   class="form-control @error('email') is-invalid @enderror">
            @error('email')
            <small class="form-text text-danger" role="alert">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="support_phone" class="col-sm-2 col-form-label">{{ __('Support Phone') }}</label>
        <div class="col-sm-4">
            <input type="text" id="support_phone" name="support_phone"
                   class="form-control @error('support_phone') is-invalid @enderror"
                   value="{{ old('support_phone') ?? ($model ? $model->support_phone : null) }}"
            >
            @error('support_phone')
            <small class="form-text text-danger" role="alert">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="active" class="col-sm-2 col-form-label">{{ __('Active') }}</label>
        <div class="input-group col-sm-4">
            <div class="custom-control custom-checkbox custom-control-inline">
                <input type="checkbox" id="active" name="active"
                       value="1"
                       @if($model && $model->active) checked @endif
                       class="custom-control-input @error('active') is-invalid @enderror"
                />
                <label class="custom-control-label" for="active"></label>
            </div>
        </div>
    </div>
    <button class="btn btn-primary">{{ __('Submit') }}</button>
</form>
