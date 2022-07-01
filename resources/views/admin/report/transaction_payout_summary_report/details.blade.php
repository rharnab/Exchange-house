@extends('layouts.admin')
@section('title') Transaction Payout Summary  Report @endsection
@section('report')has-treeview menu-open @endsection

@section('transaction_payout_summary_report') active @endsection

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
                        <h1 class="m-0">Transaction Payout Summary  Report</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Transaction Payout Summary  Report</li>
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
                            <h3 class="card-title">Transaction Payout Summary  Report</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped table-responsive">
                                <thead>
                                    <tr>
                                        <th>Sl</th>
                                        <th>Payee Bank</th>
                                        <th>Exchange House </th>
                                        <th>Txn. Type</th>
                                        <th>No Of Transaction </th>
                                        <th>Total ZAR Amount</th>
                                        <th>Total BDT Amount</th>
                                        <th>Total Payable in BDT</th>
                                        
                                       
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                    @php 
                                        $sl=1;
                                        $total_trn_count =0;
                                        $no_of_trn1 =0;
                                        $no_of_trn2 =0;

                                        $final_no_of_trn =0;

                                        $total_zar_amt1 = 0;
                                        $total_zar_amt2 = 0;
                                        $final_zar_amt = 0;

                                        $total_bdt_amt1 = 0;
                                        $total_bdt_amt2 = 0;
                                        $final_bdt_amt = 0;

                                        $total_payable_bdt = 0;
                                    @endphp
                                    
                                    @foreach($get_data['bank'] as $single_data)
                                        @php
                                            $total_trn_count = count($single_data['transaction']);

                                            $total_payable_bdt = $total_payable_bdt + $single_data['amount'];
                                        @endphp

                                           <tr>
                                               <td rowspan="{{$total_trn_count}}">{{$sl++}}</td>
                                               <td rowspan="{{$total_trn_count}}">{{$single_data['bank_name']}}</td>
                                               @php
                                               for($i=0;$i<$total_trn_count;$i++){

                                                    if($i>0){continue;}

                                                    @endphp
                                                        <td>{{$single_data['transaction'][$i]['exchange_house_location']}}</td>
                                                        <td>{{$single_data['transaction'][$i]['trn_type']}}</td>
                                                        <td>{{$single_data['transaction'][$i]['no_of_trn']}}</td>
                                                        <td>{{$single_data['transaction'][$i]['total_zar_amt']}}</td>
                                                        <td>{{$single_data['transaction'][$i]['total_bdt_amt']}}</td>
                                                    @php

                                                    $no_of_trn1 = $no_of_trn1 + $single_data['transaction'][$i]['no_of_trn'];
                                                    $total_zar_amt1 = $total_zar_amt1 + $single_data['transaction'][$i]['total_zar_amt'];
                                                    $total_bdt_amt1 = $total_bdt_amt1 + $single_data['transaction'][$i]['total_bdt_amt'];
                                                    }
                                                    @endphp
                                               <td rowspan="{{$total_trn_count}}">{{$single_data['amount']}}</td>
                                           </tr>
                                           
                                           @php 
                                           for($j=1;$j<$total_trn_count;$j++){
                                           @endphp
                                           <tr>
                                                <td>{{$single_data['transaction'][$j]['exchange_house_location']}}</td>
                                                <td>{{$single_data['transaction'][$j]['trn_type']}}</td>
                                                <td>{{$single_data['transaction'][$j]['no_of_trn']}}</td>
                                                <td>{{$single_data['transaction'][$j]['total_zar_amt']}}</td>
                                                <td>{{$single_data['transaction'][$j]['total_bdt_amt']}}</td>
                                           </tr>
                                           @php

                                           $no_of_trn2 = $no_of_trn2 + $single_data['transaction'][$j]['no_of_trn'];
                                           $total_zar_amt2 = $total_zar_amt2 + $single_data['transaction'][$j]['total_zar_amt'];
                                            $total_bdt_amt2 = $total_bdt_amt2 + $single_data['transaction'][$j]['total_bdt_amt'];
                                           }

                                           $final_no_of_trn = $no_of_trn1 + $no_of_trn2;
                                           $final_zar_amt = $total_zar_amt1 + $total_zar_amt2;
                                           $final_bdt_amt = $total_bdt_amt1 + $total_bdt_amt2;

                                           @endphp
                                    @endforeach
                                    

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th>Total = </th>
                                        <th>{{ number_format($final_no_of_trn,2) }} </th>
                                        <th>{{ number_format($final_zar_amt,2) }}</th>
                                        <th>{{ number_format($final_bdt_amt, 2)}}</th>
                                        <th>{{  number_format($total_payable_bdt,2) }}</th>
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
