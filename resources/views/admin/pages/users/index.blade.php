@extends('admin.layouts.main')

@section('title',  __('Users'))

@section('style')

@endsection

@section('rightbar-content')
    <div class="contentbar users-dashboard-wrapper">
        @foreach($widgets as $items)
            <div class="row">
                @foreach($items as $item)
                    @if($item['guard'])
                        <div class="col-lg-12 col-xl-2 mt-4 widget-link-wrapper">
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
