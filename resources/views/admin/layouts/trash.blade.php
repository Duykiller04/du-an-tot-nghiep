<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg"
    data-sidebar-image="none" data-preloader="disable">

<head>

    <meta charset="utf-8" />
    <title> @yield('title') </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />

    <link rel="icon" href="{{ asset('theme/admin/assets/images/logo-sm.png') }}" type="image/x-icon">

    @yield('style-libs')

    @include('admin.layouts.partials.css')

    @yield('css')

</head>

<body>

    @if (Session::has('error') || Session::has('success'))
        @include('admin.layouts.partials.notification')
    @endif


    <!--preloader-->
    {{-- <div id="preloader">
        <div id="status">
            <div class="spinner-border text-primary avatar-sm" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </div> --}}

    <!-- Begin page -->
    <div id="layout-wrapper">

        @include('admin.layouts.partials.nav')

        <!-- ========== App Menu ========== -->
        @include('admin.layouts.partials.side-bar')
        <!-- Left Sidebar End -->
        <!-- Vertical Overlay-->
        <div class="vertical-overlay"></div>

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">

                    <div class="row">
                        @yield('content')
                    </div>

                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->

            @include('admin.layouts.partials.footer')
        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->
    <!-- JAVASCRIPT -->
    @include('admin.layouts.partials.js')

    @yield('script-libs')

    @yield('js')

</body>

</html>

@php
    session()->forget('success');
@endphp
