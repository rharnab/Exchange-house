@extends('layouts.admin')
@section('title') Transaction  Report @endsection
@section('report')has-treeview menu-open @endsection
@section('report_a') active @endsection
@section('transaction') active @endsection

@section('main-content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Transaction Report</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Transaction Report</li>
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
                    <div class="col-md-6">
                        <div class="card card-default">
                            <div class="card-header">
                                <h3 class="card-title">Transaction report</h3>
                            </div>

                            <form method="get" action="{{route('admin.transaction_report_show')}}">
                                @csrf
                                <div class="row p-4">
                                    <div class="col-md-12">
                                        <div class="form-group row">
                                            <label for="">Status</label>
                                            <select name="status" id="status" class="form-control select2">
                                                <option value="">--select--</option>
                                                <option value="0">Create</option>
                                                <option value="1">Authorized</option>
                                                <option value="3">Declined</option>
                                            </select>
                                        </div>

                                        <div class="form-group row">
                                            <label for="">Start Date</label>
                                            <input type="date" class="form-control" name="start_date"  />
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group row">
                                            <label for="">End Date</label>
                                            <input type="date" class="form-control" name="end_date"  />
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-success offset-md-10">Generate</button>
                                </div>
                            </form>
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


