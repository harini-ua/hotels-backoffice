@extends('admin.layouts.main')

@section('title',  __('Company Site Themes'))

@section('style')

@endsection

@section('rightbar-content')
    <div class="contentbar companies-themes-list-datatable">
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
    <script src="{{asset('js/scripts/datatable.js')}}"></script>
@endsection

