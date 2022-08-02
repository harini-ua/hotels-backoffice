@extends('admin.layouts.main')

@section('title',  __('Update City'))

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/pages/cities.css') }}">
@endsection

@section('rightbar-content')
    <div class="contentbar cities-edit-wrapper">
        <div class="row">
            <div class="col-lg-5 col-xl-3">
                <div class="card m-b-30">
                    <div class="card-header">
                        <h5 class="card-title mb-0">{{ $city->name }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                            <a class="nav-link mb-2" href="{{ route('cities.edit', $city) }}">{{ __('City Edit') }}</a>
                            <a class="nav-link mb-2 active" href="{{ route('cities.providers.edit', $city) }}">{{ __('Providers') }}</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-7 col-xl-9">
                <div class="tab-content" id="v-pills-tabContent">
                    <div class="tab-pane fade show active" id="v-pills-general" role="tabpanel" aria-labelledby="v-pills-general-tab">
                        <div class="card m-b-30">
                            <div class="card-header">
                                <h5 class="card-title">{{ __('Providers') }}</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col s12">
                                        @php($model = $city ?? null)
                                        <form id="city" method="POST" action="{{ route('cities.providers.update', $model->id) }}">
                                            @csrf
                                            @if(isset($model)) @method('PUT') @endif

                                            <button class="btn btn-submit">{{ __('Submit') }}</button>
                                        </form>
                                    </div>
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
    <script src="{{asset('js/pages/cities.js')}}"></script>
@endsection
