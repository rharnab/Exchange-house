@extends('layouts.admin')
@section('title') Beneficiary Wise  Report @endsection
@section('report')has-treeview menu-open @endsection

@section('beneficiary_wise_report') active @endsection

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
                        <h1 class="m-0">Beneficiary Wise  Report</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Beneficiary Wise  Report</li>
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
                            <h3 class="card-title">Beneficiary Wise  Report</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped table-responsive">
                                <thead>
                                    <tr>
                                        <th>Sl</th>
                                        <th>TXN Date</th>
                                        <th>Beneficiary Name</th>
                                        <th>TXN Refference No</th>
                                        <th>Payment Bank</th>
                                        <th>Branch Name</th>
                                        <th>Payment Mode</th>
                                        <th>Remitter Name</th>
                                        <th>Remitter A/c</th>
                                        <th>Remittance BDT Amount</th>
                                        <th>Remittance ZAR Amount</th>
                                        <th>Total ZAR Received</th>
                                        <th>ZAR Receive Mode</th>
                                        <th>Exchange House</th>
                                       
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $sl = 1;
                                        $total_remittance_bdt_amt = 0;
                                        $total_remittance_zar_amt = 0;
                                        $total_zar_received = 0;

                                    @endphp

                                    @foreach($get_data as $single_data)

                                    @php 
                                        $total_remittance_bdt_amt = $total_remittance_bdt_amt + $single_data->disbursement_amount;
                                        $total_remittance_zar_amt = $total_remittance_zar_amt + $single_data->originated_amount;
                                        $total_zar_received = $total_zar_received + $single_data->total_zar_received;
                                    @endphp
                                    <tr>
                                        <td>{{$sl++}}</td>
                                        <td>{{$single_data->trn_date}}</td>
                                        <td>{{$single_data->receiver_name}}</td>
                                        <td>{{$single_data->order_no}}</td>
                                        <td>{{$single_data->bank_name}}</td>
                                        <td>{{$single_data->branch_name}}</td>
                                        <td>@if($single_data->payment_mode=='1') {{'Cash Pickup'}} @elseif($single_data->payment_mode=='2') {{'Bank Deposit'}}  @endif</td>
                                        <td>{{$single_data->sender_name}}</td>
                                        <td>{{$single_data->sender_account_number}}</td>
                                        <td>{{$single_data->disbursement_amount}}</td>
                                        <td>{{$single_data->originated_amount}}</td>
                                        <td>{{$single_data->total_zar_received}}</td>
                                        <td>@if($single_data->sender_transaction_receiving_mode=='1') {{'Cash'}} @elseif($single_data->sender_transaction_receiving_mode=='2') {{'Online'}}   @endif</td>
                                        <td>{{$single_data->exchange_location}}</td>
                                       
                                        
                                    </tr>

                                    @endforeach
                                    
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th>Sub Total = </th>
                                        <th>{{$total_remittance_bdt_amt}}</th>
                                        <th>{{$total_remittance_zar_amt}}</th>
                                        <th>{{$total_zar_received}}</th>
                                        <th></th>
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
