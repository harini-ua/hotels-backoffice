<div class="breadcrumbbar">
    <div class="row align-items-center">
        <div class="col-md-8 col-lg-8">
            @if($breadcrumbs)
                <div class="breadcrumb-list">
                    @if(isset($breadcrumbs[0]['title']))
                        <h4 class="page-title">{{$breadcrumbs[0]['title']}}</h4>
                        @php(array_shift($breadcrumbs))
                    @endif
                    <ol class="breadcrumb">
                        @foreach($breadcrumbs as $breadcrumb)
                            @if(isset($breadcrumb['link']))
                                <li class="breadcrumb-item"><a href="{{ $breadcrumb['link'] }}">{{ $breadcrumb['name'] }}</a></li>
                            @else
                                <li class="breadcrumb-item active" aria-current="page">{{ $breadcrumb['name'] }}</li>
                            @endif
                        @endforeach
                    </ol>
                </div>
            @endif
        </div>
        <div class="col-md-4 col-lg-4">
            @if(isset($actions))
            <div class="widgetbar">
                @foreach($actions as $action)
                <button class="btn btn-primary-rgba"><i class="feather @if($action['icon']) {{ 'icon-'.$action['icon'] }} @endif mr-2"></i>{{ $action['name'] }}</button>
                @endforeach
            </div>
            @endif
        </div>
    </div>
</div>
