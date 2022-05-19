@php($model = $city ?? null)
<form
    id="city"
    method="POST"
    action="{{ isset($model) ? route('cities.update', $model->id) : route('cities.store') }}"
>
    @csrf
    @if(isset($model)) @method('PUT') @endif
    <div class="form-group row">
        <label for="name" class="col-sm-2 col-form-label">{{ __('City Name') }}</label>
        <div class="col-sm-4">
            <input type="text" id="name" name="name"
                   value="{{ old('name') ?? ($model ? $model->name : null) }}"
                   class="form-control @error('name') is-invalid @enderror">
            @error('name')
            <small class="form-text text-danger" role="alert">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="state" class="col-sm-2 col-form-label">{{ __('State') }}</label>
        <div class="col-sm-4">
            <input type="text" id="state" name="state"
                   value="{{ old('state') ?? ($model ? $model->state : null) }}"
                   class="form-control @error('state') is-invalid @enderror">
            @error('state')
            <small class="form-text text-danger" role="alert">{{ $message }}</small>
            @enderror
        </div>
    </div>
{{--    <div class="form-group row">--}}
{{--        <label for="country_id" class="col-sm-2 col-form-label">{{ __('Country') }} *</label>--}}
{{--        <div class="col-sm-4">--}}
{{--            <select id="country_id" name="country_id"--}}
{{--                    class="form-control select2-single @error('country_id') is-invalid @enderror"--}}
{{--            >--}}
{{--                <option value="">-- {{ __('Select Country') }} --</option>--}}
{{--                @foreach($countries as $id => $country)--}}
{{--                    <option--}}
{{--                        value="{{ $id }}"--}}
{{--                        @if(old('country_id') == $id) selected @endif--}}
{{--                        @if($model && $model->country_id == $id) selected @endif--}}
{{--                    >{{ $country }}</option>--}}
{{--                @endforeach--}}
{{--            </select>--}}
{{--            @error('country_id')--}}
{{--            <small class="form-text text-danger" role="alert">{{ $message }}</small>--}}
{{--            @enderror--}}
{{--        </div>--}}
{{--    </div>--}}
    <div class="form-group row">
        <label for="country" class="col-sm-2 col-form-label">{{ __('Country') }} *</label>
        <div class="col-sm-4">
            <input type="hidden" id="country_id" name="country_id" value="{{ $model->country_id  }}">
            <input type="text" id="country" name="country"
                   value="{{ $countries[$model->country_id] }}"
                   class="form-control"
                   disabled
            >
        </div>
    </div>
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
        <label for="hotels_count" class="col-sm-2 col-form-label">{{ __('Hotels Count') }}</label>
        <div class="col-sm-4">
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
        <label for="popularity" class="col-sm-2 col-form-label">{{ __('Popularity') }}</label>
        <div class="col-sm-4">
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
    <button class="btn btn-submit">{{ __('Submit') }}</button>
</form>
