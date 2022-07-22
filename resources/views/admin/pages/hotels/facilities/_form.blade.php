<div class="col s12">
    @php($model = $hotel ?? null)
    <form id="hotel" method="POST" action="{{ route('hotels.facilities.update', $model->id) }}">
        @csrf
        @method('PUT')
        <div class="form-group row">
            <label for="facilities[]" class="col-sm-2 col-form-label">{{ __('Facilities') }}</label>
            <div class="col-sm-10">
                <select id="facilities[]" name="facilities[]"
                        class="form-control select2-multi-select @error('facilities') is-invalid @enderror"
                        @if(!$facilities->count()) disabled @endif
                        multiple
                >
                    @if(!$facilities->count())
                        <option>{{ '- '.__('No Available Facilities').' -' }}</option>
                    @endif
                    @foreach($facilities as $id => $facility)
                        <option
                            value="{{ $id }}"
                            @if($model && in_array($id, $model->facilities->pluck('id')->toArray(), true)) selected @endif
                        >{{ $facility }}</option>
                    @endforeach
                </select>
                @error('facilities')
                <small class="form-text text-danger" role="alert">{{ $message }}</small>
                @enderror
            </div>
        </div>
        <button class="btn btn-submit float-right">{{ __('Submit') }}</button>
    </form>
</div>
