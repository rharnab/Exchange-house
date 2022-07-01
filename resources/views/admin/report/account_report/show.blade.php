@extends('layouts.admin')
@section('title') Account Report @endsection
@section('report')has-treeview menu-open @endsection
@section('report_a') active @endsection
@section('account') active @endsection

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
                        <h1 class="m-0">Account Report</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Account Report</li>
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
                            <h3 class="card-title">Account Report</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped table-responsive">
                                <thead>
                                    <tr>
                                        <th>Sl</th>
                                        <th>Customer Name</th>
                                        <th>Account Type Id</th>
                                        <th>Interest Rate</th>
                                        <th>Account no</th>
                                        <th>signature image</th>
                                        <th>probably monthly income</th>
                                        <th>probably monthly transaction</th>

                                        <th>nominee name</th>
                                        <th>nominee nid number</th>
                                        <th>nominee address</th>

                                        <th>relation with nominee</th>
                                        <th>nominee Date Of Birth</th>
                                        <th>nominee Age</th>
                                        <th>Nominee Father Name</th>
                                        <th>Nominee Mother Name</th>
                                        <th>Nominee Contact</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php($i = 1)
                                    @foreach($get_account_report as $single_data)
                                        <tr>
                                            <td>{{$i++}}</td>
                                            <td>{{ $single_data->customer->name }}</td>
                                            <td>{{ $single_data->accountType->name }}</td>
                                            <td>{{ $single_data->interest_rate }}</td>
                                            <td>{{ $single_data->account_no }}</td>
                                            <td>
                                                <img src="{{ asset($single_data->signature_image) }}" alt="" width="120" height="100">
                                            </td>
                                            <td>{{ $single_data->probably_monthly_income }}</td>
                                            <td>{{ $single_data->probably_monthly_transaction }}</td>

                                            <td>{{ $single_data->nominee_name }}</td>
                                            <td>{{ $single_data->nominee_nid_number }}</td>
                                            <td>{{ $single_data->nominee_address }}</td>
                                            <td>{{ $single_data->relation_with_nominee }}</td>
                                            <td>{{ $single_data->nominee_dob }}</td>
                                            <td>{{ $single_data->nominee_age }}</td>
                                            <td>{{ $single_data->nominee_father_name }}</td>
                                            <td>{{ $single_data->nominee_mother_name }}</td>
                                            <td>{{ $single_data->nominee_contact_no }}</td>
                                            <td>
                                                @if($single_data->status == 0)
                                                    Created
                                                @elseif($single_data->status == 1)
                                                    Authorized
                                                @else
                                                    Declined
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Sl</th>
                                        <th>Customer Name</th>
                                        <th>Account Type Id</th>
                                        <th>Interest Rate</th>
                                        <th>Account no</th>
                                        <th>signature image</th>
                                        <th>probably monthly income</th>
                                        <th>probably monthly transaction</th>

                                        <th>nominee name</th>
                                        <th>nominee nid number</th>
                                        <th>nominee address</th>

                                        <th>relation with nominee</th>
                                        <th>nominee Date Of Birth</th>
                                        <th>nominee Age</th>
                                        <th>Nominee Father Name</th>
                                        <th>Nominee Mother Name</th>
                                        <th>Nominee Contact</th>
                                        <th>Status</th>
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
