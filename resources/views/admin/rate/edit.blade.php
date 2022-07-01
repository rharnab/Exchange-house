@extends('layouts.admin')
@section('title') Currency rate edit @endsection
@section('settings') has-treeview menu-open @endsection
@section('settings_a') active @endsection
@section('currency-rate') active @endsection

@push('styles')
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
                        <h1 class="m-0">Edit currency rate</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                          
                            <li class="breadcrumb-item">Currency rate Edit</li>

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
                        <form method="POST" enctype="multipart/form-data" action="{{ route('admin.update_currency_rate') }}">
                            @csrf

                            <input type="hidden" name="hidden_id" value="{{$get_edit_data->id}}">
                            <div class="card card-info">
                                <div class="card-header">
                                    <h3 class="card-title font-weight-bold">Currency Rate Edit</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Country Name </label>
                                                <select name="country_name" id="country_name" class="form-control select2bs4" onchange="get_bank_from_country(this.value);get_currency_from_country(this.value); "  required>
                                                    <option value="">--select--</option>
                                                    @foreach($CountryInfo as $single_country_info)
                                                        <option value="{{$single_country_info->id}}"
                                                        @if($get_edit_data->country_id==$single_country_info->id)
                                                            {{'selected'}}
                                                            @endif

                                                        >{{$single_country_info->name}}</option>
                                                    @endforeach
                                                </select>
                                                @error('country_name')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Bank Name </label>

                                                <select name="bank_id" id="bank_id" class="form-control select2bs4" required>
                                                    <option value="">--select--</option>

                                                    @foreach($bnk_data as $single_bnk_data)
                                                        <option value="{{$single_bnk_data->id}}"
                                                        @if($get_edit_data->bank_id==$single_bnk_data->id)
                                                            {{'selected'}}
                                                            @endif
                                                        >{{$single_bnk_data->name}}</option>
                                                    @endforeach
                                                </select>
                                                @error('bank_id')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>From currency</label>
                                                <select name="from_currency" class="form-control select2bs4" style="width: 100%;" required >
                                                    <option label="Select">--Select--</option>
                                                    @foreach($CurrencyInfo as $item)
                                                        <option value="{{ $item->id }}" {{$get_edit_data->from_currency_id == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('from_currency')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>


                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>To Currency</label>

                                                <select name="currency_name" id="currency_name" class="form-control select2bs4" required>
                                                    <option value="">--select--</option>

                                                    @foreach($CurrencyInfo as $single_currency_info)
                                                        <option value="{{$single_currency_info->id}}"
                                                        @if($get_edit_data->to_currency_id==$single_currency_info->id)
                                                            {{'selected'}}
                                                            @endif
                                                        >{{$single_currency_info->name}}</option>
                                                    @endforeach
                                                </select>
                                                @error('currency_name')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Rate Amount </label>
                                                <input type="text" name="rate_amount" class="form-control" value="{{$get_edit_data->rate_amount}}" required>
                                                @error('rate_amount')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Update</button>
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
            $('.select2').select2()

            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })

            //Datemask dd/mm/yyyy
            $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
            //Datemask2 mm/dd/yyyy
            $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
            //Money Euro
            $('[data-mask]').inputmask()

            //Date range picker
            $('#reservation').daterangepicker()
            //Date range picker with time picker
            $('#reservationtime').daterangepicker({
                timePicker: true,
                timePickerIncrement: 30,
                locale: {
                    format: 'MM/DD/YYYY hh:mm A'
                }
            })
            //Date range as a button
            $('#daterange-btn').daterangepicker(
                {
                    ranges   : {
                        'Today'       : [moment(), moment()],
                        'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                        'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
                        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                        'This Month'  : [moment().startOf('month'), moment().endOf('month')],
                        'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                    },
                    startDate: moment().subtract(29, 'days'),
                    endDate  : moment()
                },
                function (start, end) {
                    $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
                }
            )

            //Timepicker
            $('#timepicker').datetimepicker({
                format: 'LT'
            })

            //Bootstrap Duallistbox
            $('.duallistbox').bootstrapDualListbox()

            //Colorpicker
            $('.my-colorpicker1').colorpicker()
            //color picker with addon
            $('.my-colorpicker2').colorpicker()

            $('.my-colorpicker2').on('colorpickerChange', function(event) {
                $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
            });

            $("input[data-bootstrap-switch]").each(function(){
                $(this).bootstrapSwitch('state', $(this).prop('checked'));
            });

        })
    </script>


    <script>
        function get_bank_from_country(country_id){
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
                url: "{{ url('/admin/get-bank-from-country-id') }}",
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
