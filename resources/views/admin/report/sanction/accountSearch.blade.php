@extends('layouts.admin')
@section('title') Sanction report of accounts @endsection
@section('sanction_report')has-treeview menu-open @endsection
@section('sanction_report') active @endsection
@section('account') active @endsection

@section('main-content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Sanction report of accounts</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Sanction report</li>
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
                        <div class="card card-primary">
                            <form method="GET" action="{{ route('admin.sanction.account.report.generate') }}">
                                @csrf
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="type">Select</label>
                                        <select class="form-control" id="type" name="type" required>
                                            <option value="">--Select--</option>
                                            <option value="All">All</option>
                                            <option value="Account create">Account create</option>
                                            <option value="Account authorize">Account authorize</option>
                                            <option value="Account update">Account update</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="startDate">Start date</label>
                                        <input type="date" name="startDate" class="form-control" id="startDate" placeholder="Select start date" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="endDate">End date</label>
                                        <input type="date" name="endDate" class="form-control" id="endDate" placeholder="Select end date" required>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Generate report</button>
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


