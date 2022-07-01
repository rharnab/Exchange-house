<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Exchange House | @yield('title')</title>
    @include('admin.inc.header')
</head>
<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="{{ asset('support_files/img/AdminLTELogo.png') }}" alt="AdminLTELogo" height="60" width="60">
        </div>

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link">Home</a>
                </li>

                <li class="nav-item d-none d-sm-inline-block">
                    <a class="nav-link"><span style="color: #1166B2;text-transform: capitalize">{{ Auth::user()->user_id }}</span> is accessing from {{ Auth::user()->agent_br_id }}</a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        {{-- Sidebar --}}
        @include('admin.inc.sidebar')

        @yield('main-content')
        <!-- /.content-wrapper -->
        <footer class="main-footer">
            <strong>
                Copyright &copy;
                <script>new Date().getFullYear()>document.write(new Date().getFullYear());</script>
                <a href="http://venturesolutionsltd.com/" target="_blank">Venture Solutions Ltd</a>.
            </strong>
            All rights reserved.
        </footer>
    </div>
    <!-- ./wrapper -->

    <!-- jQuery Start -->
    @include('admin.inc.js')
    <!-- jQuery End -->
</body>
</html>
