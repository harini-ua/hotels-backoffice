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
                                        <form id="city" method="POST" action="{{ route('cities.providers.update', $city->id) }}">
                                            @csrf
                                            @method('PUT')
                                            <div class="table-responsive m-b-30">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">{{ __('Provider Name') }}</th>
                                                            <th scope="col">{{ __('Provider City Code') }}</th>
                                                            <th scope="col"
                                                                class="text-center"
                                                                style="width: 100px"
                                                            >{{ __('Active') }}</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($city->providers as $provider)
                                                        <tr>
                                                            <th scope="row">{{ mb_strtoupper($provider->name) }}</th>
                                                            <td>{{ $provider->pivot->provider_city_code }}</td>
                                                            <td class="text-center">
                                                                <div class="custom-control custom-switch">
                                                                    <input
                                                                        type="checkbox"
                                                                        class="custom-control-input edit-field checkbox-field"
                                                                        id="providers[{{ $provider->id }}][active]"
                                                                        name="providers[{{ $provider->id }}][active]"
                                                                        value="1"
                                                                        @if($provider->pivot->active) checked @endif
                                                                    >
                                                                    <label class="custom-control-label" for="providers[{{ $provider->id }}][active]"></label>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
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
