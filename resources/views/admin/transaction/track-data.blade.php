@extends('layouts.admin')
@section('title') Transaction track @endsection
@section('t_info')has-treeview menu-open @endsection
@section('t_info_a') active @endsection
@section('t_track') active @endsection

@section('main-content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Transaction track</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Track</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-default">
                            <div class="card-header">
                                <h3 class="card-title">Order or pin number <span class="font-weight-bold">{{ $search }}</span></h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card ">
                            <div class="card-header border-0 bg-gradient-info">
                                <h3 class="card-title">
                                    <i class="far fa-calendar-alt"></i>
                                    Data on Origination
                                </h3>
                                <!-- tools card -->
                                <div class="card-tools">
                                    <!-- button with a dropdown -->
                                    <button type="button" class="btn btn-info btn-sm" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-info btn-sm" data-card-widget="remove">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                                <!-- /. tools -->
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body pt-0">
                                <table class="table">
                                    <tr>
                                        <th>Date</th>
                                        <td>{{ $trackData->trn_date }}</td>
                                    </tr>

                                    <tr>
                                        <th>Sender name</th>
                                        <td>{{ $trackData->sender_name }}</td>
                                    </tr>

                                    <tr>
                                        <th>Sender country</th>
                                        <td>{{ $trackData->sender_country }}</td>
                                    </tr>

                                    <tr>
                                        <th>Sender contact</th>
                                        <td>{{ $trackData->sender_contact }}</td>
                                    </tr>

                                    <tr>
                                        <th>Receiver name</th>
                                        <td>{{ $trackData->receiver_name }}</td>
                                    </tr>

                                    <tr>
                                        <th>Receiver country</th>
                                        <td>{{ $trackData->country->name }}</td>
                                    </tr>

                                    <tr>
                                        <th>Receiver contact</th>
                                        <td>{{ $trackData->receiver_contact }}</td>
                                    </tr>

                                    <tr>
                                        <th>Order No</th>
                                        <td>{{ $trackData->order_no }}</td>
                                    </tr>

                                    <tr>
                                        <th>Receiver Amount</th>
                                        <td>{{ $trackData->disbursement_amount }}</td>
                                    </tr>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div> <!-- end card -->
                    </div>
                    <div class="col-md-6">
                        <div class="card ">
                            <div class="card-header border-0 bg-gradient-success">

                                <h3 class="card-title">
                                    <i class="far fa-calendar-alt"></i>
                                    Transaction Operation Record
                                </h3>
                                <!-- tools card -->
                                <div class="card-tools">
                                    <!-- button with a dropdown -->

                                    <button type="button" class="btn btn-success btn-sm" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>

                                    <button type="button" class="btn btn-success btn-sm" data-card-widget="remove">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                                <!-- /. tools -->
                            </div>
                            <!-- /.card-header -->

                            <div class="card-body pt-0">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Date</th>
                                        <th>Details</th>
                                        <th>User</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php($i = 1)
                                    @foreach($track_trn as $item)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $item->entry_date }}</td>
                                        <td>{{ $item->reason }}</td>
                                        <td>{{ $item->entry_by }}</td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div> <!-- end card -->
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
