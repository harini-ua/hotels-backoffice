<div class="col s12">
    @php($model = $hotel ?? null)
    <form id="hotel" method="POST" action="{{ route('hotels.images.update', $model->id) }}">
        @csrf
        @method('PUT')
        <div class="form-group row">
            <label for="primary_image_url" class="col-sm-3 col-form-label">{{ __('Thumbnail Image') }}</label>
            <div class="col-sm-6">
                <input
                    type="file" id="primary_image_url" name="primary_image_url"
                    value="{{ old('primary_image_url') ?? ($model ? $model->primary_image_url : null ) }}"
                    class="form-control image-input @error('primary_image_url') is-invalid @enderror"
                >
                @error('primary_image_url')
                <small class="form-text text-danger" role="alert">{{ $message }}</small>
                @enderror
                <br/>
                <img
                    src="{{ ($model->primary_image_url) ? asset('storage/hotels/'.$model->id.'/'.$model->primary_image_url) : null }}"
                    class="rounded preview @if(!$model->thumbnail_image) disable @endif"
                >
            </div>
        </div>
        @php($images = $model->images ?? null)
        <div class="images-repeater">
            <div data-repeater-list="images">
                @for($i = 0; $i < $images->count(); $i++)
                    <div class="form-row images-wrapper @if($i%2 == 0) odd @endif" data-repeater-item>
                        <div class="form-group col-md-4">
                            <input type="file"
                                   id="images[{{ $i }}]"
                                   name="images[{{ $i }}]"
                                   class="form-control image-input @error("images.$i.image") is-invalid @enderror"
                                   value="{{ old("images.$i.image") ?? ((!empty($images) && $images[$i]->image) ? $images[$i]->image : null) }}"
                            >
                            @error('images.'.$i.'.image')
                            <small class="form-text text-danger" role="alert">{{ $message }}</small>
                            @enderror
                            <br/>
                            <img
                                data-name="images[{{ $i }}][preview]"
                                class="rounded preview"
                                src="{{ $images[$i]->image }}"
{{--                                src="{{ $model ? asset('storage/default/'.$images[$i]->image) : null }}"--}}
                            >
                        </div>
                        <div class="form-group col-md-1">
                            <label style="visibility: hidden">{{ __("Actions") }}</label>
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
