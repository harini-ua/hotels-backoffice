<div class="leftbar">
    <!-- Start Sidebar -->
    <div class="sidebar">
        <!-- Start Navigationbar -->
        <div class="navigationbar">
            <div class="vertical-menu-icon">
                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    <div class="logobar">
                        <a href="{{url('/demo')}}" class="logo logo-small"><img src="assets/images/small_logo.svg" class="img-fluid" alt="logo"></a>
                    </div>
                    <a class="nav-link active" id="v-pills-crm-tab" data-toggle="pill" href="#v-pills-crm" role="tab" aria-controls="v-pills-crm" aria-selected="true"><img src="assets/images/svg-icon/crm.svg" class="img-fluid" alt="CRM" data-toggle="tooltip" data-placement="top" title="CRM"></a>
                    <a class="nav-link" id="v-pills-ecommerce-tab" data-toggle="pill" href="#v-pills-ecommerce" role="tab" aria-controls="v-pills-ecommerce" aria-selected="false"><img src="assets/images/svg-icon/ecommerce.svg" class="img-fluid" alt="eCommerce" data-toggle="tooltip" data-placement="top" title="eCommerce"></a>
                    <a class="nav-link" id="v-pills-hospital-tab" data-toggle="pill" href="#v-pills-hospital" role="tab" aria-controls="v-pills-hospital" aria-selected="false"><img src="assets/images/svg-icon/hospital.svg" class="img-fluid" alt="Hospital" data-toggle="tooltip" data-placement="top" title="Hospital"></a>
                    <a class="nav-link" id="v-pills-uikits-tab" data-toggle="pill" href="#v-pills-uikits" role="tab" aria-controls="v-pills-uikits" aria-selected="false"><img src="assets/images/svg-icon/ui-kits.svg" class="img-fluid" alt="UI Kits" data-toggle="tooltip" data-placement="top" title="UI Kits"></a>
                    <a class="nav-link" id="v-pills-pages-tab" data-toggle="pill" href="#v-pills-pages" role="tab" aria-controls="v-pills-pages" aria-selected="false"><img src="assets/images/svg-icon/pages.svg" class="img-fluid" alt="Pages" data-toggle="tooltip" data-placement="top" title="Pages"></a>
                </div>
            </div>
            <div class="vertical-menu-detail">
                <div class="logobar">
                    <a href="{{url('/demo')}}" class="logo logo-large"><img src="assets/images/logo.svg" class="img-fluid" alt="logo"></a>
                </div>
                <div class="tab-content" id="v-pills-tabContent">
                    <div class="tab-pane fade show active" id="v-pills-crm" role="tabpanel" aria-labelledby="v-pills-crm-tab">
                        <ul class="vertical-menu">
                            <li><h5 class="menu-title">CRM</h5></li>
                            <li><a href="{{url('/demo')}}"><img src="assets/images/svg-icon/dashboard.svg" class="img-fluid" alt="dashboard">Dashboard</a></li>
                            <li><a href="{{url('/demo/crm-projects')}}"><img src="assets/images/svg-icon/reports.svg" class="img-fluid" alt="projects">Projects</a></li>
                            <li><a href="{{url('/demo/crm-lead-status')}}"><img src="assets/images/svg-icon/charts.svg" class="img-fluid" alt="leads">Lead Status</a></li>
                            <li><a href="{{url('/demo/crm-clients')}}"><img src="assets/images/svg-icon/customers.svg" class="img-fluid" alt="clients">Clients</a></li>
                        </ul>
                    </div>
                    <div class="tab-pane fade" id="v-pills-ecommerce" role="tabpanel" aria-labelledby="v-pills-ecommerce-tab">
                        <ul class="vertical-menu">
                            <li><h5 class="menu-title">eCommerce</h5></li>
                            <li><a href="{{url('/demo/dashboard-ecommerce')}}"><img src="assets/images/svg-icon/dashboard.svg" class="img-fluid" alt="dashboard">Dashboard</a></li>
                            <li>
                                <a href="javaScript:void();">
                                  <img src="assets/images/svg-icon/frontend.svg" class="img-fluid" alt="frontend"><span>Front End</span><i class="feather icon-chevron-right"></i>
                                </a>
                                <ul class="vertical-submenu">
                                    <li><a href="{{url('/demo/ecommerce-shop')}}">Shop</a></li>
                                    <li><a href="{{url('/demo/ecommerce-single-product')}}">Single Product</a></li>
                                    <li><a href="{{url('/demo/ecommerce-cart')}}">Cart</a></li>
                                    <li><a href="{{url('/demo/ecommerce-checkout')}}">Checkout</a></li>
                                    <li><a href="{{url('/demo/ecommerce-thankyou')}}">Thank You</a></li>
                                    <li><a href="{{url('/demo/ecommerce-myaccount')}}">My Account</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="javaScript:void();">
                                  <img src="assets/images/svg-icon/backend.svg" class="img-fluid" alt="backend"><span>Back End</span><i class="feather icon-chevron-right"></i>
                                </a>
                                <ul class="vertical-submenu">
                                    <li><a href="{{url('/demo/ecommerce-product-list')}}">Product List</a></li>
                                    <li><a href="{{url('/demo/ecommerce-product-detail')}}">Product Detail</a></li>
                                    <li><a href="{{url('/demo/ecommerce-order-list')}}">Order List</a></li>
                                    <li><a href="{{url('/demo/ecommerce-order-detail')}}">Order Detail</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-pane fade" id="v-pills-hospital" role="tabpanel" aria-labelledby="v-pills-hospital-tab">
                        <ul class="vertical-menu">
                            <li><h5 class="menu-title">Hospital</h5></li>
                            <li><a href="{{url('/demo/dashboard-hospital')}}"><img src="assets/images/svg-icon/dashboard.svg" class="img-fluid" alt="dashboard">Dashboard</a></li>
                            <li><a href="{{url('/demo/hospital-appointment')}}"><img src="assets/images/svg-icon/calender.svg" class="img-fluid" alt="appointments">Appointments</a></li>
                            <li><a href="{{url('/demo/hospital-doctor')}}"><img src="assets/images/svg-icon/doctor.svg" class="img-fluid" alt="doctors">Doctors</a></li>
                            <li><a href="{{url('/demo/hospital-patient')}}"><img src="assets/images/svg-icon/customers.svg" class="img-fluid" alt="patients">Patients</a></li>
                        </ul>
                    </div>
                    <div class="tab-pane fade" id="v-pills-uikits" role="tabpanel" aria-labelledby="v-pills-uikits-tab">
                        <ul class="vertical-menu">
                            <li><h5 class="menu-title">UI Kits</h5></li>
                            <li>
                                <a href="javaScript:void();">
                                  <img src="assets/images/svg-icon/basic.svg" class="img-fluid" alt="basic"><span>Basic UI</span><i class="feather icon-chevron-right"></i>
                                </a>
                                <ul class="vertical-submenu">
                                    <li><a href="{{url('/demo/basic-ui-kits-alerts')}}">Alerts</a></li>
                                    <li><a href="{{url('/demo/basic-ui-kits-badges')}}">Badges</a></li>
                                    <li><a href="{{url('/demo/basic-ui-kits-buttons')}}">Buttons</a></li>
                                    <li><a href="{{url('/demo/basic-ui-kits-cards')}}">Cards</a></li>
                                    <li><a href="{{url('/demo/basic-ui-kits-carousel')}}">Carousel</a></li>
                                    <li><a href="{{url('/demo/basic-ui-kits-collapse')}}">Collapse</a></li>
                                    <li><a href="{{url('/demo/basic-ui-kits-dropdowns')}}">Dropdowns</a></li>
                                    <li><a href="{{url('/demo/basic-ui-kits-embeds')}}">Embeds</a></li>
                                    <li><a href="{{url('/demo/basic-ui-kits-grids')}}">Grids</a></li>
                                    <li><a href="{{url('/demo/basic-ui-kits-images')}}">Images</a></li>
                                    <li><a href="{{url('/demo/basic-ui-kits-media')}}">Media</a></li>
                                    <li><a href="{{url('/demo/basic-ui-kits-modals')}}">Modals</a></li>
                                    <li><a href="{{url('/demo/basic-ui-kits-paginations')}}">Paginations</a></li>
                                    <li><a href="{{url('/demo/basic-ui-kits-popovers')}}">Popovers</a></li>
                                    <li><a href="{{url('/demo/basic-ui-kits-progressbars')}}">Progress Bars</a></li>
                                    <li><a href="{{url('/demo/basic-ui-kits-spinners')}}">Spinners</a></li>
                                    <li><a href="{{url('/demo/basic-ui-kits-tabs')}}">Tabs</a></li>
                                    <li><a href="{{url('/demo/basic-ui-kits-toasts')}}">Toasts</a></li>
                                    <li><a href="{{url('/demo/basic-ui-kits-tooltips')}}">Tooltips</a></li>
                                    <li><a href="{{url('/demo/basic-ui-kits-typography')}}">Typography</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="javaScript:void();">
                                  <img src="assets/images/svg-icon/advanced.svg" class="img-fluid" alt="advanced"><span>Advanced UI</span><i class="feather icon-chevron-right"></i>
                                </a>
                                <ul class="vertical-submenu">
                                    <li><a href="{{url('/demo/advanced-ui-kits-image-crop')}}">Image Crop</a></li>
                                    <li><a href="{{url('/demo/advanced-ui-kits-jquery-confirm')}}">jQuery Confirm</a></li>
                                    <li><a href="{{url('/demo/advanced-ui-kits-nestable')}}">Nestable</a></li>
                                    <li><a href="{{url('/demo/advanced-ui-kits-pnotify')}}">Pnotify</a></li>
                                    <li><a href="{{url('/demo/advanced-ui-kits-range-slider')}}">Range Slider</a></li>
                                    <li><a href="{{url('/demo/advanced-ui-kits-ratings')}}">Ratings</a></li>
                                    <li><a href="{{url('/demo/advanced-ui-kits-session-timeout')}}">Session Timeout</a></li>
                                    <li><a href="{{url('/demo/advanced-ui-kits-sweet-alerts')}}">Sweet Alerts</a></li>
                                    <li><a href="{{url('/demo/advanced-ui-kits-switchery')}}">Switchery</a></li>
                                    <li><a href="{{url('/demo/advanced-ui-kits-toolbar')}}">Toolbar</a></li>
                                    <li><a href="{{url('/demo/advanced-ui-kits-tour')}}">Tour</a></li>
                                    <li><a href="{{url('/demo/advanced-ui-kits-treeview')}}">Tree View</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="javaScript:void();">
                                  <img src="assets/images/svg-icon/apps.svg" class="img-fluid" alt="apps"><span>Apps</span><i class="feather icon-chevron-right"></i>
                                </a>
                                <ul class="vertical-submenu">
                                    <li><a href="{{url('/demo/apps-calender')}}">Calender</a></li>
                                    <li><a href="{{url('/demo/apps-chat')}}">Chat</a></li>
                                    <li>
                                        <a href="javaScript:void();">Email<i class="feather icon-chevron-right"></i></a>
                                        <ul class="vertical-submenu">
                                            <li><a href="{{url('/demo/apps-email-inbox')}}">Inbox</a></li>
                                            <li><a href="{{url('/demo/apps-email-open')}}">Open</a></li>
                                            <li><a href="{{url('/demo/apps-email-compose')}}">Compose</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="{{url('/demo/apps-kanban-board')}}">Kanban Board</a></li>
                                    <li><a href="{{url('/demo/apps-onboarding-screens')}}">Onboarding Screens</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="javaScript:void();">
                                    <img src="assets/images/svg-icon/forms.svg" class="img-fluid" alt="forms"><span>Forms</span><i class="feather icon-chevron-right"></i>
                                </a>
                                <ul class="vertical-submenu">
                                    <li><a href="{{url('/demo/form-inputs')}}">Basic Elements</a></li>
                                    <li><a href="{{url('/demo/form-groups')}}">Groups</a></li>
                                    <li><a href="{{url('/demo/form-layouts')}}">Layouts</a></li>
                                    <li><a href="{{url('/demo/form-colorpickers')}}">Color Pickers</a></li>
                                    <li><a href="{{url('/demo/form-datepickers')}}">Date Pickers</a></li>
                                    <li><a href="{{url('/demo/form-editors')}}">Editors</a></li>
                                    <li><a href="{{url('/demo/form-file-uploads')}}">File Uploads</a></li>
                                    <li><a href="{{url('/demo/form-input-mask')}}">Input Mask</a></li>
                                    <li><a href="{{url('/demo/form-maxlength')}}">MaxLength</a></li>
                                    <li><a href="{{url('/demo/form-selects')}}">Selects</a></li>
                                    <li><a href="{{url('/demo/form-touchspin')}}">Touchspin</a></li>
                                    <li><a href="{{url('/demo/form-validations')}}">Validations</a></li>
                                    <li><a href="{{url('/demo/form-wizards')}}">Wizards</a></li>
                                    <li><a href="{{url('/demo/form-xeditable')}}">X-editable</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="javaScript:void();">
                                    <img src="assets/images/svg-icon/charts.svg" class="img-fluid" alt="charts"><span>Charts</span><i class="feather icon-chevron-right"></i>
                                </a>
                                <ul class="vertical-submenu">
                                    <li><a href="{{url('/demo/chart-apex')}}">Apex</a></li>
                                    <li><a href="{{url('/demo/chart-c3')}}">C3</a></li>
                                    <li><a href="{{url('/demo/chart-chartistjs')}}">Chartist</a></li>
                                    <li><a href="{{url('/demo/chart-chartjs')}}">Chartjs</a></li>
                                    <li><a href="{{url('/demo/chart-flot')}}">Flot</a></li>
                                    <li><a href="{{url('/demo/chart-knob')}}">Knob</a></li>
                                    <li><a href="{{url('/demo/chart-morris')}}">Morris</a></li>
                                    <li><a href="{{url('/demo/chart-piety')}}">Piety</a></li>
                                    <li><a href="{{url('/demo/chart-sparkline')}}">Sparkline</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="javaScript:void();">
                                    <img src="assets/images/svg-icon/icons.svg" class="img-fluid" alt="icons"><span>Icons</span><i class="feather icon-chevron-right"></i>
                                </a>
                                <ul class="vertical-submenu">
                                    <li><a href="{{url('/demo/icon-svg')}}">SVG</a></li>
                                    <li><a href="{{url('/demo/icon-dripicons')}}">Dripicons</a></li>
                                    <li><a href="{{url('/demo/icon-feather')}}">Feather</a></li>
                                    <li><a href="{{url('/demo/icon-flag')}}">Flag</a></li>
                                    <li><a href="{{url('/demo/icon-font-awesome')}}">Font Awesome</a></li>
                                    <li><a href="{{url('/demo/icon-ionicons')}}">Ion</a></li>
                                    <li><a href="{{url('/demo/icon-line-awesome')}}">Line Awesome</a></li>
                                    <li><a href="{{url('/demo/icon-material-design')}}">Material Design</a></li>
                                    <li><a href="{{url('/demo/icon-simple-line')}}">Simple Line</a></li>
                                    <li><a href="{{url('/demo/icon-socicon')}}">Socicon</a></li>
                                    <li><a href="{{url('/demo/icon-themify')}}">Themify</a></li>
                                    <li><a href="{{url('/demo/icon-typicons')}}">Typicons</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="javaScript:void();">
                                    <img src="assets/images/svg-icon/tables.svg" class="img-fluid" alt="tables"><span>Tables</span><i class="feather icon-chevron-right"></i>
                                </a>
                                <ul class="vertical-submenu">
                                    <li><a href="{{url('/demo/table-bootstrap')}}">Bootstrap</a></li>
                                    <li><a href="{{url('/demo/table-datatable')}}">Datatable</a></li>
                                    <li><a href="{{url('/demo/table-editable')}}">Editable</a></li>
                                    <li><a href="{{url('/demo/table-footable')}}">Foo</a></li>
                                    <li><a href="{{url('/demo/table-rwdtable')}}">RWD</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="javaScript:void();">
                                    <img src="assets/images/svg-icon/maps.svg" class="img-fluid" alt="maps"><span>Maps</span><i class="feather icon-chevron-right"></i>
                                </a>
                                <ul class="vertical-submenu">
                                    <li><a href="{{url('/demo/map-google')}}">Google</a></li>
                                    <li><a href="{{url('/demo/map-vector')}}">Vector</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="{{url('/demo/widgets')}}">
                                    <img src="assets/images/svg-icon/widgets.svg" class="img-fluid" alt="widgets"><span>Widgets</span><span class="badge badge-success pull-right">New</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-pane fade" id="v-pills-pages" role="tabpanel" aria-labelledby="v-pills-pages-tab">
                        <ul class="vertical-menu">
                            <li><h5 class="menu-title">Pages</h5></li>
                            <li>
                                <a href="javaScript:void();">
                                  <img src="assets/images/svg-icon/basic_page.svg" class="img-fluid" alt="basic_page"><span>Basic</span><i class="feather icon-chevron-right"></i>
                                </a>
                                <ul class="vertical-submenu">
                                    <li><a href="{{url('/demo/page-starter')}}">Starter</a></li>
                                    <li><a href="{{url('/demo/page-blog')}}">Blog</a></li>
                                    <li><a href="{{url('/demo/page-faq')}}">FAQ</a></li>
                                    <li><a href="{{url('/demo/page-gallery')}}">Gallery</a></li>
                                    <li><a href="{{url('/demo/page-invoice')}}">Invoice</a></li>
                                    <li><a href="{{url('/demo/page-pricing')}}">Pricing</a></li>
                                    <li><a href="{{url('/demo/page-timeline')}}">Timeline</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="javaScript:void();">
                                  <img src="assets/images/svg-icon/authentication.svg" class="img-fluid" alt="authentication"><span>Authentications</span><i class="feather icon-chevron-right"></i>
                                </a>
                                <ul class="vertical-submenu">
                                    <li><a href="{{url('/demo/user-login')}}">Login</a></li>
                                    <li><a href="{{url('/demo/user-register')}}">Register</a></li>
                                    <li><a href="{{url('/demo/user-forgotpsw')}}">Forgot Password</a></li>
                                    <li><a href="{{url('/demo/user-lock-screen')}}">Lock Screen</a></li>
                                    <li><a href="{{url('/demo/error-comingsoon')}}">Coming Soon</a></li>
                                    <li><a href="{{url('/demo/error-maintenance')}}">Maintenance</a></li>
                                    <li><a href="{{url('/demo/error-404')}}">Error 404</a></li>
                                    <li><a href="{{url('/demo/error-500')}}">Error 500</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>
        <!-- End Navigationbar -->
    </div>
    <!-- End Sidebar -->
</div>
