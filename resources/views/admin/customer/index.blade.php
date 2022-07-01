@extends('layouts.admin')
@section('title') Customer list @endsection
@section('c_info')has-treeview menu-open @endsection
@section('c_info_a') active @endsection
@section('c_list') active @endsection

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
                        <h1 class="m-0">Customer List</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Customer list</li>
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
                            <table id="example2" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>Sl</th>
                                    <th>Name</th>
                                    <th>Maker sanction score</th>
                                    <th>Checker sanction score</th>
                                    <th>Sanction source</th>
                                    <th>Sanction remarks</th>
                                    <th>ID type</th>
                                    <th>Expire Date</th>
                                    <th>ID number</th>
                                    <th>ID document</th>
                                    <th>Phone number</th>
                                    <th>Email</th>
                                    <th>Country</th>
                                    <th>City</th>
                                    <th>Address</th>
                                    <th>Company name</th>
                                    <th>Company address</th>
                                    <th>Status</th>
                                    <th>Entry By</th>
                                    <th>Entry Date</th>
                                    <th>Auth By</th>
                                    <th>Auth Date</th>
{{--                                    <th>Action</th>--}}
                                </tr>
                                </thead>
                                <tbody>
                                @php($i = 1)
                                @foreach($customers as $customer)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $customer->name }}</td>
                                        <td>{{ $customer->sanction_score }}</td>
                                        <td>{{ $customer->sanction_score_auth }}</td>
                                        <td>{{ $customer->sanction_table }}</td>
                                        <td>{{ $customer->sanction_remarks }}</td>
                                        <td>{{ $customer->identification->name }}</td>
                                        <td>{{ $customer->expire_date }}</td>
                                        <td>{{ $customer->id_number }}</td>
                                        <td>
                                            <a href="{{ route('admin.download_doc', $customer->id) }}">
                                                Download
                                            </a>
                                        </td>
                                        <td>{{ $customer->contact_number }}</td>
                                        <td>{{ $customer->email }}</td>
                                        <td>{{ $customer->country->name }}</td>
                                        <td>{{ $customer->city->name }}</td>
                                        <td>{{ $customer->address }}</td>
                                        <td>{{ $customer->company_name }}</td>
                                        <td>{{ $customer->company_address }}</td>
                                        <td>
                                            @if($customer->status == 1)
                                                <span style="color: blue">Active</span>
                                            @else
                                                <span style="color: red">Inactive</span>
                                            @endif
                                        </td>
                                        <td>{{ $customer->entry_by }}</td>
                                        <td>{{ $customer->entry_date }}</td>
                                        <td>
                                            @if($customer->auth_by == '')
                                                <span>Not Active</span>
                                            @else
                                                {{ $customer->auth_by }}
                                            @endif
                                        </td>
                                        <td>{{ $customer->auth_date }}</td>
{{--                                        <td>--}}
{{--                                            @isset(auth()->user()->role->permission['permission']['customer.decline']['decline'])--}}
{{--                                                <a href="{{ url('/admin/customer-delete/'.$customer->id) }}" class="btn btn-sm btn-danger" id="delete" title="Delete"><i class="fa fa-trash"></i> Delete</a>--}}
{{--                                            @endisset--}}
{{--                                            @if ($customer->status == 1)--}}
{{--                                                @isset(auth()->user()->role->permission['permission']['customer.decline']['decline'])--}}
{{--                                                    <a href="{{ url('/admin/customer-inactive/'.$customer->id) }}" class="btn btn-sm btn-danger" title="Declined"> <i class="fa fa-arrow-down"></i> Declined</a>--}}
{{--                                                @endisset--}}
{{--                                            @else--}}
{{--                                                @isset(auth()->user()->role->permission['permission']['customer.auth']['auth'])--}}
{{--                                                    <a href="{{ url('/admin/customer-active/'.$customer->id) }}" class="btn btn-sm custom_btn" title="Authorized"> <i class="fa fa-arrow-up"></i> Authorized</a>--}}
{{--                                                @endisset--}}
{{--                                            @endif--}}
{{--                                        </td>--}}
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>Sl</th>
                                    <th>Name</th>
                                    <th>Maker sanction score</th>
                                    <th>Checker sanction score</th>
                                    <th>Sanction source</th>
                                    <th>Sanction remarks</th>
                                    <th>ID type</th>
                                    <th>Expire Date</th>
                                    <th>ID number</th>
                                    <th>ID document</th>
                                    <th>Phone number</th>
                                    <th>Email</th>
                                    <th>Country</th>
                                    <th>City</th>
                                    <th>Address</th>
                                    <th>Company name</th>
                                    <th>Company address</th>
                                    <th>Status</th>
                                    <th>Entry By</th>
                                    <th>Entry Date</th>
                                    <th>Auth By</th>
                                    <th>Auth Date</th>
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
