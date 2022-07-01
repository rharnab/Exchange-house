<!-- Google Font: Source Sans Pro -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
<!-- Font Awesome -->
<link rel="stylesheet" href="{{ asset('support_files/plugins/fontawesome-free/css/all.min.css') }}">
<!-- Ionicons -->
<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
<!-- Tempusdominus Bootstrap 4 -->
<link rel="stylesheet" href="{{ asset('support_files/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
<!-- iCheck -->
<link rel="stylesheet" href="{{ asset('support_files/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
<!-- JQVMap -->
<link rel="stylesheet" href="{{ asset('support_files/plugins/jqvmap/jqvmap.min.css') }}">
<!-- Theme style -->
<link rel="stylesheet" href="{{ asset('support_files/css/adminlte.min.css') }}">
<!-- overlayScrollbars -->
<link rel="stylesheet" href="{{ asset('support_files/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
<!-- Daterange picker -->
<link rel="stylesheet" href="{{ asset('support_files/plugins/daterangepicker/daterangepicker.css') }}">
<!-- summernote -->
<link rel="stylesheet" href="{{ asset('support_files/plugins/summernote/summernote-bs4.min.css') }}">
<meta name="csrf-token" content="{{ csrf_token() }}" />

<style>
    .nav-pills .nav-link {
        border-radius: 0 !important;
    }
    .sidebar-dark-primary .nav-sidebar>.nav-item>.nav-link.active, .sidebar-light-primary .nav-sidebar>.nav-item>.nav-link.active {
        background-color: #1A2226;
        color: #fff;
        border-left: 3px solid #3C8DBC;
    }
    [class*=sidebar-dark-] {
        background-color: #222D32;
    }
    .os-content{
        padding: 0px !important;
        height: 100% !important;
        width: 100% !important;
    }
    .sidebar-mini .main-sidebar .nav-link, .sidebar-mini-md .main-sidebar .nav-link, .sidebar-mini-xs .main-sidebar .nav-link {
        width: calc(265px - 0.5rem * 2)  !important;
        transition: width ease-in-out .3s;
    }
    [class*=sidebar-dark-] .nav-treeview>.nav-item>.nav-link.active, [class*=sidebar-dark-] .nav-treeview>.nav-item>.nav-link.active:focus, [class*=sidebar-dark-] .nav-treeview>.nav-item>.nav-link.active:hover {
        background: #ffffff26 !important;
        color: #fff !important;
    }
    li.nav-item.menu-is-opening.menu-open {
        background: #2C3B41 !important;
    }
    [class*=sidebar-dark-] .nav-sidebar>.nav-item>.nav-treeview {
        background-color: #2C3B41;
    }
    li.nav-item a,i {
        font-size: 14px !important;
    }
    .custom_btn{
        background:#3872B7;
        color:#fff;
    }
    .custom_btn:hover{
        background:#275b99;
        color:#fff;
    }
</style>

@stack('styles')
@stack('scripts')

