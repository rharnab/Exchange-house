@extends('layouts.admin')
@section('title') Permissions @endsection
@section('role_permission') has-treeview menu-open @endsection
@section('role_permission_a') active @endsection
@section('permission_create') active @endsection

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
                        <h1 class="m-0">Permission</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Permission</li>
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
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Permission list</h3>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('permission.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="role">Select Role</label>
                                        <select class="form-control" name="role_id" id="role">
                                            <option value="">Select Role</option>
                                            @foreach ($roles as $role)
                                                <option value="{{ $role->id }}">{{ $role->role_name }}</option>
                                            @endforeach
                                        </select>
                                        @error('role_id')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-layout-footer">
                                        <button type="submit" class="btn btn-info">Create</button>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th>Permission</th>
                                            <th>View</th>
                                            <th>List</th>
                                            <th>Create</th>
                                            <th>Edit</th>
                                            <th>Delete</th>
                                            <th>Authorize</th>
                                            <th>Decline</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Role</td>
                                                <td>
                                                    <input type="checkbox" name="permission[role][view]" value="1">
                                                </td>
                                                <td>
                                                    <input type="checkbox" name="permission[role.index][list]" value="1">
                                                </td>
                                                <td>
                                                    <input type="checkbox" name="permission[role.create][create]" value="1" class="control-input">
                                                </td>
                                                <td>
                                                    <input type="checkbox" name="permission[role.edit][edit]" value="1">
                                                </td>
                                                <td>
                                                    <input type="checkbox" name="permission[role.destroy][delete]" value="1">
                                                </td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td>Permissions</td>
                                                <td>
                                                    <input type="checkbox" name="permission[permission][view]" value="1">
                                                </td>
                                                <td>
                                                    <input type="checkbox" name="permission[permission.index][list]" value="1">
                                                </td>
                                                <td>
                                                    <input type="checkbox" name="permission[permission.create][create]" value="1" class="control-input">
                                                </td>
                                                <td>
                                                    <input type="checkbox" name="permission[permission.edit][edit]" value="1">
                                                </td>
                                                <td>
                                                    <input type="checkbox" name="permission[permission.destroy][delete]" value="1">
                                                </td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td>User</td>
                                                <td>
                                                    <input type="checkbox" name="permission[user][view]" value="1">
                                                </td>
                                                <td>
                                                    <input type="checkbox" name="permission[user.index][list]" value="1">
                                                </td>
                                                <td>
                                                    <input type="checkbox" name="permission[user.create][create]" value="1" class="control-input">
                                                </td>
                                                <td>
                                                    <input type="checkbox" name="permission[user.edit][edit]" value="1">
                                                </td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td>Agent</td>
                                                <td>
                                                    <input type="checkbox" name="permission[agent][view]" value="1">
                                                </td>
                                                <td>
                                                    <input type="checkbox" name="permission[agent.index][list]" value="1">
                                                </td>
                                                <td>
                                                    <input type="checkbox" name="permission[agent.create][create]" value="1" class="control-input">
                                                </td>
                                                <td>
                                                    <input type="checkbox" name="permission[agent.edit][edit]" value="1">
                                                </td>
                                                <td></td>
                                                <td>
                                                    <input type="checkbox" name="permission[agent.auth][auth]" value="1">
                                                </td>
                                                <td>
                                                    <input type="checkbox" name="permission[agent.decline][decline]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Currency</td>
                                                <td>
                                                    <input type="checkbox" name="permission[currency][view]" value="1">
                                                </td>
                                                <td>
                                                    <input type="checkbox" name="permission[currency.index][list]" value="1">
                                                </td>
                                                <td>
                                                    <input type="checkbox" name="permission[currency.create][create]" value="1" class="control-input">
                                                </td>
                                                <td>
                                                    <input type="checkbox" name="permission[currency.edit][edit]" value="1">
                                                </td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td>Currency Rate</td>
                                                <td>
                                                    <input type="checkbox" name="permission[rate][view]" value="1">
                                                </td>
                                                <td>
                                                    <input type="checkbox" name="permission[rate.index][list]" value="1">
                                                </td>
                                                <td>
                                                    <input type="checkbox" name="permission[rate.create][create]" value="1" class="control-input">
                                                </td>
                                                <td>
                                                    <input type="checkbox" name="permission[rate.edit][edit]" value="1">
                                                </td>
                                                <td></td>
                                                <td>
                                                    <input type="checkbox" name="permission[rate.auth][auth]" value="1">
                                                </td>
                                                <td>
                                                    <input type="checkbox" name="permission[rate.decline][decline]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Transaction Fee</td>
                                                <td>
                                                    <input type="checkbox" name="permission[fee][view]" value="1">
                                                </td>
                                                <td>
                                                    <input type="checkbox" name="permission[fee.index][list]" value="1">
                                                </td>
                                                <td>
                                                    <input type="checkbox" name="permission[fee.create][create]" value="1" class="control-input">
                                                </td>
                                                <td>
                                                    <input type="checkbox" name="permission[fee.edit][edit]" value="1">
                                                </td>
                                                <td></td>
                                                <td>
                                                    <input type="checkbox" name="permission[fee.auth][auth]" value="1">
                                                </td>
                                                <td>
                                                    <input type="checkbox" name="permission[fee.decline][decline]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Customer</td>
                                                <td>
                                                    <input type="checkbox" name="permission[customer][view]" value="1">
                                                </td>
                                                <td>
                                                    <input type="checkbox" name="permission[customer.index][list]" value="1">
                                                </td>
                                                <td>
                                                    <input type="checkbox" name="permission[customer.create][create]" value="1" class="control-input">
                                                </td>
                                                <td>
                                                    <input type="checkbox" name="permission[customer.edit][edit]" value="1">
                                                </td>
                                                <td></td>
                                                <td>
                                                    <input type="checkbox" name="permission[customer.auth][auth]" value="1">
                                                </td>
                                                <td>
                                                    <input type="checkbox" name="permission[customer.decline][decline]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Account</td>
                                                <td>
                                                    <input type="checkbox" name="permission[account][view]" value="1">
                                                </td>
                                                <td>
                                                    <input type="checkbox" name="permission[account.index][list]" value="1">
                                                </td>
                                                <td>
                                                    <input type="checkbox" name="permission[account.create][create]" value="1" class="control-input">
                                                </td>
                                                <td>
                                                    <input type="checkbox" name="permission[account.edit][edit]" value="1">
                                                </td>
                                                <td></td>
                                                <td>
                                                    <input type="checkbox" name="permission[account.auth][auth]" value="1">
                                                </td>
                                                <td>
                                                    <input type="checkbox" name="permission[account.decline][decline]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Remittance</td>
                                                <td>
                                                    <input type="checkbox" name="permission[remittance][view]" value="1">
                                                </td>
                                                <td>
                                                    <input type="checkbox" name="permission[remittance.index][list]" value="1">
                                                </td>
                                                <td>
                                                    <input type="checkbox" name="permission[remittance.create][create]" value="1" class="control-input">
                                                </td>
                                                <td>
                                                    <input type="checkbox" name="permission[remittance.edit][edit]" value="1">
                                                </td>
                                                <td></td>
                                                <td>
                                                    <input type="checkbox" name="permission[remittance.auth][auth]" value="1">
                                                </td>
                                                <td>
                                                    <input type="checkbox" name="permission[remittance.decline][decline]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Sanction screening</td>
                                                <td>
                                                    <input type="checkbox" name="permission[sanction][view]" value="1">
                                                </td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </form>
                    </div>
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
