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
                                      
                                    @endphp
                                    
                                    @foreach($get_data['bank'] as $get_data_bank)
                                        @php 
                                            $rowspan = count($get_data_bank['transactions']);
                                        @endphp
                                           
                                        <tr>
                                            <td rowspan="{{ $rowspan }}">{{$sl++}}</td>
                                            <td rowspan="{{ $rowspan }}">{{ $get_data_bank['bank_name'] }}</td>
                                            @php 
                                                for($i=0; $i<$rowspan; $i++){
                                                    if($i > 0) { break; }
                                                    @endphp 
                                                        <td>{{ $get_data_bank['transactions'][$i]['trn_type'] }}</td>
                                                        <td>{{ $get_data_bank['transactions'][$i]['no_of_trn'] }}</td>
                                                        <td>{{ $get_data_bank['transactions'][$i]['total_zar_amt'] }}</td>
                                                        <td>{{ $get_data_bank['transactions'][$i]['total_bdt_amt'] }}</td>                                                       
                                                    @php 
                                                }
                                            @endphp                                           
                                            <td rowspan="{{ $rowspan }}">{{ number_format($get_data_bank['total_amount'],2); }}</td>
                                        </tr>  

                                        @php 
                                            for($j=1; $j<$rowspan; $j++){
                                                @endphp
                                                <tr>
                                                    <td>{{ $get_data_bank['transactions'][$j]['trn_type'] }}</td>
                                                    <td>{{ $get_data_bank['transactions'][$j]['no_of_trn'] }}</td>
                                                    <td>{{ $get_data_bank['transactions'][$j]['total_zar_amt'] }}</td>
                                                    <td>{{ $get_data_bank['transactions'][$j]['total_bdt_amt'] }}</td>    
                                                </tr>   
                                                @php 
                                            }
                                        @endphp 

                                        
                                    @endforeach
                                    
                                    <!-- <tr>
                                        <td rowspan="3">1</td>
                                        <td>Johannesburg</td>
                                        <td rowspan="3">Southeast Bank Ltd.</td>
                                        <td>Cash</td>
                                        <td>14</td>
                                        <td>124900.00</td>
                                        <td>749400.00</td>
                                        <td rowspan="3">12135752.00</td>
                                    </tr>

                                    <tr>
                                        
                                        <td>Johannesburg</td>
                                       
                                        <td>Bank Deposit</td>
                                        <td>47</td>
                                        <td>124900.00</td>
                                        <td>749400.00</td>
                                     
                                    </tr>

                                    <tr>
                                        
                                        <td>Johannesburg</td>
                                       
                                        <td>EFTN</td>
                                        <td>94</td>
                                        <td>124900.00</td>
                                        <td>749400.00</td>
                                        
                                    </tr>



                                    <tr>
                                        <td rowspan="3">2</td>
                                        <td>Johannesburg</td>
                                        <td rowspan="3">Southeast Bank Ltd.</td>
                                        <td>Cash</td>
                                        <td>14</td>
                                        <td>124900.00</td>
                                        <td>749400.00</td>
                                        <td rowspan="3">12135752.00</td>
                                    </tr>

                                    <tr>
                                        
                                        <td>Johannesburg</td>
                                       
                                        <td>Bank Deposit</td>
                                        <td>47</td>
                                        <td>124900.00</td>
                                        <td>749400.00</td>
                                     
                                    </tr>

                                    <tr>
                                        
                                        <td>Johannesburg</td>
                                       
                                        <td>EFTN</td>
                                        <td>94</td>
                                        <td>124900.00</td>
                                        <td>749400.00</td>
                                        
                                    </tr> -->

                                </tbody>
                                <!-- <tfoot>
                                    <tr>
                                        <th>Sl</th>
                                        <th>Exchange House</th>
                                        <th>Payee Bank</th>
                                        <th>Txn. Type</th>
                                        <th>No Of Transaction </th>
                                        <th>Total ZAR Amount</th>
                                        <th>Total BDT Amount</th>
                                        <th>Total Payable in BDT</th>
                                    </tr>
                                </tfoot> -->
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
