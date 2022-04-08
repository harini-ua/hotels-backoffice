<div class="navigationbar">
    <!-- Start container-fluid -->
    <div class="container-fluid">
        <!-- Start Horizontal Nav -->
        <nav class="horizontal-nav mobile-navbar fixed-navbar">
            <div class="collapse navbar-collapse" id="navbar-menu">
                <ul class="horizontal-menu">
                    @foreach($items as $key => $item)
                        @if($item['guard'])
                        <li class="dropdown">
                            <a href="{{isset($item['href']) ?? 'javaScript:void();' }}"><img src="{{$item['image']}}" class="img-fluid" alt="{{__($item['name'])}}">{{__($item['name'])}}</a>
                            @if(isset($item['items']))
                                <ul class="dropdown-menu">
                                    @foreach($item['items'] as $subItem)
                                        @if($item['guard'])
                                        <li><a href="{{$subItem['href']}}"><img src="{{$subItem['image']}}" class="img-fluid" alt="{{__($subItem['name'])}}">{{__($subItem['name'])}}</a></li>
                                        @endif
                                    @endforeach
                                </ul>
                            @endif
                        </li>
                        @endif
                    @endforeach
                </ul>
            </div>
        </nav>
        <!-- End Horizontal Nav -->
    </div>
    <!-- End container-fluid -->
</div>
