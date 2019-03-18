<!--begin:: Global Mandatory Vendors -->
    <script src="{{ asset('v2/vendors/jquery/dist/jquery.js')}}" type="text/javascript"></script>
    <script src="{{ asset('v2/vendors/popper.js/dist/umd/popper.js')}}" type="text/javascript"></script>
    <script src="{{ asset('v2/vendors/bootstrap/dist/js/bootstrap.min.js')}}" type="text/javascript"></script>
    <script src="{{ asset('v2/vendors/js-cookie/src/js.cookie.js')}}" type="text/javascript"></script>
    <script src="{{ asset('v2/vendors/moment/min/moment.min.js')}}" type="text/javascript"></script>
    <script src="{{ asset('v2/vendors/tooltip.js/dist/umd/tooltip.min.js')}}" type="text/javascript"></script>
    <script src="{{ asset('v2/vendors/perfect-scrollbar/dist/perfect-scrollbar.js')}}" type="text/javascript"></script>
    <script src="{{ asset('v2/vendors/wnumb/wNumb.js')}}" type="text/javascript"></script>
    <script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="//cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    <script src="//cdn.datatables.net/responsive/2.1.1/js/dataTables.responsive.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <!--end:: Global Mandatory Vendors -->

    <!--begin::Global Theme Bundle -->
    <script src="{{ asset('v2/assets/app/js/scripts.bundle.min.js')}}" type="text/javascript"></script>

    <script>
        $(document).ready(function(){
            "use strict";
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });
    </script>
    @yield('js')