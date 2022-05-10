@extends('admin.layouts.main')

@section('title',  __('Update Company Site'))

@section('style')
    <link href="{{ asset('assets/plugins/summernote/summernote-bs4.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/pages/company-homepage.css') }}">
@endsection

@section('rightbar-content')
    @php($model = $company ?? null)
    <div class="contentbar companies-edit-wrapper">
        <div class="row">
            <div class="col-lg-5 col-xl-3">
                <div class="card m-b-30">
                    <div class="card-header">
                        <h5 class="card-title mb-0">{{ $model->company_name }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                            <a class="nav-link mb-2" href="{{ route('companies.general.edit', $model) }}">{{ __('General') }}</a>
                            <a class="nav-link mb-2" href="{{ route('companies.contact.edit', $model) }}">{{ __('Contact Info') }}</a>
                            <a class="nav-link mb-2 active" href="{{ route('companies.homepage.edit', $model) }}">{{ __('Homepage') }}</a>
                            <a class="nav-link mb-2" href="{{ route('companies.extra-nights.edit', $model) }}">{{ __('Extra Nights') }}</a>
                            <a class="nav-link mb-2" href="{{ route('companies.prefilled-options.edit', $model) }}">{{ __('Pre Filled Options') }}</a>
                            <a class="nav-link mb-2" href="{{ route('companies.hotel-distances.edit', $model) }}">{{ __('Hotel Distances') }}</a>
                            <a class="nav-link mb-2" href="{{ route('companies.customer-supports.edit', $model) }}">{{ __('Customer Supports') }}</a>
                            <a class="nav-link mb-2" href="{{ route('companies.commissions.edit', $model) }}">{{ __('Commissions') }}</a>
                            <a class="nav-link mb-2" href="{{ route('companies.vat.edit', $model) }}">{{ __('VAT') }}</a>
                            <a class="nav-link mb-2" href="{{ route('companies.account.edit', $model) }}">{{ __('Account') }}</a>
                            @if((int) $model->login_type === \App\Enums\AccessCodeType::UNIQUE)
                                <a class="nav-link mb-2" href="{{ route('companies.access-codes.edit', $model) }}">{{ __('Access Codes') }}</a>
                            @endif
                            <a class="nav-link mb-2" href="{{ route('companies.others.edit', $model) }}">{{ __('Others') }}</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-7 col-xl-9">
                <div class="tab-content" id="v-pills-tabContent">
                    <div class="tab-pane fade show active" id="v-pills-extra-nights" role="tabpanel" aria-labelledby="v-pills-extra-nights-tab">
                        @php($model = $homepageOptions ?? null)
                        <form
                            id="company-homepage"
                            method="POST"
                            action="{{ route('companies.homepage.update', $model) }}"
                            enctype="multipart/form-data"
                        >
                            @csrf
                            @if(isset($model)) @method('PUT') @endif
                            <div class="card m-b-30">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">{{ __('General Option') }}</h5>
                                </div>
                                <div class="card-body">
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
                                            <img src="{{ $model ? asset('storage/companies/'.$company->id.'/'.$model->logo) : null }}" class="rounded preview">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="theme_id" class="col-sm-2 col-form-label">{{ __('Theme') }} *</label>
                                        <div class="col-sm-4">
                                            <select id="theme_id" name="theme_id"
                                                    class="form-control @error('theme_id') is-invalid @enderror"
                                                    @if(!$themes->count()) disabled @endif
                                            >
                                                @if(!$themes->count())
                                                    <option>{{ '- '.__('No Available Theme').' -' }}</option>
                                                @endif
                                                @foreach($themes as $id => $name)
                                                    <option
                                                        value="{{ $id }}"
                                                        @if(old('theme_id') == $id) selected @endif
                                                        @if($model && $model->theme_id == $id) selected @endif
                                                    >{{ $name }}</option>
                                                @endforeach
                                            </select>
                                            @error('theme_id')
                                            <small class="form-text text-danger" role="alert">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <button class="btn btn-submit">{{ __('Submit') }}</button>
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
                                                    @php($carousels = $model->carousel->items)
                                                    @for($i = 0; $i < $carousels->count(); $i++)
                                                        <div class="form-row carousels-wrapper @if($i%2 == 0) odd @endif" data-repeater-item>
                                                            <div class="form-group col-md-4">
                                                                <input type="hidden" name="carousels[{{ $i }}][id]"
                                                                       value="{{ ((!empty($carousels) && $carousels[$i]->id) ? $carousels[$i]->id : null) }}"
                                                                >
                                                                <input type="hidden" name="carousels[{{ $i }}][type]"
                                                                       value="{{ \App\Enums\CarouselType::Image }}"
                                                                       class="carousels-type"
                                                                >
                                                                <label for="carousels[{{ $i }}][image]">{{ __("Carousel Image") }}</label>
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
                                                                    src="{{ $model ? asset('storage/companies/'.$company->id.'/'.$carousels[$i]->image) : null }}"
                                                                >
                                                            </div>
                                                            <div class="form-group col-md-7">
                                                                <label for="carousels[{{ $i }}][text]">{{ __(" Carousel Text") }}</label>
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
                                                    @php($teasers = $model->teaser->items)
                                                    @for($i = 0; $i < $teasers->count(); $i++)
                                                        <div class="form-row teasers-wrapper @if($i%2 == 0) odd @endif" data-repeater-item>
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
                                            <button class="btn btn-submit">{{ __('Submit') }}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('assets/plugins/select2/select2.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/summernote/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/form-repeater/jquery.repeater.min.js') }}"></script>
    <script src="{{asset('js/pages/company-homepage.js')}}"></script>
@endsection
