@extends('layouts.admin')
@section('title') User update @endsection
@section('user')has-treeview menu-open @endsection
@section('user_a') active @endsection
@section('user_create') active @endsection

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
                            <li class="breadcrumb-item active">User</li>
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
                        <form method="POST" action="{{ route('admin.user_update')}}">
                            @csrf
                            <div class="card card-info">
                                <div class="card-header">
                                    <h3 class="card-title font-weight-bold">User Update</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>User ID</label>
                                                <input type="text" name="user_id" class="form-control" value="{{ $user->user_id }}" required />
                                                @error('user_id')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <label>Name</label>
                                                <input type="text" name="name" class="form-control" value="{{ $user->name }}" required />
                                                @error('name')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Sanction permission value</label>
                                                <input type="text" name="screenig_permission" class="form-control" value="{{ $user->screenig_permission }}" required />
                                                @error('screenig_permission')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Email</label>
                                                <input type="email" name="email" class="form-control" value="{{ $user->email }}" required />
                                                @error('email')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Role</label>
                                                <select name="role_id" class="form-control select2bs4" required>
                                                    <option label="Select">--Select--</option>
                                                    @foreach($roles as $item)
                                                        <option value="{{ $item->id }}" {{ $user->role_id == $item->id ? 'selected' : '' }}>{{ $item->role_name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('customer_type')
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
                                                        <option value="{{ $single_get_ex_h_branch->id }}" {{ $user->house_location == $single_get_ex_h_branch->id ? 'selected' : '' }} >{{ $single_get_ex_h_branch->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('ex_h_branch')
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
                                                        <option value="{{ $single_get_ex_h_branch->id }}" {{ $user->house_location == $single_get_ex_h_branch->id ? 'selected' : '' }} >{{ $single_get_ex_h_branch->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('ex_h_branch')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <input type="hidden" name="update_id" class="form-control" value="{{ $user->id }}" />
                                <div class="card-footer">
                                    <button type="submit" class="btn custom_btn">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
