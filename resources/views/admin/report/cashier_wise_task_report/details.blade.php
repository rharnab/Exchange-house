@extends('layouts.admin')
@section('title') Cashier Wise Task Report @endsection
@section('report')has-treeview menu-open @endsection

@section('cashier_wise_task_report') active @endsection

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
                        <h1 class="m-0">Cashier Wise Task Report</h1>
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
                            <h3 class="card-title">Cashier Wise Task Report</h3>

                           
                        </div>
                        <!-- /.card-header -->

                        
                        <div class="card-body">
                       
                            <table id="example1" class="table table-responsive table-bordered table-striped ">
                                <thead>
                                   
                                    <tr>
                                        <th colspan="5">Cashier Name :</th>
                                        <td colspan="5">Mohammed Saleh Uddin</td>
                                        <td colspan="10"></td>
                                    </tr>
                                    
                                    <tr>
                                        <th colspan="5">Tasks</th>
                                        <td colspan="5">10</td>
                                        <td colspan="10"></td>
                                    </tr>
                                        <br>

                                    <tr>

                                        <th>Sl</th>
                                        <th>Date</th>
                                        <th>Ref No</th>
                                        <th>Customer A/C No</th>
                                        <th>Sell Rate</th>
                                        <th>Buy Rate</th>
                                        <th>Taka Equivalent</th>
                                        <th>Remittance ZAR</th>
                                        <th>TT Payable</th>
                                        <th>Comm</th>
                                        <th>Vat</th>
                                        <th>Gain / Loss</th>
                                        <th>Discount</th>
                                        <th>Net Comm.</th>
                                        <th>Total Due</th>
                                        <th>Received in Till</th>
                                        <th>Received Online</th>
                                        <th>Received by Card</th>
                                        <th>Cr. Card Charge</th>
                                        <th>Total Card Charge</th>
                                        

                                    </tr>
                                </thead>
                                <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>25-03-2022</td>
                                            <td>SECL534320</td>
                                            <td>102447</td>
                                            <td>6.0</td>
                                            <td>6.04</td>
                                            <td>60000.00</td>
                                            <td>10000.00</td>
                                            <td>9933.11</td>
                                            <td>86.96</td>
                                            <td>13.04</td>
                                            <td>66.89</td>
                                            <td>0.00</td>
                                            <td>86.96</td>
                                            <td>10100.00</td>
                                            <td>10100.00</td>
                                            <td>0.00</td>
                                            <td>0.00</td>
                                            <td>0.00</td>
                                            <td>0.00</td>
                                          
                                        </tr>

                                        <tr>
                                            <td>2</td>
                                            <td>25-03-2022</td>
                                            <td>SECL534321</td>
                                            <td>1028758</td>
                                            <td>6.0</td>
                                            <td>6.04</td>
                                            <td>71400.00</td>
                                            <td>11900.0</td>
                                            <td>11900.00</td>
                                            <td>86.96</td>
                                            <td>13.04</td>
                                            <td>66.89</td>
                                            <td>0.00</td>
                                            <td>86.96</td>
                                            <td>12000.00</td>
                                            <td>12000.00</td>
                                            <td>0.00</td>
                                            <td>0.00</td>
                                            <td>0.00</td>
                                            <td>0.00</td>
                                          
                                        </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                       
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th>Grand Total</th>
                                        <th>840440</th>
                                        <th>140093</th>
                                        <th>139153</th>
                                        <th>1467</th>
                                        <th>220.1</th>
                                        <th>939.0</th>
                                        <th>0.0</th>
                                        <th>1467.86</th>
                                        <th>141781.0</th>
                                        <th>141781.0</th>
                                        <th>0.0</th>
                                        <th>0.0</th>
                                        <th>0.0</th>
                                        <th>0.0</th>
                                        
                                    </tr>
                                </tfoot>
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
