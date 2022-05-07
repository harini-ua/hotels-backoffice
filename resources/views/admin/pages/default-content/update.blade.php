@extends('admin.layouts.main')

@section('title',  __('Update Company Site Default'))

@section('style')
    <link href="{{ asset('assets/plugins/summernote/summernote-bs4.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/pages/default-content.css') }}">
@endsection

@section('rightbar-content')
    <div class="contentbar default-content-edit-wrapper">
        <div class="row">
            <div class="col-lg-12">
                @php($model = $defaultContent ?? null)
                <form id="default-content" method="POST" action="{{ route('settings.default-content.update') }}" enctype="multipart/form-data">
                    @csrf
                    @if(isset($model)) @method('PUT') @endif
                    <div class="card m-b-30">
                        <div class="card-header">
                            <h5 class="card-title">{{ __('Default Content') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col s12">
                                    <div class="form-group row">
                                        <label for="logo" class="col-sm-2 col-form-label">{{ __('Logo') }} *</label>
                                        <div class="col-sm-6">
                                            <input type="file"
                                                   id="logo" name="logo"
                                                   value="{{ old('logo') ?? ($model ? $model->logo : null ) }}"
                                                   class="form-control image-input @error('logo') is-invalid @enderror">
                                            @error('logo')
                                            <small class="form-text text-danger" role="alert">{{ $message }}</small>
                                            @enderror
                                            <br/>
                                            <img src="{{ $model ? asset('storage/default/'.$model->logo) : null }}" class="rounded preview">
                                        </div>
                                    </div>
                                    <button class="btn btn-submit">{{ __('Submit') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card m-b-30">
                        <div class="card-header">
                            <h5 class="card-title">{{ __('Carousel Items') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col s12">
                                    <div class="carousels-repeater">
                                        <div data-repeater-list="carousels">
                                            @for($i = 0; $i < $carousels->count(); $i++)
                                                <div class="form-row carousels-wrapper" data-repeater-item>
                                                    <div class="form-group col-md-4">
                                                        <input type="hidden" name="carousels[{{ $i }}][id]"
                                                               value="{{ ((!empty($carousels) && $carousels[$i]->id) ? $carousels[$i]->id : null) }}"
                                                        >
                                                        <input type="hidden" name="carousels[{{ $i }}][type]"
                                                               value="{{ \App\Enums\CarouselType::Image }}"
                                                               class="carousels-type"
                                                        >
                                                        <label for="carousels[{{ $i }}][image]">{{ __("Image") }}</label>
                                                        <input type="file"
                                                               id="carousels[{{ $i }}][image]"
                                                               name="carousels[{{ $i }}][image]"
                                                               class="form-control image-input @error("carousels.$i.image") is-invalid @enderror"
                                                               value="{{ old("carousels.$i.image") ?? ((!empty($carousels) && $carousels[$i]->image) ? $carousels[$i]->image : null) }}"
                                                        >
                                                        @error('carousels.'.$i.'.image')
                                                        <small class="form-text text-danger" role="alert">{{ $message }}</small>
                                                        @enderror
                                                        <br/>
                                                        <img
                                                            data-name="carousels[{{ $i }}][preview]"
                                                            class="rounded preview"
                                                            src="{{ $model ? asset('storage/default/'.$carousels[$i]->image) : null }}"
                                                        >
                                                    </div>
                                                    <div class="form-group col-md-7">
                                                        <label for="carousels[{{ $i }}][text]">{{ __("Text") }}</label>
                                                        <textarea
                                                            id="carousels[{{ $i }}][text]"
                                                            name="carousels[{{ $i }}][text]"
                                                            class="form-control summernote-editor @error("carousels.$i.text") is-invalid @enderror"
                                                        >{{ old("carousels.$i.text") ?? ((!empty($carousels) && $carousels[$i]->text) ? $carousels[$i]->text : null) }}</textarea>
                                                        @error('carousels.'.$i.'.text')
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
                                    <button class="btn btn-submit">{{ __('Submit') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card m-b-30">
                        <div class="card-header">
                            <h5 class="card-title">{{ __('Teaser Items') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col s12">
                                    <div class="teasers-repeater">
                                        <div data-repeater-list="teasers">
                                            @for($i = 0; $i < $teasers->count(); $i++)
                                                <div class="form-row teasers-wrapper" data-repeater-item>
                                                    <div class="form-group col-md-3">
                                                        <label for="teasers[{{ $i }}][id]">{{ __("Teaser Title") }}</label>
                                                        <input type="hidden" name="teasers[{{ $i }}][id]"
                                                               value="{{ ((!empty($teasers) && $teasers[$i]->id) ? $teasers[$i]->id : null) }}"
                                                        >
                                                        <input type="text"
                                                               id="teasers[{{ $i }}][title]"
                                                               name="teasers[{{ $i }}][title]"
                                                               class="form-control @error("teasers.$i.title") is-invalid @enderror"
                                                               value="{{ old("teasers.$i.title") ?? ((!empty($teasers) && $teasers[$i]->title) ? $teasers[$i]->title : null) }}"
                                                        >
                                                        @error("teasers.$i.title")
                                                        <small class="form-text text-danger" role="alert">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group col-md-2">
                                                        <label for="teasers[{{ $i }}][type]">{{ __("Teaser Type") }}</label>
                                                        <select
                                                            id="teasers[{{ $i }}][type]"
                                                            name="teasers[{{ $i }}][type]"
                                                            class="form-control custom-select @error("teasers.$i.type") is-invalid @enderror"
                                                        >
                                                            @foreach($teaserTypes as $id => $type)
                                                                <option value="{{ $id }}"
                                                                        @if($id === $teasers[$i]->type) selected @endif
                                                                >{{ $type }}</option>
                                                            @endforeach
                                                        </select>
                                                        @error("teasers.$i.type")
                                                        <small class="form-text text-danger" role="alert">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="teasers[{{ $i }}][text]">{{ __("Teaser Text") }}</label>
                                                        <textarea
                                                            id="teasers[{{ $i }}][text]"
                                                            name="teasers[{{ $i }}][text]"
                                                            class="form-control summernote-editor @error("teasers.$i.text") is-invalid @enderror"
                                                        >{{ old("teasers.$i.text") ?? ((!empty($teasers) && $teasers[$i]->text) ? $teasers[$i]->text : null) }}</textarea>
                                                        @error("teasers.$i.text")
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
                                    <button class="btn btn-submit">{{ __('Submit') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('assets/plugins/summernote/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/form-repeater/jquery.repeater.min.js') }}"></script>
    <script src="{{asset('js/pages/default-content.js')}}"></script>
@endsection
