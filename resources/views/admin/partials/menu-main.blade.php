<div class="navigationbar">
    <!-- Start container-fluid -->
    <div class="container-fluid">
        <!-- Start Horizontal Nav -->
        <nav class="horizontal-nav mobile-navbar fixed-navbar">
            <div class="collapse navbar-collapse" id="navbar-menu">
                <ul class="horizontal-menu">
                    @foreach($mainMenuItems as $key => $menuItem)
                    <li class="dropdown">
                        <a href="{{isset($menuItem['href']) ? route($menuItem['href']) : 'javaScript:void();' }}"><img src="{{$menuItem['image']}}" class="img-fluid" alt="{{__($menuItem['name'])}}">{{__($menuItem['name'])}}</a>
                        @if(isset($menuItem['items']))
                            <ul class="dropdown-menu">
                                @foreach($menuItem['items'] as $item)
                                    <li><a href="{{route($item['href'])}}"><img src="{{$item['image']}}" class="img-fluid" alt="{{__($item['name'])}}">{{__($item['name'])}}</a></li>
                                @endforeach
                            </ul>
                        @endif
                    </li>
                    @endforeach
                </ul>
            </div>
        </nav>
        <!-- End Horizontal Nav -->
    </div>
    <!-- End container-fluid -->
</div>
