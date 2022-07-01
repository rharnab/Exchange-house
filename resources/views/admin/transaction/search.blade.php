@extends('layouts.admin')
@section('title') Transaction @endsection
@section('t_info')has-treeview menu-open @endsection
@section('t_info_a') active @endsection
@section('t_add') active @endsection

@section('main-content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Transaction</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Search Transaction</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        @if(Session::get('message'))
            <script>alert('{{ Session::get('message') }}')</script>
        @endif

        @if(Session::get('message1'))
            <script>alert('{{ Session::get('message1') }} ')</script>
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
                            <form method="GET" action="{{ route('admin.transaction_crate_search_data') }}">
                                @csrf
                                <div class="row p-4">
                                    <div class="col-7">
                                        <div class="input-group input-group-md">
                                            <input type="text" class="form-control" name="search" value="" placeholder="Search by account or customer phone or customer id number" required />
                                            <span class="input-group-append">
                                                <button type="submit" class="btn custom_btn">Search</button>
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
