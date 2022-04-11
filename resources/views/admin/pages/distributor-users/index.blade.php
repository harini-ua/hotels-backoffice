@extends('admin.layouts.main')

@section('title',  __('Distributors Users'))

@section('style')

@endsection

@section('rightbar-content')
    <div class="contentbar distributors-users-list-wrapper">
        <div class="row">
            <div class="col-lg-12">
                @if((Auth::user())->hasRole('admin'))
                <x-filter>
                    @include('admin.pages.distributor-users.partials._filter')
                </x-filter>
                @endif
            </div>
            <div class="col-lg-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <div class="table-responsive">
                            {{ $dataTable->table() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    {{ $dataTable->scripts() }}
    <script src="{{asset('js/scripts/datatable.js')}}"></script>
    <script src="{{asset('js/scripts/filters.js')}}"></script>
@endsection
