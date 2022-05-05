@php($model = $companyDefault ?? null)
<form id="default-content" method="POST" action="{{ route('settings.default-content.update') }}" enctype="multipart/form-data">
    @csrf
    @if(isset($model)) @method('PUT') @endif
    <div class="form-group row">
        <label for="logo" class="col-sm-2 col-form-label">{{ __('Logo') }} *</label>
        <div class="col-sm-6">
            <input type="file" id="logo" name="logo"
                   value="{{ old('logo') ?? ($model ? $model->logo : null ) }}"
                   class="form-control image-input @error('logo') is-invalid @enderror">
            @error('logo')
            <small class="form-text text-danger" role="alert">{{ $message }}</small>
            @enderror
            <br/>
            <img src="{{ $model ? asset('storage/company/default/'.$model->logo) : null }}" class="rounded preview">
        </div>
    </div>
    <div class="form-group row">
        <label for="testimonial_heading_1" class="col-sm-2 col-form-label">{{ __('Testimonial Heading #1') }}</label>
        <div class="col-sm-10">
            <textarea id="testimonial_heading_1" name="testimonial_heading_1"
                      class="form-control tinymce-editor @error('testimonial_heading_1') is-invalid @enderror"
            >{{ old('testimonial_heading_1') ?? ($model ? $model->testimonial_heading_1 : null ) }}</textarea>
            @error('testimonial_heading_1')
            <small class="form-text text-danger" role="alert">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="testimonial_heading_2" class="col-sm-2 col-form-label">{{ __('Testimonial Heading #2') }}</label>
        <div class="col-sm-10">
            <textarea id="testimonial_heading_2" name="testimonial_heading_2"
                      class="form-control tinymce-editor @error('testimonial_heading_2') is-invalid @enderror"
            >{{ old('testimonial_heading_2') ?? ($model ? $model->testimonial_heading_2 : null ) }}</textarea>
            @error('testimonial_heading_2')
            <small class="form-text text-danger" role="alert">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="main_page_picture" class="col-sm-2 col-form-label">{{ __('Main Page Picture') }} *</label>
        <div class="col-sm-6">
            <input type="file" id="main_page_picture" name="main_page_picture"
                   value="{{ old('main_page_picture') ?? ($model ? $model->main_page_picture : null ) }}"
                   class="form-control image-input @error('main_page_picture') is-invalid @enderror">
            @error('main_page_picture')
            <small class="form-text text-danger" role="alert">{{ $message }}</small>
            @enderror
            <br/>
            <img src="{{ $model ? asset('storage/company/default/'.$model->main_page_picture) : null }}" class="rounded preview">
        </div>
    </div>
    <div class="form-group row">
        <label for="main_page_heading_1" class="col-sm-2 col-form-label">{{ __('Main Page Heading #1') }}</label>
        <div class="col-sm-10">
            <textarea id="main_page_heading_1" name="main_page_heading_1"
                      class="form-control tinymce-editor @error('main_page_heading_1') is-invalid @enderror"
            >{{ old('main_page_heading_1') ?? ($model ? $model->main_page_heading_1 : null ) }}</textarea>
            @error('main_page_heading_1')
            <small class="form-text text-danger" role="alert">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="main_page_heading_2" class="col-sm-2 col-form-label">{{ __('Main Page Heading #2') }}</label>
        <div class="col-sm-10">
            <textarea id="main_page_heading_2" name="main_page_heading_2"
                      class="form-control tinymce-editor @error('main_page_heading_2') is-invalid @enderror"
            >{{ old('main_page_heading_2') ?? ($model ? $model->main_page_heading_2 : null ) }}</textarea>
            @error('main_page_heading_2')
            <small class="form-text text-danger" role="alert">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="main_page_heading_3" class="col-sm-2 col-form-label">{{ __('Main Page Heading #3') }}</label>
        <div class="col-sm-10">
            <textarea id="main_page_heading_3" name="main_page_heading_3"
                      class="form-control tinymce-editor @error('main_page_heading_3') is-invalid @enderror"
            >{{ old('main_page_heading_3') ?? ($model ? $model->main_page_heading_3 : null ) }}</textarea>
            @error('main_page_heading_3')
            <small class="form-text text-danger" role="alert">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="picture_1" class="col-sm-2 col-form-label">{{ __('Picture #1') }} *</label>
        <div class="col-sm-6">
            <input type="file" id="picture_1" name="picture_1"
                   value="{{ old('picture_1') ?? ($model ? $model->picture_1 : null ) }}"
                   class="form-control image-input @error('picture_1') is-invalid @enderror">
            @error('picture_1')
            <small class="form-text text-danger" role="alert">{{ $message }}</small>
            @enderror
            <br/>
            <img src="{{ $model ? asset('storage/company/default/'.$model->picture_1) : null }}" class="rounded preview">
        </div>
    </div>
    <div class="form-group row">
        <label for="text_picture_1" class="col-sm-2 col-form-label">{{ __('Text Picture #1') }}</label>
        <div class="col-sm-10">
            <textarea id="text_picture_1" name="text_picture_1"
                      class="form-control tinymce-editor @error('text_picture_1') is-invalid @enderror"
            >{{ old('text_picture_1') ?? ($model ? $model->text_picture_1 : null ) }}</textarea>
            @error('text_picture_1')
            <small class="form-text text-danger" role="alert">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="picture_2" class="col-sm-2 col-form-label">{{ __('Picture #2') }} *</label>
        <div class="col-sm-6">
            <input type="file" id="picture_2" name="picture_2"
                   value="{{ old('picture_2') ?? ($model ? $model->picture_2 : null ) }}"
                   class="form-control image-input @error('picture_2') is-invalid @enderror">
            @error('picture_2')
            <small class="form-text text-danger" role="alert">{{ $message }}</small>
            @enderror
            <br/>
            <img src="{{ $model ? asset('storage/company/default/'.$model->picture_2) : null }}" class="rounded preview">
        </div>
    </div>
    <div class="form-group row">
        <label for="text_picture_2" class="col-sm-2 col-form-label">{{ __('Text Picture #2') }}</label>
        <div class="col-sm-10">
            <textarea id="text_picture_2" name="text_picture_2"
                      class="form-control tinymce-editor @error('text_picture_2') is-invalid @enderror"
            >{{ old('text_picture_2') ?? ($model ? $model->text_picture_2 : null ) }}</textarea>
            @error('text_picture_2')
            <small class="form-text text-danger" role="alert">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="picture_3" class="col-sm-2 col-form-label">{{ __('Picture #3') }} *</label>
        <div class="col-sm-6">
            <input type="file" id="picture_3" name="picture_3"
                   value="{{ old('picture_3') ?? ($model ? $model->picture_3 : null ) }}"
                   class="form-control image-input @error('picture_3') is-invalid @enderror">
            @error('picture_3')
            <small class="form-text text-danger" role="alert">{{ $message }}</small>
            @enderror
            <br/>
            <img src="{{ $model ? asset('storage/company/default/'.$model->picture_3) : null }}" class="rounded preview">
        </div>
    </div>
    <div class="form-group row">
        <label for="text_picture_3" class="col-sm-2 col-form-label">{{ __('Text Picture #3') }}</label>
        <div class="col-sm-10">
            <textarea id="text_picture_3" name="text_picture_3"
                      class="form-control tinymce-editor @error('text_picture_3') is-invalid @enderror"
            >{{ old('text_picture_3') ?? ($model ? $model->text_picture_3 : null ) }}</textarea>
            @error('text_picture_3')
            <small class="form-text text-danger" role="alert">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="picture_4" class="col-sm-2 col-form-label">{{ __('Picture #4') }} *</label>
        <div class="col-sm-6">
            <input type="file" id="picture_4" name="picture_4"
                   value="{{ old('picture_4') ?? ($model ? $model->picture_4 : null ) }}"
                   class="form-control image-input @error('picture_4') is-invalid @enderror">
            @error('picture_4')
            <small class="form-text text-danger" role="alert">{{ $message }}</small>
            @enderror
            <br/>
            <img src="{{ $model ? asset('storage/company/default/'.$model->picture_4) : null }}" class="rounded preview">
        </div>
    </div>
    <div class="form-group row">
        <label for="text_picture_4" class="col-sm-2 col-form-label">{{ __('Text Picture #4') }}</label>
        <div class="col-sm-10">
            <textarea id="text_picture_4" name="text_picture_4"
                      class="form-control tinymce-editor @error('text_picture_4') is-invalid @enderror"
            >{{ old('text_picture_4') ?? ($model ? $model->text_picture_4 : null ) }}</textarea>
            @error('text_picture_4')
            <small class="form-text text-danger" role="alert">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="picture_5" class="col-sm-2 col-form-label">{{ __('Picture #5') }} *</label>
        <div class="col-sm-6">
            <input type="file" id="picture_5" name="picture_5"
                   value="{{ old('picture_5') ?? ($model ? $model->picture_5 : null ) }}"
                   class="form-control image-input @error('picture_5') is-invalid @enderror">
            @error('picture_5')
            <small class="form-text text-danger" role="alert">{{ $message }}</small>
            @enderror
            <br/>
            <img src="{{ $model ? asset('storage/company/default/'.$model->picture_5) : null }}" class="rounded preview">
        </div>
    </div>
    <div class="form-group row">
        <label for="text_picture_1" class="col-sm-2 col-form-label">{{ __('Text Picture #5') }}</label>
        <div class="col-sm-10">
            <textarea id="text_picture_5" name="text_picture_5"
                      class="form-control tinymce-editor @error('text_picture_5') is-invalid @enderror"
            >{{ old('text_picture_5') ?? ($model ? $model->text_picture_5 : null ) }}</textarea>
            @error('text_picture_5')
            <small class="form-text text-danger" role="alert">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="right_heading_1" class="col-sm-2 col-form-label">{{ __('Right Heading #1') }} *</label>
        <div class="col-sm-4">
            <input type="text" id="right_heading_1" name="right_heading_1"
                   value="{{ old('right_heading_1') ?? ($model ? $model->right_heading_1 : null ) }}"
                   class="form-control @error('right_heading_1') is-invalid @enderror">
            @error('right_heading_1')
            <small class="form-text text-danger" role="alert">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="right_heading_message_1" class="col-sm-2 col-form-label">{{ __('Right Heading Message #1') }}</label>
        <div class="col-sm-10">
                <textarea id="right_heading_message_1" name="right_heading_message_1"
                          class="form-control tinymce-editor @error('right_heading_message_1') is-invalid @enderror"
                >{{ old('right_heading_message_1') ?? ($model ? $model->right_heading_message_1 : null ) }}</textarea>
            @error('right_heading_message_1')
            <small class="form-text text-danger" role="alert">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="right_heading_2" class="col-sm-2 col-form-label">{{ __('Right Heading #2') }} *</label>
        <div class="col-sm-4">
            <input type="text" id="right_heading_2" name="right_heading_2"
                   value="{{ old('right_heading_2') ?? ($model ? $model->right_heading_2 : null ) }}"
                   class="form-control @error('right_heading_2') is-invalid @enderror">
            @error('right_heading_2')
            <small class="form-text text-danger" role="alert">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="right_heading_message_2" class="col-sm-2 col-form-label">{{ __('Right Heading Message #2') }}</label>
        <div class="col-sm-10">
                <textarea id="right_heading_message_2" name="right_heading_message_2"
                          class="form-control tinymce-editor @error('right_heading_message_2') is-invalid @enderror"
                >{{ old('right_heading_message_2') ?? ($model ? $model->right_heading_message_2 : null ) }}</textarea>
            @error('right_heading_message_2')
            <small class="form-text text-danger" role="alert">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <button class="btn btn-submit">{{ __('Submit') }}</button>
</form>
