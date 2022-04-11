<div class="rightbar">
    <!-- Start Topbar Mobile -->
    <div class="topbar-mobile">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="mobile-logobar">
                    <a href="{{url('/')}}" class="mobile-logo"><img src="{{asset('assets/images/logo.svg')}}" class="img-fluid" alt="logo"></a>
                </div>
                <div class="mobile-togglebar">
                    <ul class="list-inline mb-0">
                        <li class="list-inline-item">
                            <div class="topbar-toggle-icon">
                                <a class="topbar-toggle-hamburger" href="javascript:void();">
                                    <img src="{{asset('assets/images/svg-icon/horizontal.svg')}}" class="img-fluid menu-hamburger-horizontal" alt="horizontal">
                                    <img src="{{asset('assets/images/svg-icon/verticle.svg')}}" class="img-fluid menu-hamburger-vertical" alt="verticle">
                                 </a>
                             </div>
                        </li>
                        <li class="list-inline-item">
                            <div class="menubar">
                                <a class="menu-hamburger navbar-toggle bg-transparent" href="javascript:void();" data-toggle="collapse" data-target="#navbar-menu" aria-expanded="true">
                                    <img src="{{asset('assets/images/svg-icon/menu.svg')}}" class="img-fluid menu-hamburger-collapse" alt="menu">
                                    <img src="{{asset('assets/images/svg-icon/close.svg')}}" class="img-fluid menu-hamburger-close" alt="close">
                                </a>
                             </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- Start Topbar -->
    <div class="topbar">
        <!-- Start container-fluid -->
        <div class="container-fluid">
            <!-- Start row -->
            <div class="row align-items-center">
                <!-- Start col -->
                <div class="col-md-12 align-self-center">
                    <div class="togglebar">
                        <ul class="list-inline mb-0">
                            <li class="list-inline-item">
                                <div class="logobar">
                                    <a href="{{url('/')}}" class="logo logo-large"><img src="{{asset('assets/images/logo.svg')}}" class="img-fluid" alt="logo"></a>
                                </div>
                            </li>
                            @if(config('admin.templation.search.enable'))
                            <li class="list-inline-item">
                                <div class="searchbar">
                                    <form>
                                        <div class="input-group">
                                            <div class="input-group-append">
                                                <button class="btn" type="submit" id="button-addonSearch"><img src="{{asset('assets/images/svg-icon/search.svg')}}" class="img-fluid" alt="search"></button>
                                            </div>
                                            <input type="search" class="form-control" placeholder="Search" aria-label="Search" aria-describedby="button-addonSearch">
                                        </div>
                                    </form>
                                </div>
                            </li>
                            @endif
                        </ul>
                    </div>
                    <div class="infobar">
                        <ul class="list-inline mb-0">
                            @if($profile)
                            <li class="list-inline-item">
                                @include('admin.partials.menu-profile')
                            </li>
                            @endif
                            <li class="list-inline-item menubar-toggle">
                                <div class="menubar">
                                    <a class="menu-hamburger navbar-toggle bg-transparent" href="javascript:void();" data-toggle="collapse" data-target="#navbar-menu" aria-expanded="true">
                                        <img src="{{asset('assets/images/svg-icon/menu.svg')}}" class="img-fluid menu-hamburger-collapse" alt="menu">
                                        <img src="{{asset('assets/images/svg-icon/close.svg')}}" class="img-fluid menu-hamburger-close" alt="close">
                                    </a>
                                 </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- End col -->
            </div>
            <!-- End row -->
        </div>
        <!-- End container-fluid -->
    </div>
    <!-- End Topbar -->
    <!-- Start Navigationbar -->
    <x-menu/>
    <!-- End Navigationbar -->
    <!-- Start Breadcrumbbar -->
    @include('admin.partials.breadcrumb')
    <!-- End Breadcrumbbar -->
    <!-- Start Contentbar -->
    @yield('rightbar-content')
    <!-- End Contentbar -->
    <!-- Start Footerbar -->
    @include('admin.partials.footer')
    <!-- End Footerbar -->
</div>
