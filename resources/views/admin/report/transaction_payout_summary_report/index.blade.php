@extends('layouts.admin')
@section('title') Transaction Payout Summary Report @endsection
@section('report')has-treeview menu-open @endsection
@section('report_a') active @endsection
@section('transaction_payout_summary_report') active @endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('support_files/plugins/bs-stepper/css/bs-stepper.min.css') }}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('support_files/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('support_files/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">


@endpush

@section('main-content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Transaction Payout Summary Report</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Transaction Payout Summary Report</li>
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
                                <h3 class="card-title">Transaction Payout Summary Report</h3>
                            </div>

                            <form method="post" action="{{route('admin.transaction_payout_summary_report_details')}}">
                                @csrf
                                <div class="row p-4">
                                    <div class="col-md-12">
                                        

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


