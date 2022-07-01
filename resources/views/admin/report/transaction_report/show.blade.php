@extends('layouts.admin')
@section('title') Transaction  Report @endsection
@section('report')has-treeview menu-open @endsection
@section('report_a') active @endsection
@section('transaction') active @endsection

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
                        <h1 class="m-0">Transaction Report</h1>
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
                            <h3 class="card-title">Transaction Report</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped table-responsive">
                                <thead>
                                    <tr>
                                        <th>Sl</th>
                                        <th>Agent</th>
                                        <th>Transaction Type</th>
                                        <th>Status</th>
                                        <th>Order number</th>
                                        <th>Transaction Date</th>
                                        <th>Receiver Name</th>
                                        <th>Receiver Country</th>
                                        <th>Receiver Sub Country / Division</th>
                                        <th>Receiver District</th>
                                        <th>Receiver Address</th>
                                        <th>Receiver Contact</th>
                                        <th>Sender & receiver relation</th>
                                        <th>Purpose of sending</th>
                                        <th>Receiver Bank</th>
                                        <th>Receiver Bank Branch</th>
                                        <th>Receiver bank branch routing number</th>
                                        <th>Receiver Account number</th>
                                        <th>Sender number</th>
                                        <th>Sender Country</th>
                                        <th>Sender Sub Country level 1 / Division</th>
                                        <th>Sender Address Line</th>
                                        <th>Sender Contact</th>
                                        <th>Sender email</th>
                                        <th>Payment Mode</th>
                                        <th>Transaction PIN</th>
                                        <th>Sender currency</th>
                                        <th>Sender Amount</th>
                                        <th>Exchange Rate</th>
                                        <th>Disbursement Currency</th>
                                        <th>Disbursement Amount</th>
                                        <th>Remarks</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @php($i = 1)
                                    @foreach($get_transaction_report as $single_data)

                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $single_data->agent->name }}</td>
                                        <td>
                                            @if($single_data->trnTp == 'A')
                                                Account Credit
                                            @else
                                                Cash Payment
                                            @endif
                                        </td>
                                        <td>
                                            @if($single_data->stLevel == 0)
                                                Created
                                            @elseif($single_data->stLevel == 1)
                                                Authorized
                                            @elseif($single_data->stLevel == 3)
                                                Declined
                                            @endif
                                        </td>
                                        <td>{{ $single_data->order_no }}</td>
                                        <td>{{ $single_data->trn_date }}</td>
                                        <td>{{ $single_data->receiver_name }}</td>
                                        <td>{{ $single_data->country->name }}</td>
                                        <td>{{ $single_data->receiverDivision->name }}</td>
                                        <td>{{ $single_data->receiverCity->name }}</td>
                                        <td>{{ $single_data->receiver_address }}</td>
                                        <td>{{ $single_data->receiver_contact }}</td>
                                        <td>{{ $single_data->receiver_and_sender_relation }}</td>
                                        <td>{{ $single_data->purpose_of_sending }}</td>
                                        <td>{{ $single_data->receiver_bank_br_routing_number }}</td>
                                        <td>
                                            {{ $single_data->receiver_bank == '' ? '' : $single_data->receiverBank->name }}
                                        </td>
                                        <td>{{ $single_data->receiver_bank_branch == '' ? '' : $single_data->receiverBankBranch->name }}</td>
                                        <td>{{ $single_data->receiver_account_number }}</td>

                                        <td>{{ $single_data->sender_name }}</td>
                                        <td>{{ $single_data->sender_country }}</td>
                                        <td>{{$single_data->sender_sub_country_level_1}}</td>
                                        <td>{{$single_data->sender_address_line}}</td>
                                        <td>{{$single_data->sender_contact}}</td>
                                        <td>{{$single_data->sender_email}}</td>
                                        <td>
                                            @if($single_data->payment_mode == 1)
                                                Cash pickup
                                            @else
                                                Bank deposit
                                            @endif
                                        </td>
                                        <td>{{ $single_data->transaction_pin }}</td>

                                        <td>{{ $single_data->sCurrency->name }}</td>
                                        <td>{{ $single_data->originated_amount }}</td>
                                        <td>{{ $single_data->exchange_rate }}</td>

                                        <td>{{ $single_data->currency->name }}</td>
                                        <td>{{ $single_data->disbursement_amount }}</td>

                                        <td>{{ $single_data->remarks }}</td>
                                    </tr>

                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Sl</th>
                                        <th>Agent</th>
                                        <th>Transaction Type</th>
                                        <th>Status</th>
                                        <th>Order number</th>
                                        <th>Transaction Date</th>
                                        <th>Receiver Name</th>
                                        <th>Receiver Country</th>
                                        <th>Receiver Sub Country / Division</th>
                                        <th>Receiver District</th>
                                        <th>Receiver Address</th>
                                        <th>Receiver Contact</th>
                                        <th>Sender & receiver relation</th>
                                        <th>Purpose of sending</th>
                                        <th>Receiver Bank</th>
                                        <th>Receiver Bank Branch</th>
                                        <th>Receiver bank branch routing number</th>
                                        <th>Receiver Account number</th>

                                        <th>Sender number</th>
                                        <th>Sender Country</th>
                                        <th>Sender Sub Country level 1 / Division</th>
                                        <th>Sender Address Line</th>
                                        <th>Sender Contact</th>
                                        <th>Sender email</th>

                                        <th>Payment Mode</th>
                                        <th>Transaction PIN</th>
                                        <th>Sender currency</th>
                                        <th>Sender Amount</th>
                                        <th>Exchange Rate</th>
                                        <th>Disbursement Currency</th>
                                        <th>Disbursement Amount</th>
                                        <th>Remarks</th>
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
