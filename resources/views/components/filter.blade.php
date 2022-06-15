@php($uniq = uniqid())
<div class="accordion" id="{{ 'datatable-filters-'.$uniq }}">
    <div class="card m-b-10">
        <div class="card-header" id="{{ 'heading-'.$uniq }}">
            <h2 class="mb-0">
                <button
                    class="btn btn-link collapse-filters"
                    type="button"
                    data-toggle="collapse"
                    data-target="{{ '#collapse-'.$uniq }}"
                    aria-expanded="true"
                    aria-controls="{{ 'collapse-'.$uniq }}"
                ><i class="feather icon-filter mr-2"></i>{{ __($title) }}</button>
            </h2>
        </div>
        <div id="{{ 'collapse-'.$uniq }}" class="collapse @if(!$collapse) show @endif" aria-labelledby="{{ 'heading-'.$uniq }}" data-parent="{{ '#datatable-filters-'.$uniq }}" style="">
            <div class="card-body">
                <div class="form-row filter-items-wrapper">
                    {{ $slot }}
                    <div class="reset-filters">
                        <a href="{{ url()->current() }}" class="reset-btn"><i class="feather icon-x"></i> {{ __('Reset filters') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
