@php($model = $ipFilter ?? null)
<form
    id="ip-filter"
    method="POST"
    action="{{ isset($model) ? route('settings.ip-filter.update', $model) : route('settings.ip-filter.store') }}"
>
    @csrf
    @if(isset($model)) @method('PUT') @endif
    <div class="form-group row">
        <label for="type" class="col-sm-2 col-form-label">{{ __('Type List') }} *</label>
        <div class="col-sm-4">
            <select id="type" name="type"
                    class="form-control select2-single @error('type') is-invalid @enderror"
            >
                @foreach($types as $id => $type)
                    <option
                        value="{{ $id }}"
                        @if($model && $model->type == $id) selected @endif
                    >{{ $type }}</option>
                @endforeach
            </select>
            @error('type')
            <small class="form-text text-danger" role="alert">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="ip_address" class="col-sm-2 col-form-label">{{ __('IP Address') }} *</label>
        <div class="col-sm-4">
            <input type="text" id="ip_address" name="ip_address"
                   value="{{ old('ip_address') ?? ($model ? $model->ip_address : null ) }}"
                   class="form-control @error('ip_address') is-invalid @enderror">
            @error('ip_address')
            <small class="form-text text-danger" role="alert">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="comment" class="col-sm-2 col-form-label">{{ __('Comment') }}</label>
        <div class="col-sm-4">
            <textarea id="comment" name="comment"
                      class="form-control @error('comment') is-invalid @enderror"
            >{{ old('comment') ?? ($model ? $model->comment : null ) }}</textarea>
            @error('comment')
            <small class="form-text text-danger" role="alert">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="is_expiry" class="col-sm-2 col-form-label">{{ __('Expiry') }}</label>
        <div class="input-group col-sm-4">
            <div class="custom-control custom-checkbox custom-control-inline">
                <input type="checkbox" id="is_expiry" name="is_expiry"
                       value="1"
                       @if(old('is_expiry')) checked @endif
                       @if($model && $model->expiry) checked @endif
                       class="custom-control-input @error('is_expiry') is-invalid @enderror"
                />
                <label class="custom-control-label" for="is_expiry"></label>
            </div>
        </div>
    </div>
    <div class="form-group row" style="display: none">
        <label for="expiry" class="col-sm-2 col-form-label">{{ __('Expiry Date') }}</label>
        <div class="col-sm-4">
            <div class="input-group">
                <input type="text" id="expiry" name="expiry"
                       class="datepicker-here form-control @error('expiry') is-invalid @enderror"
                       aria-describedby="basic-addon8"
                       value="{{ old('expiry') ?? ($model ? \Carbon\Carbon::parse($model->expiry)->format('d/m/Y') : null ) }}"
                >
                <div class="input-group-append">
                    <span class="input-group-text" id="basic-addon8"><i class="feather icon-calendar"></i></span>
                </div>
            </div>
            @error('expiry')
            <small class="form-text text-danger" role="alert">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <button class="btn btn-submit">{{ __('Submit') }}</button>
</form>
