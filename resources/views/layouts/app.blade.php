<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    {{-- <title>{{$title}}</title> --}}
    <title>ERP</title>
    <!-- plugins:css -->

    <link rel="stylesheet" href="{{ asset('css/vendor.bundle.base.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/themify-icons.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <!-- Fav icon -->
    {{-- <link rel="shortcut icon" href="img/"> --}}
    @yield('css')
</head>

<body data-new-gr-c-s-check-loaded="14.1062.0" data-gr-ext-installed="">
    <div class="container-scroller">
        <!-- partial:partials/_navbar.html -->
        @include('layouts.header')
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <!-- partial:partials/_settings-panel.html -->
            <!-- partial -->
            <!-- partial:partials/_sidebar.html -->
            @include('layouts.nav')

            <!-- partial -->
            <div class="main-panel">
                @yield('content')
                <!-- content-wrapper ends -->
                <!-- partial:partials/_footer.html -->
                @include('layouts.footer')
                <!-- partial -->
            </div>
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->

    <!-- plugins:js -->

    <script src="{{ asset('js/vendor.bundle.base.js.download') }}"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="{{ asset('js/Chart.min.js.download') }}"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="{{ asset('js/off-canvas.js.download') }}"></script>
    <script src="{{ asset('js/hoverable-collapse.js.download') }}"></script>
    <script src="{{ asset('js/template.js.download') }}"></script>
    <script src="{{ asset('js/settings.js.download') }}"></script>
    <script src="{{ asset('jstodolist.js.download') }}"></script>
    <!-- endinject -->
    <!-- Custom js for this page-->
    <script src="{{ asset('js/dashboard.js.download') }}"></script>
    <script src="{{ asset('js/data-table.js.download') }}"></script>
    <script src="{{ asset('js/dataTables.bootstrap4.js.download') }}"></script>
    <script src="{{ asset('js/data-table.js.download') }}"></script>
    <!-- End custom js for this page-->
    @yield('script')



</body>
<grammarly-desktop-integration data-grammarly-shadow-root="true"></grammarly-desktop-integration>

</html>
