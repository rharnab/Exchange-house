@extends('layouts.admin')
@section('title') User create @endsection
@section('user')has-treeview menu-open @endsection
@section('user_a') active @endsection
@section('user_create') active @endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('support_files/plugins/bs-stepper/css/bs-stepper.min.css') }}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('support_files/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('support_files/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">


@endpush

@section('main-content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">User</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Create</li>
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
                    <div class="col-md-8">
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title font-weight-bold">User create</h3>
                            </div>

                            <form method="POST" action="{{ route('admin.user_store') }}">
                                @csrf
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>User ID <span class="text-red">*</span></label>
                                                <input type="text" name="user_id" class="form-control" placeholder="Enter user id" required />
                                                @error('user_id')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <label>Name <span class="text-red">*</span></label>
                                                <input type="text" name="name" class="form-control" placeholder="Enter user name" required />
                                                @error('name')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Sanction permission value <span class="text-red">*</span></label>
                                                <input type="text" name="screenig_permission" class="form-control" placeholder="Enter sanction permission value" required />
                                                @error('screenig_permission')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Email <span class="text-red">*</span></label>
                                                <input type="email" name="email" class="form-control" placeholder="Enter user email" required />
                                                @error('email')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Password <span class="text-red">*</span></label>
                                                <input type="text" name="password" class="form-control" placeholder="Enter user password" required />
                                                @error('password')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Role <span class="text-red">*</span></label>
                                                <select name="role_id" id="role_id" class="form-control select2bs4" required>
                                                    <option value="">--select--</option>
                                                    @foreach($roles as $role)
                                                        <option value="{{ $role->id }}">{{ $role->role_name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('role_id')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Exchange House Branch <span class="text-red">*</span></label>
                                                <select name="ex_h_branch" id="ex_h_branch" class="form-control select2bs4" required>
                                                    <option value="">--select--</option>
                                                    @foreach($get_ex_h_branch as $single_get_ex_h_branch)
                                                        <option value="{{ $single_get_ex_h_branch->id }}">{{ $single_get_ex_h_branch->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('ex_h_branch')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-footer">
                                    <button type="submit" class="btn custom_btn">Create User</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection


@push('scripts')
    <script src="{{ asset('support_files/plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
        $(function () {
            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })
        })
    </script>

@endpush
