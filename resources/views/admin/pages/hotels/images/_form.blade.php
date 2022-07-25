<div class="col s12">
    @php($model = $hotel ?? null)
    <form id="hotel" method="POST" action="{{ route('hotels.images.update', $model->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @php($images = $model->images ?? null)
        <div class="images-repeater">
            <div data-repeater-list="images">
                @for($i = 0; $i < $images->count(); $i++)
                    <div @class([
                        'form-row images-wrapper',
                        'first' => $i == 0,
                        'last' => $i == $images->count() - 1,
                        'odd' => $i%2 == 0
                    ]) data-repeater-item>
                        <input type="hidden" name="images[{{ $i }}][id]"
                               value="{{ ((!empty($images) && $images[$i]->id) ? $images[$i]->id : null) }}">
                        <div class="form-group col-md-8">
                            <input type="file"
                                   id="images[{{ $i }}][image]"
                                   name="images[{{ $i }}][image]"
                                   class="form-control image-input @error("images.$i.image")is-invalid @enderror"
                                   value="{{ old("images.$i.image") ?? ((!empty($images) && $images[$i]->image) ? $images[$i]->image : null) }}"
                            >
                            @error('images.'.$i.'.image')
                            <small class="form-text text-danger" role="alert">{{ $message }}</small>
                            @enderror
                            <br/>
                            <img
                                @class(['rounded preview', 'disable' => !$images[$i]->image])
                                src="{{ $images[$i]->image ? (!filter_var($images[$i]->image, FILTER_VALIDATE_URL) ? asset('storage/hotels/'.$hotel->id.'/'.$images[$i]->image) : $images[$i]->image) : null }}"
                            >
                        </div>
                        <div class="form-group col-md-3">
                            <div class="form-check">
                                <input
                                    type="radio"
                                    id="images[{{ $i }}][primary]"
                                    name="images[{{ $i }}][primary]"
                                    class="image-type"
                                    value="1"
                                    @if(old("images.$i.primary") && (int) old("images.$i.primary") === 1)
                                        checked
                                    @else
                                        @if($images && $images[$i]->primary == 1) checked @endif
                                    @endif
                                >
                                <label class="form-check-label" for="images[{{ $i }}][primary]">{{ __('Primary Image') }}</label>
                            </div>
                            @error('images.'.$i.'.primary')
                            <small class="form-text text-danger" role="alert">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group col-md-1">
                            <button type="button" class="btn btn-danger" data-repeater-delete>
                                <i class="feather icon-trash-2"></i>
                            </button>
                        </div>
                    </div>
                @endfor
            </div>
            <div class="form-row">
                <div class="form-group offset-md-11 col-md-1">
                    <button type="button" class="btn btn-success" data-repeater-create>
                        <i class="feather icon-plus"></i>
                    </button>
                </div>
            </div>
        </div>

        <button class="btn btn-submit float-right">{{ __('Submit') }}</button>
    </form>
</div>
