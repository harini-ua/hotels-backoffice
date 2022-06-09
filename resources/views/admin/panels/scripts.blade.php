<!-- Start JS -->
<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/popper.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/modernizr.min.js') }}"></script>
<script src="{{ asset('assets/js/detect.js') }}"></script>
<script src="{{ asset('assets/js/jquery.slimscroll.js') }}"></script>
<script src="{{ asset('assets/js/horizontal-menu.js') }}"></script>
<script src="{{ asset('assets/plugins/switchery/switchery.min.js') }}"></script>
<script src="{{ asset('assets/plugins/pace/pace.min.js') }}"></script>
<script src="{{ asset('assets/plugins/date-format/date-format.js') }}"></script>
<script src="https://unpkg.com/sweetalert2@7.18.0/dist/sweetalert2.all.js"></script>
<!-- Core JS -->
<script src="{{ asset('assets/js/core.js') }}"></script>
<!-- End JS -->
<script src="{{ mix('/js/app.js') }}"></script>
<script src="{{asset('js/scripts/custom.js')}}"></script>
@yield('script')
