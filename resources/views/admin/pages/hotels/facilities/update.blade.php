@extends('admin.layouts.main')

@section('title',  __('Update Hotel'))

@section('style')
    <link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" type="text/css" href="{{ asset('css/pages/hotels.css') }}">
@endsection

@section('rightbar-content')
    <div class="contentbar hotel-facilities-edit-wrapper">
        <div class="row">
            <div class="col-lg-5 col-xl-3">
                <div class="card m-b-30">
                    <div class="card-header">
                        <h5 class="card-title mb-0">{{ $hotel->name }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                            <a class="nav-link mb-2" href="{{ route('hotels.edit', $hotel) }}">{{ __('General') }}</a>
                            <a class="nav-link mb-2" href="{{ route('hotels.images.edit', $hotel) }}">{{ __('Images') }}</a>
                            <a class="nav-link mb-2 active" href="{{ route('hotels.facilities.edit', $hotel) }}">{{ __('Facilities') }}</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-7 col-xl-9">
                <div class="tab-content" id="v-pills-tabContent">
                    <div class="tab-pane fade show active" id="v-pills-facilities" role="tabpanel" aria-labelledby="v-pills-facilities-tab">
                        <div class="card m-b-30">
                            <div class="card-header">
                                <h5 class="card-title">{{ __('Facilities') }}</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    @can(\App\Enums\Permission::EDIT_HOTEL)
                                        @include('admin.pages.hotels.facilities._form')
                                    @else
                                        @include('admin.pages.hotels.facilities._view')
                                    @endcan
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('assets/plugins/select2/select2.min.js') }}"></script>
    <script src="{{asset('js/pages/hotels.js')}}"></script>
@endsection
