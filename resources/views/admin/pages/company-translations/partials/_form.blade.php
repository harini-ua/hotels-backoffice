<form
    id="company_translations"
    method="POST"
    action="{{ route('translations.companies.update') }}"
>
    @csrf
    @method('PUT')
    @if($company)<input type="hidden" name="company_id" value="{{ $company->id }}"/>@endif
    @if($company)<input type="hidden" name="language_id" value="{{ $company->language->id }}"/>@endif
    <div @if($company) class="m-b-10">
        <div class="row align-items-center">
            <div class="col-md-10 col-lg-10">
                <h5 class=m-t-15">{{ $company->name }}</h5>
            </div>
            <div class="col-md-2 col-lg-2 text-right">
                <button
                    type="submit"
                    class="btn btn-submit"
                    @if(!$count) disabled @endif
                >
                    <i class="feather icon-save mr-2"></i>{{ __('Save') }}
                </button>
            </div>
        </div>
    </div @endif>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th scope="col">{{ __('English') }}</th>
                <th scope="col">{{ __('Translation') }}</th>
            </tr>
        </thead>
        <tbody>
            @forelse($translations as $group_id => $items)
                <tr>
                    <th scope="row" colspan="2">
                        <h6>{{ \App\Enums\VerbalType::getDescription($group_id) }}</h6>
                    </th>
                </tr>
                @foreach($items as $key => $item)
                    <tr>
                        <th scope="row">
                            <input type="hidden"
                                   name="translations[{{$key}}][id]"
                                   value="{{ $item->id }}"/>
                            <input type="hidden"
                                   name="translations[{{$key}}][company_id]"
                                   value="{{ $company->id }}"/>
                            <input type="hidden"
                                   name="translations[{{$key}}][field_id]"
                                   value="{{ $item->field_id }}"/>
                            <input type="text"
                                   name="translations[{{$key}}][name]"
                                   value="{{ $item->name }}"
                                   class="form-control-plaintext"/>
                        </th>
                        <td>
                            @switch($item->type)
                                @case(\App\Enums\FieldType::TEXT)
                                @case(\App\Enums\FieldType::BUTTON)
                                @default
                                    <input type="text"
                                           name="translations[{{$key}}][translation]"
                                           value="{{ $item->translation }}"
                                           maxlength="{{ $item->max_length }}"
                                           class="form-control text-field"/>
                                    <small class="form-text" role="alert">{{ __('Max') .' '. $item->max_length .' '. __('letters') }}.</small>
                                    @break
                                @case(\App\Enums\FieldType::TEXTAREA)
                                    <textarea
                                        row="5"
                                        name="translations[{{$key}}][translation]"
                                        class="form-control textarea-field"
                                    >{{ $item->translation }}</textarea>
                                    @break
                                @case(\App\Enums\FieldType::HTML)
                                    <textarea
                                        row="5"
                                        name="translations[{{$key}}][translation]"
                                        class="form-control summernote-editor content-field"
                                    >{{ $item->translation }}</textarea>
                                    @break
                            @endswitch
                        </td>
                    </tr>
                @endforeach
            @empty
                <tr>
                    <td colspan="2"><em>{{ __('No fields to translate.') }}</em></td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <div @if($company) class="m-b-10">
        <div class="row align-items-center">
            <div class="col-md-10 col-lg-10">
                <h5 class=m-t-15">{{ $company->name }}</h5>
            </div>
            <div class="col-md-2 col-lg-2 text-right">
                <button
                    type="submit"
                    class="btn btn-submit"
                    @if(!$count) disabled @endif
                >
                    <i class="feather icon-save mr-2"></i>{{ __('Save') }}
                </button>
            </div>
        </div>
    </div @endif>
</form>
