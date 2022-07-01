@extends('layouts.admin')
@section('title') Role @endsection
@section('role_permission') has-treeview menu-open @endsection
@section('role_permission_a') active @endsection
@section('role') active @endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('support_files/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('support_files/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('support_files/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endpush

@section('main-content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Role</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Roles</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        @if(Session::get('message'))
            <script>alert('{{ Session::get('message') }}')</script>
        @endif

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    @isset(auth()->user()->role->permission['permission']['role.create']['create'])
                        <div class="col-md-5">
                            <div class="card card-info">
                                <div class="card-header">
                                    <h3 class="card-title font-weight-bold">Role create</h3>
                                </div>
                                <form method="POST" action="{{ route('role.store') }}">
                                    @csrf
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label>Name</label>
                                            <input type="text" name="role_name" class="form-control" placeholder="Enter role name" />
                                            @error('role_name')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="card-footer">
                                        <button type="submit" class="btn custom_btn">Create Role</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endisset

                    @isset(auth()->user()->role->permission['permission']['role.index']['list'])
                        <div class="col-md-7">
                            <div class="card card-info">
                                <div class="card-header">
                                    <h3 class="card-title">Role list</h3>
                                </div>

                                <div class="card-body">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th>Sl</th>
                                            <th>Name</th>
                                            <th>Created by</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @php($i = 1)
                                        @foreach($roles as $role)
                                            <tr>
                                                <td>{{ $i++ }}</td>
                                                <td>{{ $role->role_name }}</td>
                                                <td>{{ $role->created_by }}</td>
                                                <td>
                                                    @isset(auth()->user()->role->permission['permission']['role.edit']['edit'])
                                                        <a href="{{ route('role.edit',$role->id)}}" class="btn custom_btn btn-sm"><i class="fas fa-edit"></i> Edit</a>
                                                    @endisset

                                                    @isset(auth()->user()->role->permission['permission']['role.destroy']['delete'])
                                                        <form action="{{ route('role.destroy',$role->id)}}" class="btn-group" method="POST">
                                                            @csrf
                                                            @method('delete')
                                                            <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Delete</button>
                                                        </form>
                                                    @endisset
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <th>Sl</th>
                                            <th>Name</th>
                                            <th>Created by</th>
                                            <th>Action</th>
                                        </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endisset
                </div>
            </div>
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
