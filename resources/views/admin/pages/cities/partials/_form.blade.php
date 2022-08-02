<div class="col s12">
    @php($model = $city ?? null)
    <form
        id="city"
        method="POST"
        action="{{ isset($model) ? route('cities.update', $model->id) : route('cities.store') }}"
    >
        @csrf
        @if(isset($model)) @method('PUT') @endif
        <div class="form-group row">
            <label for="name" class="col-sm-3 col-form-label">{{ __('City Name') }}</label>
            <div class="col-sm-6">
                <input type="text" id="name" name="name"
                       value="{{ old('name') ?? ($model ? $model->name : null) }}"
                       class="form-control @error('name') is-invalid @enderror">
                @error('name')
                <small class="form-text text-danger" role="alert">{{ $message }}</small>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <label for="state" class="col-sm-3 col-form-label">{{ __('State') }}</label>
            <div class="col-sm-6">
                <input type="text" id="state" name="state"
                       value="{{ old('state') ?? ($model ? $model->state : null) }}"
                       class="form-control @error('state') is-invalid @enderror">
                @error('state')
                <small class="form-text text-danger" role="alert">{{ $message }}</small>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <label for="country" class="col-sm-3 col-form-label">{{ __('Country') }}</label>
            <div class="col-sm-6">
                <input type="hidden" id="country_id" name="country_id" value="{{ $model->country_id  }}">
                <input type="text" id="country" name="country"
                       value="{{ $countries[$model->country_id] }}"
                       class="form-control"
                       disabled
                >
            </div>
        </div>
        <div class="form-group row">
            <label for="position" class="col-sm-3 col-form-label">{{ __('Location') }}</label>
            <div class="col-sm-6">
                <input type="text" id="position" name="position"
                       value="{{ old('position') ?? ($model && $model->position ? $model->position->getLat().','.$model->position->getLng() : null) }}"
                       class="form-control @error('position') is-invalid @enderror">
                <small class="form-text text-muted">{{ __('Latitude and longitude separated by commas') }}</small>
                @error('position')
                <small class="form-text text-danger" role="alert">{{ $message }}</small>
                @enderror
            </div>
        </div>
        {{--    <a target="_blank" href="http://www.google.com/maps/place/{{ $model->position->getLat().','.$model->position->getLng() }}">Map</a>--}}
        <div class="form-group row">
            <label for="hotels_count" class="col-sm-3 col-form-label">{{ __('Hotels Count') }}</label>
            <div class="col-sm-6">
                <input type="text" id="hotels_count" name="hotels_count"
                       value="{{ old('hotels_count') ?? ($model ? $model->hotels_count : null) }}"
                       class="form-control @error('hotels_count') is-invalid @enderror"
                       disabled
                >
                @error('hotels_count')
                <small class="form-text text-danger" role="alert">{{ $message }}</small>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <label for="popularity" class="col-sm-3 col-form-label">{{ __('Popularity') }}</label>
            <div class="col-sm-6">
                <input type="number" id="popularity" name="popularity" step="1"
                       value="{{ old('popularity') ?? ($model ? $model->popularity : null) }}"
                       class="form-control @error('popularity') is-invalid @enderror"
                       disabled
                >
                @error('popularity')
                <small class="form-text text-danger" role="alert">{{ $message }}</small>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <label for="commission" class="col-sm-3 col-form-label">{{ __('Commission') }}</label>
            <div class="form-group col-sm-3">
                <div class="input-group">
                    <input type="number" id="commission" name="commission" min="1" max="100"
                           class="form-control @error('commission') is-invalid @enderror"
                           value="{{ old('commission') ?? ($model ? $model->commission : 0 ) }}"
                    >
                    <div class="input-group-append">
                        <span class="input-group-text">%</span>
                    </div>
                </div>
            </div>
        </div>
{{--        <div class="form-group row">--}}
{{--            <label for="active" class="col-sm-3 col-form-label">{{ __('Active') }}</label>--}}
{{--            <div class="input-group col-sm-2">--}}
{{--                <div class="custom-control custom-checkbox custom-control-inline">--}}
{{--                    <input type="checkbox" id="active" name="active"--}}
{{--                           value="1"--}}
{{--                           @if($model->active) checked @endif--}}
{{--                           class="custom-control-input @error('active') is-invalid @enderror"--}}
{{--                    >--}}
{{--                    <label class="custom-control-label" for="active"></label>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
        <div class="form-group row">
            <label for="blacklisted" class="col-sm-3 col-form-label">{{ __('Blacklisted') }}</label>
            <div class="input-group col-sm-2">
                <div class="custom-control custom-checkbox custom-control-inline">
                    <input type="checkbox" id="blacklisted" name="blacklisted"
                           value="1"
                           @if($model->blacklisted) checked @endif
                           class="custom-control-input @error('blacklisted') is-invalid @enderror"
                    >
                    <label class="custom-control-label" for="blacklisted"></label>
                </div>
            </div>
        </div>
        <button class="btn btn-submit">{{ __('Submit') }}</button>
    </form>
</div>
