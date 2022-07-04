<form
    id="city_translations"
    method="POST"
    action="{{ route('translations.cities.update') }}"
>
    @csrf
    @method('PUT')
    <input type="hidden" name="country_id" value="{{ $country->id }}"/>
    <input type="hidden" name="language_id" value="{{ $language->id }}"/>
    <div @if($country) class="m-b-10">
        <div class="row align-items-center">
            <div class="col-md-10 col-lg-10">
                <h5 class=m-t-15">{{ $country->name }}{{ $country->region ? ', '.$country->region : '' }} ({{ $translations->count() }})</h5>
            </div>
            <div class="col-md-2 col-lg-2 text-right">
                <button
                    type="submit"
                    class="btn btn-submit"
                    @if(!$translations->count()) disabled @endif
                >
                    <i class="feather icon-save mr-2"></i>{{ __('Save') }}
                </button>
            </div>
        </div>
    </div @endif>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th scope="col">{{ __('City Name') }}</th>
                <th scope="col">{{ __('Translation') }}</th>
            </tr>
        </thead>
        <tbody>
            @forelse($translations as $key => $item)
                <tr>
                    <th scope="row">
                        <input type="hidden"
                               name="translations[{{$key}}][id]"
                               value="{{ $item->id }}"/>
                        <input type="hidden"
                               name="translations[{{$key}}][country_id]"
                               value="{{ $country->id }}"/>
                        <input type="hidden"
                               name="translations[{{$key}}][city_id]"
                               value="{{ $item->city_id }}"/>
                        <input type="text"
                               name="translations[{{$key}}][city_name]"
                               value="{{ $item->city_name }}"
                               class="form-control-plaintext"/>
                    </th>
                    <td>
                        <input type="hidden"
                               name="translations[{{$key}}][language_id]"
                               value="{{ $language->id }}"/>
                        <input type="text"
                               name="translations[{{$key}}][translation]"
                               value="{{ $item->translation }}"
                               class="form-control"/>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="2"><em>{{ __('No cities to translate.') }}</em></td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <div @if($country) class="m-b-10">
        <div class="row align-items-center">
            <div class="col-md-10 col-lg-10">
                <h5 class=m-t-15">{{ $country->name }}{{ $country->region ? ', '.$country->region : '' }} ({{ $translations->count() }})</h5>
            </div>
            <div class="col-md-2 col-lg-2 text-right">
                <button
                    type="submit"
                    class="btn btn-submit"
                    @if(!$translations->count()) disabled @endif
                >
                    <i class="feather icon-save mr-2"></i>{{ __('Save') }}
                </button>
            </div>
        </div>
    </div @endif>
</form>
