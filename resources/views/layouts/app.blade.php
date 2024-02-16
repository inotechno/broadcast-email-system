<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from admin.pixelstrap.com/zeta/theme/sample-page.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 16 Sep 2022 12:02:09 GMT -->

<head>
    @include('layouts.partials.head')
</head>

<body data-sidebar="dark" data-layout-mode="light">

    <!-- Begin page -->
    <div id="layout-wrapper">

        <header id="page-topbar">
            @livewire('component.header')
        </header>

        <!-- ========== Left Sidebar Start ========== -->
        <div class="vertical-menu">
            <div data-simplebar class="h-100">
                @livewire('component.sidebar')
            </div>
        </div>

        <!-- Left Sidebar End -->

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            <div class="page-content">
                {{ $slot }}
            </div>
            <!-- End Page-content -->

            @include('layouts.partials.footer')
        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->

    @include('layouts.partials.plugin')

    <!-- login js-->
    <!-- Plugin used-->
</body>

<!-- Mirrored from admin.pixelstrap.com/zeta/theme/sample-page.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 16 Sep 2022 12:02:09 GMT -->

</html>
