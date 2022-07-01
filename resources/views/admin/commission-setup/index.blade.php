@extends('layouts.admin')
@section('title') Transaction fee @endsection
@section('settings') has-treeview menu-open @endsection
@section('settings_a') active @endsection
@section('trn-fee') active @endsection

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
                        <h1 class="m-0">Transaction Charge List</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item">Transaction Charge List</li>
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
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-default">
                            <div class="card-header">
                                <h3 class="card-title font-weight-bold">Transaction Charge</h3>
                                @isset(auth()->user()->role->permission['permission']['rate.create']['create'])
                                    <a href="{{ route('admin.transaction_charge_create') }}" class="float-right btn btn-sm custom_btn">Add +</a>
                                @endisset
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>Sl</th>
                                        <th>Receiving Country name</th>
                                        <th>Currency name</th>
                                        <th>Start amount</th>
                                        <th>End amount</th>
                                        <th>Charge</th>
                                        <th>Entry by</th>
                                        <th>Entry date</th>
                                        <th>Auth by</th>
                                        <th>Auth date</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @php($i = 1)
                                    @foreach($get_transaction_charge_list as $single_get_transaction_charge_list_info)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>{{ $single_get_transaction_charge_list_info->country->name }}</td>
                                            <td>{{ $single_get_transaction_charge_list_info->currency->name }}</td>
                                            <td>{{ $single_get_transaction_charge_list_info->start_amount }}</td>
                                            <td>{{ $single_get_transaction_charge_list_info->end_amount }}</td>
                                            <td>{{ $single_get_transaction_charge_list_info->charge }}</td>
                                            <td>{{ $single_get_transaction_charge_list_info->entry_by }}</td>
                                            <td>{{ $single_get_transaction_charge_list_info->entry_date }}</td>
                                            <td>{{ $single_get_transaction_charge_list_info->auth_by }}</td>
                                            <td>{{ $single_get_transaction_charge_list_info->auth_date }}</td>
                                            <td>
                                                @if ($single_get_transaction_charge_list_info->status == 1)
                                                    @isset(auth()->user()->role->permission['permission']['rate.edit']['edit'])
                                                    <a href="{{url('admin/transaction-charge-edit')}}/{{$single_get_transaction_charge_list_info->id}}" class="btn custom_btn btn-sm"><i class="fas fa-edit"></i> Edit</a>
                                                    @endisset
                                                @elseif($single_get_transaction_charge_list_info->status == 2)
                                                    Declined
                                                @else
                                                    @isset(auth()->user()->role->permission['permission']['rate.auth']['auth'])
                                                        <a href="{{url('admin/transaction-charge-authorize')}}/{{$single_get_transaction_charge_list_info->id}}" class="btn btn-sm custom_btn" title="Authorized"> <i class="fa fa-arrow-up"></i> Authorized</a>
                                                    @endisset
                                                    @isset(auth()->user()->role->permission['permission']['rate.decline']['decline'])
                                                        <a href="{{url('admin/transaction-charge-decline')}}/{{$single_get_transaction_charge_list_info->id}}" class="btn btn-sm btn-danger" title="Declined"> <i class="fa fa-arrow-down"></i> Declined</a>
                                                    @endisset
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>Sl</th>
                                        <th>Receiving Country name</th>
                                        <th>Currency name</th>
                                        <th>Start amount</th>
                                        <th>End amount</th>
                                        <th>Charge</th>
                                        <th>Entry by</th>
                                        <th>Entry date</th>
                                        <th>Auth by</th>
                                        <th>Auth date</th>
                                        <th>Action</th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
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

