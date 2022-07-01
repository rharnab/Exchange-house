@extends('layouts.admin')
@section('title') Rate History Report @endsection
@section('report')has-treeview menu-open @endsection

@section('rate_history_report') active @endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('support_files/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('support_files/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('support_files/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endpush

@section('main-content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Rate History Report</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Report</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->


        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Rate History Report  <span style="margin-left:50px;"> From Date : 24-03-2022, To Date : 24-03-2022 </span></h3>
                            
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            
                            <table id="example1" class="table table-bordered table-striped ">
                                <thead>

                                   
                                    <tr>

                                       <th>SL</th>
                                       <th>Rate</th>
                                       <th>Cross Rate</th>
                                       <th>Buy Rate</th>
                                       <th>Sell Rate</th>
                                       <th>Exchange Margin</th>
                                       <th>Updated By</th>
                                       <th>Bank</th>
                                       <th>Updated On</th>

                                    </tr>
                                </thead>
                                <tbody>
                                  
                                   
                                   <tr>

                                      <td>1</td>
                                      <td>88.1 (BDT)</td>
                                      <td>14.59 (ZAR)</td>
                                      <td>5.94</td>
                                      <td>6</td>
                                      <td>0.04</td>
                                      <td>Bulbul Ahmed</td>
                                      <td>SOUTHEAST BANK LTD</td>
                                      <td>25-mar-2022</td>

                                   </tr>

                                   <tr>

                                      <td>2</td>
                                      <td>88.1 (BDT)</td>
                                      <td>14.59 (ZAR)</td>
                                      <td>6.94</td>
                                      <td>5.90</td>
                                      <td>0.04</td>
                                      <td>Bulbul Ahmed</td>
                                      <td>SOUTHEAST BANK LTD</td>
                                      <td>25-mar-2022</td>

                                   </tr>
                                   
                                 
                                   
                                </tbody>

                                
                            </table>

                           
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </section>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('support_files/plugins/jquery-2.2.4.min.js') }}"></script>
    <script src="{{ asset('support_files/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('support_files/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('support_files/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('support_files/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('support_files/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('support_files/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('support_files/plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('support_files/plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('support_files/plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('support_files/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('support_files/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('support_files/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>

    <script>
        $(function () {
            $("#example1").DataTable({
                destroy: true,
                "responsive": false, "lengthChange": false, "autoWidth": false,
                "buttons": ["csv", "excel"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });
    </script>
@endpush
