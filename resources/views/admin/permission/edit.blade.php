@extends('layouts.admin')
@section('title') Permission edit @endsection
@section('role_permission') has-treeview menu-open @endsection
@section('role_permission_a') active @endsection
@section('permission') active @endsection


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
                            <li class="breadcrumb-item active">Edit</li>
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
                        <form action="{{ route('permission.update',$permission->id) }}" method="POST" >
                            @csrf
                            @method('put')
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="role">Select Role</label>
                                        <select class="form-control" name="role_id" id="role">
                                            <option value="">Select Role</option>
                                            @foreach ($roles as $role)
                                                <option value="{{ $role->id }}" {{ ($permission->role_id == $role->id) ? 'selected':'' }}>{{ $role->role_name }}</option>
                                            @endforeach
                                        </select>
                                        @error('role_id')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-layout-footer">
                                        <button type="submit" class="btn btn-info">Update</button>
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
                                                    <input type="checkbox" name="permission[role][view]" @isset($permission['permission']['role']['view']) checked @endisset value="1">
                                                </td>
                                                <td>
                                                    <input type="checkbox" name="permission[role.index][list]" @isset($permission['permission']['role.index']['list']) checked @endisset value="1">
                                                </td>
                                                <td>
                                                    <input type="checkbox" name="permission[role.create][create]" @isset($permission['permission']['role.create']['create']) checked @endisset value="1" class="control-input">
                                                </td>
                                                <td>
                                                    <input type="checkbox" name="permission[role.edit][edit]" @isset($permission['permission']['role.edit']['edit']) checked @endisset value="1">
                                                </td>
                                                <td>
                                                    <input type="checkbox" name="permission[role.destroy][delete]" @isset($permission['permission']['role.destroy']['delete']) checked @endisset value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Permissions</td>
                                                <td>
                                                    <input type="checkbox" name="permission[permission][view]" @isset($permission['permission']['permission']['view']) checked @endisset value="1">
                                                </td>
                                                <td>
                                                    <input type="checkbox" name="permission[permission.index][list]" @isset($permission['permission']['permission.index']['list']) checked @endisset value="1">
                                                </td>
                                                <td>
                                                    <input type="checkbox" name="permission[permission.create][create]" @isset($permission['permission']['permission.create']['create']) checked @endisset value="1" class="control-input">
                                                </td>

                                                <td>
                                                    <input type="checkbox" name="permission[permission.edit][edit]" @isset($permission['permission']['permission.edit']['edit']) checked @endisset value="1">
                                                </td>
                                                <td>
                                                    <input type="checkbox" name="permission[permission.destroy][delete]" @isset($permission['permission']['permission.destroy']['delete']) checked @endisset value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>User</td>
                                                <td>
                                                    <input type="checkbox" name="permission[user][view]" @isset($permission['permission']['user']['view']) checked @endisset value="1">
                                                </td>
                                                <td>
                                                    <input type="checkbox" name="permission[user.index][list]" @isset($permission['permission']['user.index']['list']) checked @endisset value="1">
                                                </td>
                                                <td>
                                                    <input type="checkbox" name="permission[user.create][create]" @isset($permission['permission']['user.create']['create']) checked @endisset value="1" class="control-input">
                                                </td>
                                                <td>
                                                    <input type="checkbox" name="permission[user.edit][edit]" @isset($permission['permission']['user.edit']['edit']) checked @endisset value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Agent</td>
                                                <td>
                                                    <input type="checkbox" name="permission[agent][view]" @isset($permission['permission']['agent']['view']) checked @endisset value="1">
                                                </td>
                                                <td>
                                                    <input type="checkbox" name="permission[agent.index][list]" @isset($permission['permission']['agent.index']['list']) checked @endisset value="1">
                                                </td>
                                                <td>
                                                    <input type="checkbox" name="permission[agent.create][create]" @isset($permission['permission']['agent.create']['create']) checked @endisset value="1" class="control-input">
                                                </td>
                                                <td>
                                                    <input type="checkbox" name="permission[agent.edit][edit]" @isset($permission['permission']['agent.edit']['edit']) checked @endisset value="1">
                                                </td>
                                                <td></td>
                                                <td>
                                                    <input type="checkbox" name="permission[agent.auth][auth]" @isset($permission['permission']['agent.auth']['auth']) checked @endisset value="1">
                                                </td>
                                                <td>
                                                    <input type="checkbox" name="permission[agent.decline][decline]" @isset($permission['permission']['agent.decline']['decline']) checked @endisset value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Currency</td>
                                                <td>
                                                    <input type="checkbox" name="permission[currency][view]" @isset($permission['permission']['currency']['view']) checked @endisset value="1">
                                                </td>
                                                <td>
                                                    <input type="checkbox" name="permission[currency.index][list]" @isset($permission['permission']['currency.index']['list']) checked @endisset value="1">
                                                </td>
                                                <td>
                                                    <input type="checkbox" name="permission[currency.create][create]" @isset($permission['permission']['currency.create']['create']) checked @endisset value="1" class="control-input">
                                                </td>
                                                <td>
                                                    <input type="checkbox" name="permission[currency.edit][edit]" @isset($permission['permission']['currency.edit']['edit']) checked @endisset value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Currency Rate</td>
                                                <td>
                                                    <input type="checkbox" name="permission[rate][view]" @isset($permission['permission']['rate']['view']) checked @endisset value="1">
                                                </td>
                                                <td>
                                                    <input type="checkbox" name="permission[rate.index][list]" @isset($permission['permission']['rate.index']['list']) checked @endisset value="1">
                                                </td>
                                                <td>
                                                    <input type="checkbox" name="permission[rate.create][create]" @isset($permission['permission']['rate.create']['create']) checked @endisset value="1" class="control-input">
                                                </td>
                                                <td>
                                                    <input type="checkbox" name="permission[rate.edit][edit]" @isset($permission['permission']['rate.edit']['edit']) checked @endisset value="1">
                                                </td>
                                                <td></td>
                                                <td>
                                                    <input type="checkbox" name="permission[rate.auth][auth]" @isset($permission['permission']['rate.auth']['auth']) checked @endisset value="1">
                                                </td>
                                                <td>
                                                    <input type="checkbox" name="permission[rate.decline][decline]" @isset($permission['permission']['rate.decline']['decline']) checked @endisset value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Transaction Fee</td>
                                                <td>
                                                    <input type="checkbox" name="permission[fee][view]" @isset($permission['permission']['fee']['view']) checked @endisset value="1">
                                                </td>
                                                <td>
                                                    <input type="checkbox" name="permission[fee.index][list]" @isset($permission['permission']['fee.index']['list']) checked @endisset value="1">
                                                </td>
                                                <td>
                                                    <input type="checkbox" name="permission[fee.create][create]" @isset($permission['permission']['fee.create']['create']) checked @endisset value="1" class="control-input">
                                                </td>
                                                <td>
                                                    <input type="checkbox" name="permission[fee.edit][edit]" @isset($permission['permission']['fee.edit']['edit']) checked @endisset value="1">
                                                </td>
                                                <td></td>
                                                <td>
                                                    <input type="checkbox" name="permission[fee.auth][auth]" @isset($permission['permission']['fee.auth']['auth']) checked @endisset value="1">
                                                </td>
                                                <td>
                                                    <input type="checkbox" name="permission[fee.decline][decline]" @isset($permission['permission']['fee.decline']['decline']) checked @endisset value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Customer</td>
                                                <td>
                                                    <input type="checkbox" name="permission[customer][view]" @isset($permission['permission']['customer']['view']) checked @endisset value="1">
                                                </td>
                                                <td>
                                                    <input type="checkbox" name="permission[customer.index][list]" @isset($permission['permission']['customer.index']['list']) checked @endisset value="1">
                                                </td>
                                                <td>
                                                    <input type="checkbox" name="permission[customer.create][create]" @isset($permission['permission']['customer.create']['create']) checked @endisset value="1" class="control-input">
                                                </td>
                                                <td>
                                                    <input type="checkbox" name="permission[customer.edit][edit]" @isset($permission['permission']['customer.edit']['edit']) checked @endisset value="1">
                                                </td>
                                                <td></td>
                                                <td>
                                                    <input type="checkbox" name="permission[customer.auth][auth]" @isset($permission['permission']['customer.auth']['auth']) checked @endisset value="1">
                                                </td>
                                                <td>
                                                    <input type="checkbox" name="permission[customer.decline][decline]" @isset($permission['permission']['customer.decline']['decline']) checked @endisset value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Account</td>
                                                <td>
                                                    <input type="checkbox" name="permission[account][view]" @isset($permission['permission']['account']['view']) checked @endisset value="1">
                                                </td>
                                                <td>
                                                    <input type="checkbox" name="permission[account.index][list]" @isset($permission['permission']['account.index']['list']) checked @endisset value="1">
                                                </td>
                                                <td>
                                                    <input type="checkbox" name="permission[account.create][create]" @isset($permission['permission']['account.create']['create']) checked @endisset value="1" class="control-input">
                                                </td>
                                                <td>
                                                    <input type="checkbox" name="permission[account.edit][edit]" @isset($permission['permission']['account.edit']['edit']) checked @endisset value="1">
                                                </td>
                                                <td></td>
                                                <td>
                                                    <input type="checkbox" name="permission[account.auth][auth]" @isset($permission['permission']['account.auth']['auth']) checked @endisset value="1">
                                                </td>
                                                <td>
                                                    <input type="checkbox" name="permission[account.decline][decline]" @isset($permission['permission']['account.decline']['decline']) checked @endisset value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Remittance</td>
                                                <td>
                                                    <input type="checkbox" name="permission[remittance][view]" @isset($permission['permission']['remittance']['view']) checked @endisset value="1">
                                                </td>
                                                <td>
                                                    <input type="checkbox" name="permission[remittance.index][list]" @isset($permission['permission']['remittance.index']['list']) checked @endisset value="1">
                                                </td>
                                                <td>
                                                    <input type="checkbox" name="permission[remittance.create][create]" @isset($permission['permission']['remittance.create']['create']) checked @endisset value="1" class="control-input">
                                                </td>
                                                <td>
                                                    <input type="checkbox" name="permission[remittance.edit][edit]" @isset($permission['permission']['remittance.edit']['edit']) checked @endisset value="1">
                                                </td>
                                                <td></td>
                                                <td>
                                                    <input type="checkbox" name="permission[remittance.auth][auth]" @isset($permission['permission']['remittance.auth']['auth']) checked @endisset value="1">
                                                </td>
                                                <td>
                                                    <input type="checkbox" name="permission[remittance.decline][decline]" @isset($permission['permission']['remittance.decline']['decline']) checked @endisset value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Sanction screening</td>
                                                <td>
                                                    <input type="checkbox" name="permission[sanction][view]" @isset($permission['permission']['sanction']['view']) checked @endisset value="1">
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
