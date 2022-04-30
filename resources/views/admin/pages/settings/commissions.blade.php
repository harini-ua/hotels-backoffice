@extends('admin.layouts.main')

@section('title',  __('Update Commissions'))

@section('style')

@endsection

@section('rightbar-content')
    <div class="contentbar company-default-edit-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <div class="card m-b-30">
                    <div class="card-header">
                        <h5 class="card-title">{{ __('City Commissions') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col s12">
                                <form id="settings-cities-commissions" method="POST"
                                      action="{{ route('settings.commissions.cities.update') }}"
                                >
                                    @csrf
                                    @method('PUT')

                                    <button class="btn btn-primary">{{ __('Submit') }}</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card m-b-30">
                    <div class="card-header">
                        <h5 class="card-title">{{ __('Company Commissions') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col s12">
                                <form id="settings-companies-commissions" method="POST"
                                      action="{{ route('settings.commissions.companies.update') }}"
                                >
                                    @csrf
                                    @method('PUT')

                                    <button class="btn btn-primary">{{ __('Submit') }}</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{asset('js/pages/settings-commissions.js')}}"></script>
@endsection
