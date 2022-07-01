@extends('layouts.admin')
@section('title') Reconciliation Report (Reportable Transaction) @endsection
@section('report')has-treeview menu-open @endsection

@section('reconcilation_report') active @endsection

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
                        <h1 class="m-0">Reconciliation Report (Reportable Transaction)</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Reconciliation Report (Reportable Transaction)</li>
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
                            <h3 class="card-title">Reconciliation Report (Reportable Transaction)</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Sl</th>
                                        <th>Particulars</th>
                                        <th>Nos. of Transactions </th>
                                        <th>Total Ammount in ZAR</th>
                                        <th>Total Ammount in BDT</th>

                                    </tr>
                                </thead>
                                
                                <tbody>
                                    
                                   <tr>

                                       <td>01</td>
                                       <td>New Transaction</td>
                                       <td>218</td>
                                       <td>2697187.78</td>
                                       <td>16281380.68</td>

                                   </tr>

                                     <tr>

                                       <td>02</td>
                                       <td>Transaction Cancelled</td>
                                       <td>0</td>
                                       <td>0.0</td>
                                       <td>0.00</td>

                                   </tr>

                                   <tr>

                                       <td>03</td>
                                       <td>Transaction Sent to Bank</td>
                                       <td>1</td>
                                       <td>14900.00</td>
                                       <td>90000.00</td>

                                   </tr>

                                   <tr>

                                       <td>04</td>
                                       <td>Total Transaction Created</td>
                                       <td>219</td>
                                       <td>2712087.78</td>
                                       <td>16371380.68</td>

                                   </tr>
                                    <tr>

                                       <td>05</td>
                                       <td>Pending Sent to SARB</td>
                                       <td>1</td>
                                       <td>14900.00</td>
                                       <td>90000.00</td>

                                   </tr> 
                                   
                                   <tr>

                                       <td>06</td>
                                       <td>Transaction Sent to SARB</td>
                                       <td>0</td>
                                       <td>0.00</td>
                                       <td>0.00</td>

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
