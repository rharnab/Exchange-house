@extends('layouts.admin')
@section('title') Bank Wise Online Summary Report @endsection
@section('report')has-treeview menu-open @endsection

@section('bank_wise_online_summary_report') active @endsection

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
                        <h1 class="m-0">Bank Wise Online Summary Report</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Bank Wise Online Summary Report</li>
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
                            <h3 class="card-title">Bank Wise Online Summary Report</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped table-responsive">
                                <thead>
                                    <tr>
                                        <th>Sl</th>
                                        <th>Exchange House</th>
                                        <th>Fund Receiving Bank</th>
                                        <th>Nos.of Total Transaction</th>
                                        <th>Remittance ZAR Received (With Commission & Charge)</th>
                                        <th>Total Online Charge</th>
                                        <th>Remarks</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php 
                                    
                                        $sl = 1;
                                    
                                        $total_no_transaction = 0;
                                        $total_zar_with_charge = 0;
                                        $total_online_charge = 0;

                                    @endphp
                                    @foreach($get_data as $single_data)

                                        @php
                                        $total_no_transaction = $total_no_transaction + $single_data->number_of_total_transaction;
                                        $total_zar_with_charge = $total_zar_with_charge + $single_data->zar_with_charge;
                                        $total_online_charge = $total_online_charge + (($single_data->zar_with_charge*1)/100);

                                        @endphp
                                    <tr>
                                        <td>{{$sl++}}</td>
                                        <td>{{$single_data->exchange_house_location}}</td>
                                        <td>{{$single_data->bank_name}}</td>
                                        <td>{{$single_data->number_of_total_transaction}}</td>
                                        <td>{{$single_data->zar_with_charge}}</td>
                                        <td>{{($single_data->zar_with_charge*1)/100}}</td>
                                        <td>{{$single_data->remarks}}</td>
                                        
                                    </tr>

                                    @endforeach
                                    
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th>Sub Total</th>
                                        <th><?php echo $total_no_transaction; ?></th>
                                        <th> <?php echo $total_zar_with_charge; ?></th>
                                        <th><?php echo $total_online_charge; ?></th>
                                        <th></th>
                                        
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
                "buttons": ["pdf","csv", "excel"]
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
