@extends('layouts.admin')
@section('title') Search customer @endsection
@section('a_info')has-treeview menu-open @endsection
@section('a_info_a') active @endsection
@section('a_add') active @endsection

@section('main-content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Customer search</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Customer search</li>
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
                                <h3 class="card-title">Search customer</h3>
                            </div>

                            <form method="get" action="{{ route('admin.customer_search_for_account') }}">
                                @csrf
                                <div class="row p-4">
                                    <div class="col-7">
                                        <div class="input-group input-group-md">
                                            <input type="text" class="form-control" name="search" placeholder="Enter customer phone or identification number" required />
                                            <span class="input-group-append">
                                                <button type="submit" class="btn custom_btn btn-flat">Search</button>
                                            </span>
                                        </div>
                                    </div>
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


