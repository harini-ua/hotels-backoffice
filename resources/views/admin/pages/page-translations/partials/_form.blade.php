<form
    id="page_translations"
    method="POST"
    action="{{ route('translations.pages.update') }}"
>
    @csrf
    @method('PUT')
    @if($page)<input type="hidden" name="page_id" value="{{ $page->id }}"/>@endif
    @if($language)<input type="hidden" name="language_id" value="{{ $language->id }}"/>@endif
    <div @if($page) class="m-b-10">
        <div class="row align-items-center">
            <div class="col-md-10 col-lg-10">
                <h5 class=m-t-15">{{ $page->name }} ({{ $count }})</h5>
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
                                   name="translations[{{$key}}][page_id]"
                                   value="{{ $page->id }}"/>
                            <input type="hidden"
                                   name="translations[{{$key}}][field_id]"
                                   value="{{ $item->field_id }}"/>
                            <input type="text"
                                   name="translations[{{$key}}][name]"
                                   value="{{ $item->name }}"
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
                @endforeach
            @empty
                <tr>
                    <td colspan="2"><em>{{ __('No fields to translate.') }}</em></td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <div @if($page) class="m-b-10">
        <div class="row align-items-center">
            <div class="col-md-10 col-lg-10">
                <h5 class=m-t-15">{{ $page->name }} ({{ $count }})</h5>
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
