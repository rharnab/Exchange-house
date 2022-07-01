@extends('layouts.admin')
@section('title') Sanction parameter setup @endsection
@section('settings') has-treeview menu-open @endsection
@section('settings_a') active @endsection
@section('sanction') active @endsection

@section('main-content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Sanction parameter</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Setup</li>
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

                    <div class="col-md-7">
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title font-weight-bold">Sanction parameter update</h3>
                            </div>

                            <form method="POST" enctype="multipart/form-data" action="{{ route('admin.sanction.parameter.update') }}">
                                @csrf
                                <input type="hidden" name="id" value="{{ $sanction->id }}">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Name</label>
                                                <input type="text" value="{{ $sanction->name }}" name="name" class="form-control" placeholder="Enter value for name parameter" required />
                                                @error('name')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Father name</label>
                                                <input type="text" value="{{ $sanction->father_name }}" name="father_name" class="form-control" placeholder="Enter value for father name parameter" required />
                                                @error('father_name')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Mother name</label>
                                                <input type="text" name="mother_name" value="{{ $sanction->mother_name }}" class="form-control" placeholder="Enter value for mother name parameter" required />
                                                @error('mother_name')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Place of birth</label>
                                                <input type="text" name="place_of_birth" value="{{ $sanction->place_of_birth }}" class="form-control" placeholder="Enter value for place of birth parameter" required />
                                                @error('place_of_birth')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Date of birth</label>
                                                <input type="text" name="dob" value="{{ $sanction->dob }}" class="form-control" placeholder="Enter value for date of birth parameter" required />
                                                @error('dob')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Country</label>
                                                <input type="text" value="{{ $sanction->country }}" name="country" class="form-control" placeholder="Enter value for country parameter" required />
                                                @error('country')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-footer">
                                    <button type="submit" class="btn custom_btn">Update parameter</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="col-md-5">
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title">Sanction parameter value</h3>
                            </div>

                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>Parameter name</th>
                                        <th>Value</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>Name</td>
                                        <td>{{ $sanction->name }}</td>
                                    </tr>
                                    <tr>
                                        <td>Father name</td>
                                        <td>{{ $sanction->father_name }}</td>
                                    </tr>
                                    <tr>
                                        <td>Mother name</td>
                                        <td>{{ $sanction->mother_name }}</td>
                                    </tr>
                                    <tr>
                                        <td>Place of birth</td>
                                        <td>{{ $sanction->place_of_birth }}</td>
                                    </tr>
                                    <tr>
                                        <td>Country</td>
                                        <td>{{ $sanction->country }}</td>
                                    </tr>
                                    <tr>
                                        <td>Country</td>
                                        <td>{{ $sanction->dob }}</td>
                                    </tr>
                                    <tr>
                                        <th>Total</th>
                                        <td>100.00</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    
                </div>

                <div class="row">

                    <div class="col-md-6">
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title font-weight-bold">Sanction check score update</h3>
                            </div>

                            <form method="POST" action="{{ route('admin.sanction.check.update') }}">
                                @csrf
                                <input type="hidden" name="checkId" value="{{ $sanctionCheck->id }}">
                                <div class="card-body" >
                                    <div class="row">
                                        <label for="sanction_value">Value</label>
                                        <div class="input-group">
                                            <input type="text" value="{{ $sanctionCheck->sanction_value }}" id="sanction_value" name="sanction_value" placeholder="Enter sanction check score" class="form-control" required />
                                            <span class="input-group-append">
                                                <button type="submit" class="btn btn-info btn-flat">Update score</button>
                                            </span>
                                        </div>
                                        @error('sanction_value')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title">Sanction check score</h3>
                            </div>

                            <div class="card-body" style="height: 111px !important">
                                <table id="example1" class="table table-bordered table-striped">
                           
                                    <thead>
                                        <tr>
                                            <th>Value</th>
                                            <td>{{ $sanctionCheck->sanction_value }}</td>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
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
@endpush
