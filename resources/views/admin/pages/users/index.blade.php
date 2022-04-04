@extends('admin.layouts.main')

@section('title',  __('Users'))

@section('style')

@endsection

@section('rightbar-content')
    <!-- Start Contentbar -->
    <div class="contentbar">
        <div class="row">
            <div class="col-lg-12">
                <div class="card m-b-30">
{{--                    <div class="card-header">--}}
{{--                        <h5 class="card-title">Default Data Table</h5>--}}
{{--                    </div>--}}
                    <div class="card-body">
{{--                        <h6 class="card-subtitle">With DataTables you can alter the ordering characteristics of the table at initialisation time.</h6>--}}
                        <div class="table-responsive">
                            {{ $dataTable->table() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Contentbar -->
@endsection

@section('script')
    {{ $dataTable->scripts() }}
@endsection

