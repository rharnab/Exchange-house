@extends('layouts.admin')
@section('title') Sanction report of customers @endsection
@section('sanction_report')has-treeview menu-open @endsection
@section('sanction_report') active @endsection
@section('customer') active @endsection

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
                        <h1 class="m-0">Sanction report</h1>
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

        @if(Session::get('message'))
            <script>alert('{{ Session::get('message') }}')</script>
        @endif

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Customer report</h3>
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>Sl</th>
                                    <th>Customer name</th>
                                    <th>Maker sanction value</th>
                                    <th>Checker sanction value</th>
                                    <th>Sanction source</th>
                                    <th>Sanction Remarks</th>
                                    <th>Operation name</th>
                                    <th>Entry by</th>
                                    <th>Entry date</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php
                                    $i = 1;
                                    $data = App\Models\CustomerInfo::where('id', $info->id)->where('status', 1)->get();
                                @endphp
                                @foreach($data as $customer)
                                    @php
                                        $logs = App\Models\SanctionLog::where('operation_id', $customer->id)->where('type', 'Customer')->get();
                                    @endphp
                                    @foreach($logs as $log)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>{{ $log->customer->name }}</td>
                                            <td>{{ $log->sanction_value }}</td>
                                            <td>{{ $customer->sanction_score_auth }}</td>
                                            <td>{{ $log->sanction_table }}</td>
                                            <td>{{ $log->sanction_remarks }}</td>
                                            <td>{{ $log->operation_name }}</td>
                                            <td>{{ $log->entry_by }}</td>
                                            <td>{{ $log->entry_date }}</td>
                                        </tr>
                                    @endforeach

                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>Sl</th>
                                    <th>Customer name</th>
                                    <th>Maker sanction value</th>
                                    <th>Checker sanction value</th>
                                    <th>Sanction source</th>
                                    <th>Sanction Remarks</th>
                                    <th>Operation name</th>
                                    <th>Entry by</th>
                                    <th>Entry date</th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Account report</h3>
                        </div>
                        <div class="card-body">
                            <table id="example2" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>Sl</th>
                                    <th>Customer name</th>
                                    <th>Maker sanction value</th>
                                    <th>Checker sanction value</th>
                                    <th>Sanction source</th>
                                    <th>Sanction Remarks</th>
                                    <th>Operation name</th>
                                    <th>Entry by</th>
                                    <th>Entry date</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php
                                    $i = 1;
                                    $data = App\Models\CustomerInfo::where('id', $info->id)->where('status', 1)->get();
                                @endphp
                                @foreach($data as $customer)
                                    @php
                                        $accounts = App\Models\AccountOpening::where('customer_id', $customer->id)->get();
                                    @endphp
                                    @foreach($accounts as $account)
                                        @php
                                            $logs = App\Models\SanctionLog::where('operation_id', $account->id)->where('type', 'Account')->get();
                                        @endphp
                                        @foreach($logs as $log)
                                            <tr>
                                                <td>{{ $i++ }}</td>
                                                <td>{{ $account->customer->name }}</td>
                                                <td>{{ $log->sanction_value }}</td>
                                                <td>{{ $customer->sanction_score_auth }}</td>
                                                <td>{{ $log->sanction_table }}</td>
                                                <td>{{ $log->sanction_remarks }}</td>
                                                <td>{{ $log->operation_name }}</td>
                                                <td>{{ $log->entry_by }}</td>
                                                <td>{{ $log->entry_date }}</td>
                                            </tr>
                                        @endforeach
                                    @endforeach
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>Sl</th>
                                    <th>Customer name</th>
                                    <th>Maker sanction value</th>
                                    <th>Checker sanction value</th>
                                    <th>Sanction source</th>
                                    <th>Sanction Remarks</th>
                                    <th>Operation name</th>
                                    <th>Entry by</th>
                                    <th>Entry date</th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Transaction report</h3>
                        </div>
                        <div class="card-body">
                            <table id="example3" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>Sl</th>
                                    <th>Customer name</th>
                                    <th>Maker sanction value</th>
                                    <th>Checker sanction value</th>
                                    <th>Sanction source</th>
                                    <th>Sanction Remarks</th>
                                    <th>Operation name</th>
                                    <th>Entry by</th>
                                    <th>Entry date</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php
                                    $i = 1;
                                    $data = App\Models\CustomerInfo::where('id', $info->id)->where('status', 1)->first()->id;
                                @endphp
                                    @php
                                        $accounts = App\Models\Transaction::where('sender_id', $data)->get();
                                    @endphp
                                    @foreach($accounts as $account)
                                        @php
                                            $logs = App\Models\SanctionLog::where('operation_id', $account->id)->where('type', 'Transaction')->get();
                                        @endphp
                                        @foreach($logs as $log)
                                            <tr>
                                                <td>{{ $i++ }}</td>
                                                <td>
                                                    @php
                                                        $customers = App\Models\CustomerInfo::where('id', $data)->get();
                                                    @endphp
                                                    @foreach($customers as $cusData)
                                                        {{ $cusData->name }}
                                                    @endforeach
                                                </td>
                                                <td>{{ $log->sanction_value }}</td>
                                                <td>{{ $customer->sanction_score_auth }}</td>
                                                <td>{{ $log->sanction_table }}</td>
                                                <td>{{ $log->sanction_remarks }}</td>
                                                <td>{{ $log->operation_name }}</td>
                                                <td>{{ $log->entry_by }}</td>
                                                <td>{{ $log->entry_date }}</td>
                                            </tr>
                                        @endforeach
                                    @endforeach

                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>Sl</th>
                                    <th>Customer name</th>
                                    <th>Maker sanction value</th>
                                    <th>Checker sanction value</th>
                                    <th>Sanction source</th>
                                    <th>Sanction Remarks</th>
                                    <th>Operation name</th>
                                    <th>Entry by</th>
                                    <th>Entry date</th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
            <!-- /.row -->
        </section>
    </div>
@endsection

@push('scripts')
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
                "responsive": true, "lengthChange": false, "autoWidth": false,
            });

            $("#example2").DataTable({
                "responsive": true, "lengthChange": false, "autoWidth": false,
            });

            $("#example3").DataTable({
                "responsive": true, "lengthChange": false, "autoWidth": false,
            });

        });
    </script>
@endpush
