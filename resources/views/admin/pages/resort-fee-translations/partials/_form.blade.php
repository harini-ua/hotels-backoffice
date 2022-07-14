<form
    id="resort_fee_translations"
    method="POST"
    action="{{ route('translations.resort-fee.update') }}"
>
    @csrf
    @method('PUT')
    <div @if($language) class="m-b-10">
        <div class="row align-items-center">
            <div class="col-md-10 col-lg-10">
                <h5 class=m-t-15">{{$language->name}} ({{ $count }})</h5>
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
    @if($language)<input type="hidden" name="language_id" value="{{ $language->id }}"/>@endif
    <table class="table table-bordered">
        <thead>
            <tr>
                <th scope="col">{{ __('Country') }}</th>
                <th scope="col">{{ __('City') }}</th>
                @if($language)
                <th scope="col">@if($language->id !== 1){{ __('English') }}@else{{ __('Resort Fee') }}@endif</th>
                <th @if($language->id !== 1) scope="col">{{ __('Translation') }}</th @endif>
                @else
                    <th scope="col">{{ __('English') }}</th>
                    <th scope="col">{{ __('Translation') }}</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @forelse($translations as $key => $item)
                <tr>
                    <th scope="row">
                        <input type="hidden"
                               name="translations[{{$key}}][country_id]"
                               value="{{ $item->country_id }}"/>
                        <input type="text"
                               value="{{ $item->country->name }}"
                               class="form-control-plaintext"/>
                    </th>
                    <th scope="row">
                        <input type="hidden"
                               name="translations[{{$key}}][city_id]"
                               value="{{ $item->city_id }}"/>
                        <input type="text"
                               value="{{ $item->city->name }}"
                               class="form-control-plaintext"/>
                    </th>
                    <th scope="row">
                        <input type="text"
                               value="{{ $item->name }}"
                               class="form-control-plaintext"/>
                    </th>
                    <td @if($language->id !== 1)>
                            <textarea
                                row="5"
                                name="translations[{{$key}}][translation]"
                                class="form-control textarea-field"
                            >{{ $item->translation }}</textarea>
                    </td @endif>
                </tr>
            @empty
                <tr>
                    <td colspan="2"><em>{{ __('No fields to translate.') }}</em></td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <div @if($language) class="m-b-10">
        <div class="row align-items-center">
            <div class="col-md-10 col-lg-10">
                <h5 class=m-t-15">{{$language->name}} ({{ $count }})</h5>
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
