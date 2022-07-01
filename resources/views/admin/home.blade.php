@extends('layouts.admin')
@section('title') Dashboard @endsection
@section('dashboard') active @endsection

@section('main-content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Dashboard</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ $get_customer_count }}</h3>
                                <p>Customer</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-user" aria-hidden="true" style="font-size:50px !important;color:#fff;"></i>
                            </div>
                            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>

                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $get_account_opening_count }}</h3>
                                <p>Account</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-university" aria-hidden="true" style="font-size:50px !important;color:#fff;"></i>
                            </div>
                            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>

                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3>{{ $get_transaction_count }}</h3>
                                <p>Transaction</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-money-check-alt" style="font-size:50px !important;color:#fff;"></i>
                            </div>
                            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>

                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3>{{ $get_authorized_transaction_count }}</h3>
                                <p>Authorized Transaction</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-money-check-alt" style="font-size:50px !important;color:#fff;"></i>
                            </div>
                            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <!-- Transaction -->
                        <div class="card ">
                            <div class="card-header border-0 bg-gradient-info">
                                <h3 class="card-title">
                                    <i class="fas fa-check"></i>
                                    Last 10 Authorized Transaction
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

                            <div class="card-body">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Order no</th>
                                        <th>Sender name</th>
                                        <th>Sender country</th>
                                        <th>Sender currency</th>
                                        <th>Sender amount</th>
                                        <th>Exchange rate</th>
                                        <th>Receiver amount</th>
                                        <th>Transaction date</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @php $sl=1; @endphp
                                    @foreach($get_last_10_authorized_transaction as $single_last_10_authorized_transaction)
                                        <tr>
                                            <td>{{ $sl++ }}</td>
                                            <td>{{ $single_last_10_authorized_transaction->order_no }}</td>
                                            <td>{{ $single_last_10_authorized_transaction->sender_name }}</td>
                                            <td>{{ $single_last_10_authorized_transaction->sender_country}}</td>
                                            <td>{{ $single_last_10_authorized_transaction->sCurrency->name }}</td>
                                            <td>{{ number_format($single_last_10_authorized_transaction->originated_amount,2) }}</td>
                                            <td>{{ $single_last_10_authorized_transaction->exchange_rate }}</td>
                                            <td>{{ number_format($single_last_10_authorized_transaction->disbursement_amount, 2) }}</td>
                                            <td>{{ $single_last_10_authorized_transaction->entry_date }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div> <!-- end card -->
                    </div>
                    <!-- end col-md-8 -->
                    <div class="col-md-12">
                        <div class="card ">
                            <div class="card-header border-0 bg-gradient-success">
                                <h3 class="card-title">
                                    <i class="fas fa-wallet"></i>
                                    Recent Currency Rate
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

                            <div class="card-body">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>From Currency</th>
                                        <th>To Currency</th>
                                        <th>Country Name</th>
                                        <th>Bank Name</th>
                                        <th>Rate Amount</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @php $sl=1; @endphp
                                    @foreach($get_currency_rate_last_10 as $single_currency_rate_last_10)
                                        <tr>
                                            <td>{{$sl++}}</td>
                                            <td>{{$single_currency_rate_last_10->fromCurrency->name}}</td>
                                            <td>{{$single_currency_rate_last_10->toCurrency->name}}</td>
                                            <td>{{$single_currency_rate_last_10->country->name}}</td>
                                            <td>{{$single_currency_rate_last_10->bank->name}}</td>
                                            <td>{{$single_currency_rate_last_10->rate_amount}}</td>
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
        </section>
    </div>
@endsection
