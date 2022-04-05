@extends('admin.layouts.main')

@section('title',  __('Admins'))

@section('style')

@endsection

@section('rightbar-content')
    <div class="contentbar admins-list-wrapper">
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
    {{ $dataTable->scripts() }}
@endsection

