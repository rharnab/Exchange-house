@extends('layouts.admin')
@section('title') Currency rate create @endsection
@section('settings') has-treeview menu-open @endsection
@section('settings_a') active @endsection
@section('currency-rate') active @endsection

@push('styles')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('support_files/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('support_files/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endpush

@section('main-content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Currency rate</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>

                            <li class="breadcrumb-item">Currency rate Create</li>
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
                    <div class="col-md-12">
                        <form method="POST" enctype="multipart/form-data" action="{{ route('admin.currency_rate_store') }}">
                            @csrf
                            <div class="card card-info">
                                <div class="card-header">
                                    <h3 class="card-title font-weight-bold">Currency Rate</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Country name</label>
                                                <select name="country_name" id="country_name" class="form-control select2bs4" onchange="get_bank_from_country(this.value);get_currency_from_country(this.value); " required>
                                                    <option value="">--select--</option>
                                                    @foreach($CountryInfo as $single_country_info)
                                                        <option value="{{$single_country_info->id}}">{{$single_country_info->name}}</option>
                                                    @endforeach
                                                </select>
                                                @error('country_name')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Bank name</label>
                                                <select name="bank_id" id="bank_id" class="form-control select2bs4" required>
                                                    <option value="">--select--</option>
                                                </select>
                                                @error('bank_id')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>From currency name</label>
                                                <select name="from_currency" class="form-control select2bs4" required>
                                                    <option value="">--select--</option>
                                                    @foreach($CurrencyInfo as $cItem)
                                                        <option value="{{$cItem->id}}">{{$cItem->name}}</option>
                                                    @endforeach
                                                </select>
                                                @error('from_currency')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>To currency name </label>
                                                <select name="currency_name" id="currency_name" class="form-control" required>
                                                    <option value="">--select--</option>
                                                </select>
                                                @error('currency_name')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Rate Amount </label>
                                                <input type="text" name="rate_amount" class="form-control" required>
                                                @error('rate_amount')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn custom_btn">Add Currency</button>
                                </div>
                            </div>
                        </form>
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

    <!-- Select2 -->
    <script src="{{ asset('support_files/plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
        $(function () {
            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            });
        })
    </script>

    <script>
        function get_bank_from_country(country_id) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                }
            });

            var formData = {
                country_id:country_id
            };

            $.ajax({
                type: 'POST',
                url: "{{ url('/admin/get-bank-from-country-id-with-agent') }}",
                data: formData,

                success: function(data) {
                    console.log(data);
                    $("#bank_id").html(data);
                },
            });
        }
    </script>

    <script>
        function get_currency_from_country(country_id){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                }
            });

            var formData = {
                country_id:country_id
            };

            $.ajax({
                type: 'POST',
                url: "{{ url('/admin/get-currency-from-country-id') }}",
                data: formData,
                success: function(data) {
                    console.log(data);
                    $("#currency_name").html(data);
                },
            });
        }
    </script>
@endpush
