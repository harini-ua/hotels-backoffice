@extends('admin.layouts.main')

@section('title',  __('Create Page Field'))

@section('style')
    <link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('rightbar-content')
    <div class="contentbar partners-create-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <div class="card m-b-30">
                    <div class="card-header">
                        <h5 class="card-title">{{ __('Page Field') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col s12">
                                <form
                                    id="page-field"
                                    method="POST"
                                    action="{{ route('translations.pages.field.store') }}"
                                >
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group row">
                                        <label for="name" class="col-sm-2 col-form-label">{{ __('Field Name') }} *</label>
                                        <div class="col-sm-4">
                                            <input type="text" id="name" name="name"
                                                   value="{{ old('name') }}"
                                                   class="form-control @error('name') is-invalid @enderror">
                                            @error('name')
                                            <small class="form-text text-danger" role="alert">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="page" class="col-sm-2 col-form-label">{{ __('Page') }} *</label>
                                        <div class="col-sm-4">
                                            <select id="page"
                                                    name="page_id"
                                                    class="form-control select2-single @error('page_id') is-invalid @enderror"
                                                    @if(!$pages->count()) disabled @endif
                                            >
                                                @forelse($pages as $id => $page)
                                                    <option
                                                        value="{{ $id }}"
                                                        @if(old('page_id') == $id) selected @endif
                                                    >{{ $page }}</option>
                                                @empty
                                                    <option>- {{ __('No Data') }} -</option>
                                                @endforelse
                                            </select>
                                            @error('page_id')
                                            <small class="form-text text-danger" role="alert">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="max_length" class="col-sm-2 col-form-label">{{ __('Max Length') }} *</label>
                                        <div class="col-sm-4">
                                            <input type="number"
                                                   id="max_length"
                                                   name="max_length"
                                                   value="{{ old('max_length') }}"
                                                   min="1"
                                                   class="form-control @error('max_length') is-invalid @enderror">
                                            @error('max_length')
                                            <small class="form-text text-danger" role="alert">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="type" class="col-sm-2 col-form-label">{{ __('Field Type') }} *</label>
                                        <div class="col-sm-4">
                                            <select id="type"
                                                    name="type"
                                                    class="form-control select2-single @error('type') is-invalid @enderror"
                                                    @if(!count($fieldTypes)) disabled @endif
                                            >
                                                @foreach($fieldTypes as $id => $type)
                                                    <option
                                                        value="{{ $id }}"
                                                        @if(old('type') == $id) selected @endif
                                                    >{{ $type }}</option>
                                                @endforeach
                                            </select>
                                            @error('type')
                                            <small class="form-text text-danger" role="alert">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="is_mobile" class="col-sm-2 col-form-label">{{ __('Is Mobile Flag') }} *</label>
                                        <div class="col-sm-4">
                                            <select id="is_mobile"
                                                    name="is_mobile"
                                                    class="form-control select2-single @error('is_mobile') is-invalid @enderror"
                                                    @if(!count($verbalType)) disabled @endif
                                            >
                                                @foreach($verbalType as $id => $type)
                                                    <option
                                                        value="{{ $id }}"
                                                        @if(old('is_mobile') == $id) selected @endif
                                                    >{{ $type }}</option>
                                                @endforeach
                                            </select>
                                            @error('is_mobile')
                                            <small class="form-text text-danger" role="alert">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <button class="btn btn-submit">{{ __('Submit') }}</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
