<div class="accordion" id="datatable-filters">
    <div class="card m-b-10">
        <div class="card-header" id="headingOne">
            <h2 class="mb-0">
                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseFilters" aria-expanded="true" aria-controls="collapseFilters"><i class="feather icon-filter mr-2"></i>{{ __('Filters') }}</button>
            </h2>
        </div>
        <div id="collapseFilters" class="collapse" aria-labelledby="headingOne" data-parent="#datatable-filters" style="">
            <div class="card-body">
                {{ $slot }}
            </div>
        </div>
    </div>
</div>
