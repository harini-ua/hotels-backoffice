@if($country)
    <h5 class="p-b-5">{{ $country->name }}{{ $country->region ? ', '.$country->region : '' }} ({{ $translations->count() }})<h5/>
@endif
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
                           name="translation[{{$key}}][id]"
                           value="{{ $item->id }}"
                    >
                    <input type="text"
                           name="translation[{{$key}}][city_name]"
                           value="{{ $item->city_name }}"
                           class="form-control-plaintext"
                    >
                </th>
                <td>
                    <input type="text"
                           name="translation[{{$key}}][translation]"
                           value="{{ $item->translation }}"
                           class="form-control"
                    >
                </td>
            </tr>
        @empty
            <p>{{ __('No cities to translate.') }}</p>
        @endforelse
    </tbody>
</table>
