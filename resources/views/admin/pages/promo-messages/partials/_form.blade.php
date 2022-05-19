@php($model = $promoMessage ?? null)
<form
    id="promo-message"
    method="POST"
    action="{{ isset($model) ? route('promo-messages.update', $model) : route('promo-messages.store') }}"
    enctype="multipart/form-data"
>
    @csrf
    @if(isset($model)) @method('PUT') @endif
    <div class="form-group row">
        <label for="headline" class="col-sm-2 col-form-label">{{ __('Headline') }} *</label>
        <div class="col-sm-4">
            <input type="text" id="headline" name="headline"
                   class="form-control @error('headline') is-invalid @enderror"
                   value="{{ old('headline') ?? ($model ? $model->headline : null ) }}"
            >
            @error('headline')
            <small class="form-text text-danger" role="alert">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="content" class="col-sm-2 col-form-label">{{ __('Content') }} *</label>
        <div class="col-sm-4">
            <textarea
                type="text"
                id="content"
                name="content"
                rows="5"
                class="form-control @error('content') is-invalid @enderror"
            >{{ old('content') ?? ($model ? $model->content : null ) }}</textarea>
            @error('content')
            <small class="form-text text-danger" role="alert">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="image" class="col-sm-2 col-form-label">{{ __('Image') }} *</label>
        <div class="col-sm-6">
            <input
                type="file"
                id="image" name="image"
                value="{{ old('image') ?? ($model ? $model->image : null ) }}"
                class="form-control image-input @error('image') is-invalid @enderror"
            >
            @error('image')
            <small class="form-text text-danger" role="alert">{{ $message }}</small>
            @enderror
            <br/>
            <img src="{{ $model ? asset('storage/promo/'.$model->image) : null }}" class="rounded preview">
        </div>
    </div>
    <fieldset class="form-group row">
        <label for="status" class="col-sm-2 col-form-label">{{ __('Status') }} *</label>
        <div class="col-sm-8">
            <div class="form-check">
                <input
                    type="radio"
                    name="status"
                    id="active-status"
                    value="1"
                    @if(old('status') && (int) old('status') === 1)
                        checked
                    @else
                        @if($model && $model->status == 1) checked @endif
                    @endif
                >
                <label class="form-check-label" for="active-status">{{ __('Active') }}</label>
            </div>
            <div class="form-check">
                <input
                    type="radio"
                    name="status"
                    id="inactive-status"
                    value="0"
                    @if(old('status') && (int) old('status') === 0)
                        checked
                    @else
                        @if(!$model)
                            checked
                        @else
                            @if($model && $model->status == 0) checked @endif
                        @endif
                    @endif
                >
                <label class="form-check-label" for="inactive-status">{{ __('Inactive') }}</label>
            </div>
        </div>
    </fieldset>
    <fieldset class="form-group row">
        <label for="translateable" class="col-sm-2 col-form-label">{{ __('Translate') }} *</label>
        <div class="col-sm-8">
            <div class="form-check">
                <input
                    type="radio"
                    name="translateable"
                    id="translateable"
                    value="1"
                    @if(old('translateable') && (int) old('translateable') === 1)
                        checked
                    @else
                        @if($model && $model->translateable == 1) checked @endif
                    @endif
                >
                <label class="form-check-label" for="translateable">{{ __('Translateable') }}</label>
            </div>
            <div class="form-check">
                <input
                    type="radio"
                    name="translateable"
                    id="not-translateable"
                    value="0"
                    @if(old('translateable') && (int) old('translateable') === 0)
                        checked
                    @else
                        @if(!$model)
                            checked
                        @else
                            @if($model && $model->translateable == 0) checked @endif
                        @endif
                    @endif
                >
                <label class="form-check-label" for="not-translateable">{{ __('Not Translateable') }}</label>
            </div>
        </div>
    </fieldset>
    <div class="form-group row">
        <label for="language" class="col-sm-2 col-form-label">{{ __('Language') }} *</label>
        <div class="col-sm-4">
            <select
                id="language"
                name="language_id"
                class="form-control select2-single @error('language_id') is-invalid @enderror"
            >
                <option selected value="">{{ '- '.__('Choose Language').' -' }}</option>
                @foreach($languages as $id => $language)
                    <option
                        value="{{ $id }}"
                        @if(old('language_id') == $id) selected @endif
                        @if($model && $model->language_id == $id) selected @endif
                    >{{ $language }}</option>
                @endforeach
            </select>
            @error('language_id')
            <small class="form-text text-danger" role="alert">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="expiry_date" class="col-sm-2 col-form-label">{{ __('Expiry Date') }} *</label>
        <div class="input-group col-sm-4">
            <input type="text"
                   id="expiry_date"
                   name="expiry_date"
                   class="expiry-date form-control @error('expiry_date') is-invalid @enderror"
                   aria-describedby="basic-addon2"
                   value="{{ old('expiry_date') ?? ($model ? $model->expiry_date->format('d/m/Y') : null ) }}"
                   readonly
            >
            <div class="input-group-append">
                <span class="input-group-text" id="basic-addon2"><i class="feather icon-calendar"></i></span>
            </div>
        </div>
    </div>
    <fieldset class="form-group row">
        <label for="show_all_company" class="col-sm-2 col-form-label">{{ __('Select Company Site') }} *</label>
        <div class="col-sm-8">
            <div class="form-check">
                <input
                    type="radio"
                    name="show_all_company"
                    id="select_all"
                    value="0"
                    @if(old('show_all_company') && (int) old('show_all_company') === 0)
                        checked
                    @else
                        @if(!$model)
                            checked
                        @else
                            @if($model && $model->show_all_company == 0) checked @endif
                        @endif
                    @endif
                >
                <label class="form-check-label" for="select_all">{{ __('Select All') }}</label>
            </div>
            <div class="form-check">
                <input
                    type="radio"
                    name="show_all_company"
                    id="select_custom"
                    value="1"
                    @if(old('show_all_company') && (int) old('show_all_company') === 1)
                        checked
                    @else
                        @if($model && $model->show_all_company == 1) checked @endif
                    @endif
                >
                <label class="form-check-label" for="select_custom">{{ __('Select Custom') }}</label>
            </div>
        </div>
    </fieldset>
    <div class="form-group row">
        <label for="company_ids[]" class="col-sm-2 col-form-label">{{ __('Company Site') }}</label>
        <div class="col-sm-4">
            <select id="company_ids" name="company_ids[]"
                    class="form-control select2-multi-select @error('company_ids') is-invalid @enderror"
                    disabled
                    multiple
            >
                @if(!$companies->count())
                    <option>{{ '- '.__('No Available Company').' -' }}</option>
                @endif
                @foreach($companies as $id => $company)
                    <option
                        value="{{ $id }}"
                        @if($model && in_array($id, $model->companies->pluck('id')->toArray(), true)) selected @endif
                    >{{ $company }}</option>
                @endforeach
            </select>
            @error('company_ids')
            <small class="form-text text-danger" role="alert">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <button class="btn btn-submit">{{ __('Submit') }}</button>
</form>
