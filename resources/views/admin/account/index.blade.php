@extends('layouts.admin')
@section('title') All account @endsection
@section('a_info')has-treeview menu-open @endsection
@section('a_info_a') active @endsection
@section('a_list') active @endsection

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
                        <h1 class="m-0">Account List</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Account list</li>
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
                            <h3 class="card-title">Customers</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>Sl</th>
                                    <th>Customer name</th>
                                    <th>Customer Maker sanction score</th>
                                    <th>Customer Checker sanction score</th>
                                    <th>Sanction source</th>
                                    <th>Sanction remarks</th>
                                    <th>Account type</th>
                                    <th>Interest rate</th>
                                    <th>Account no</th>
                                    <th>Customer signature</th>
                                    <th>Monthly income/transaction</th>
                                    <th>Nominee name</th>
                                    <th>Nominee Maker sanction score</th>
                                    <th>Nominee Checker sanction score</th>
                                    <th>Nominee contact</th>
                                    {{-- <th>Entry by</th>
                                    <th>Entry date</th> --}}
                                    <th>Auth by</th>
                                    <th>Auth date</th>
{{--                                    <th>Action</th>--}}
                                </tr>
                                </thead>
                                <tbody>
                                @php
                                    $i = 1;
                                @endphp
                                @foreach($accounts as $account)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $account->customer->name }}</td>
                                        @php
                                            $customersData = App\Models\CustomerInfo::where('id', $account->customer_id)->get();
                                        @endphp
                                        @foreach($customersData as $cusData)
                                            <td>
                                              {{ $cusData->sanction_score }}
                                            </td>
                                            <td>
                                                {{ $cusData->sanction_score_auth }}
                                            </td>
                                            <td>
                                                {{ $cusData->sanction_table }}
                                            </td>
                                            <td>
                                                {{ $cusData->sanction_remarks }}
                                            </td>
                                        @endforeach
                                        <td>{{ $account->accountType->name }}</td>
                                        <td>{{ $account->accountType->interest_rate }} %</td>
                                        <td>{{ $account->account_no }}</td>
                                        <td>
                                            <a href="{{ route('admin.download_signature', $account->id) }}">
                                                Download
                                            </a>
                                        </td>
                                        <td>{{ $account->probably_monthly_income }}/{{ $account->probably_monthly_transaction }}</td>
                                        <td>{{ $account->nominee_name }}</td>

                                        <td>{{ $account->sanction_score }}</td>
                                        <td>{{ $account->sanction_score_auth }}</td>

                                        <td>{{ $account->nominee_contact_no }}</td>
                                       {{--  <td>{{ $account->entry_by }}</td>
                                        <td>{{ $account->entry_date }}</td> --}}
                                        <td>
                                            @if($account->status == 0)
                                                Not authorized
                                            @else
                                                {{ $account->auth_by }}
                                            @endif
                                        </td>
                                        <td>
                                            @if($account->status == 0)
                                                Not authorized
                                            @else
                                                {{ $account->auth_date }}
                                            @endif
                                        </td>
{{--                                        <td>--}}
{{--                                            <a href="{{ url('/admin/customer-delete/'.$account->id) }}" class="btn btn-sm btn-danger" id="delete" title="Delete"><i class="fa fa-trash"></i> Delete</a>--}}
{{--                                            @if ($account->status == 1)--}}
{{--                                                <a href="{{ url('/admin/account-inactive/'.$account->id) }}" class="btn btn-sm btn-danger" title="Declined"> <i class="fa fa-arrow-down"></i> Declined</a>--}}
{{--                                            @else--}}
{{--                                                <a href="{{ url('/admin/account-active/'.$account->id) }}" class="btn btn-sm custom_btn" title="Authorized"> <i class="fa fa-arrow-up"></i> Authorized</a>--}}
{{--                                            @endif--}}
{{--                                        </td>--}}
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>Sl</th>
                                    <th>Customer name</th>
                                    <th>Customer Maker sanction score</th>
                                    <th>Customer Checker sanction score</th>
                                    <th>Sanction source</th>
                                    <th>Sanction remarks</th>
                                    <th>Account type</th>
                                    <th>Interest rate</th>
                                    <th>Account no</th>
                                    <th>Customer signature</th>
                                    <th>Monthly income/transaction</th>
                                    <th>Nominee name</th>
                                    <th>Nominee Maker sanction score</th>
                                    <th>Nominee Checker sanction score</th>
                                    <th>Nominee contact</th>
                                    {{-- <th>Entry by</th>
                                    <th>Entry date</th> --}}
                                    <th>Auth by</th>
                                    <th>Auth date</th>
{{--                                    <th>Action</th>--}}
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
                "buttons": [ "csv", "excel"]
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
