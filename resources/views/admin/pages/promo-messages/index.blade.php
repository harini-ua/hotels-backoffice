@extends('admin.layouts.main')

@section('title',  __('Promo Message'))

@section('style')
    <link href="{{ asset('assets/plugins/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/plugins/datatables/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/plugins/datatables/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/pages/promo-messages.css') }}" rel="stylesheet" type="text/css">
@endsection

@section('rightbar-content')
    <div class="contentbar promo-messages-list-wrapper">
        <div class="row">
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
    @include('admin.datatables.datatable-scripts')
    {{ $dataTable->scripts() }}
    <script src="{{asset('js/scripts/datatable.js')}}"></script>
    <script src="{{asset('js/pages/promo-messages.js')}}"></script>
@endsection
