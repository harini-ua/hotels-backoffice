@extends('admin.layouts.main')

@section('title',  __('Statistics'))

@section('style')

@endsection

@section('rightbar-content')
    <div class="contentbar statistics-list-wrapper">
        @foreach($statistics as $items)
            <div class="row">
                @foreach($items as $item)
                    @if($item['guard'])
                        <div class="col-lg-12 col-xl-2 mb-2 widget-link-wrapper">
                            <a class="btn btn-submit link" href="{{ $item['href'] }}" role="button">
                                <i class="{{ $item['icon'] }}"></i> {{ $item['name'] }}
                            </a>
                        </div>
                    @endif
                @endforeach
            </div>
        @endforeach
    </div>
@endsection

@section('script')

@endsection
