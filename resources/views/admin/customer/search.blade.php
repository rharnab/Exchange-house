@extends('layouts.admin')
@section('title') Update customer @endsection
@section('c_info')has-treeview menu-open @endsection
@section('c_info_a') active @endsection
@section('c_update') active @endsection

@push('styles')
<!-- Select2 -->
<link rel="stylesheet" href="{{ asset('support_files/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('support_files/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">

<style>
    #hidden_div {
        display: none;
    }

</style>
@endpush

@section('main-content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Customer Update</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Update</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    @if(Session::get('message'))
    <script>
        alert('{{ Session::get('
            message ') }}')

    </script>
    @endif

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">Search number <span class="font-weight-bold">{{ $search }}</span></h3>
                        </div>
                    </div>

                    <form method="POST" enctype="multipart/form-data" action="{{ route('admin.customer_update') }}">
                        @csrf
                        <input type="hidden" name="cus_id" value="{{ $customer->id }}">
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title font-weight-bold">Personal Information</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Customer name</label>
                                            <input type="text" value="{{ $customer->name }}" onkeyup="ofacScreen()" name="name" id="name" class="form-control" placeholder="Enter customer name" required />
                                            @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                   {{--  <div class="col-2" style="margin-top: 30.5px">
                                        <button type="button" onclick="ofacScreen()" class="btn btn-warning">Check Name</button>
                                    </div> --}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Customer type</label>
                                            <select name="customer_type" class="form-control select2bs4" style="width: 100%;" required onchange="showDiv('hidden_div', this)">
                                                <option label="Select">--Select--</option>
                                                @foreach($customer_type as $item)
                                                <option value="{{ $item->name }}" {{$customer->customer_type == $item->name ? 'selected' : '' }}>{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('customer_type')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>



                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>Sanction screening result (%)</label>
                                            <input type="text" value="{{ $customer->sanction_score }}" name="sanctionsScreening" id="sanctionsScreening" class="form-control text-danger font-weight-bold" readonly />
                                            @error('sanctionsScreening')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                            <input type="hidden" value="{{ $customer->sanction_table }}" name="sanction_table" id="sanction_table">
                                        </div>
                                    </div>



                                </div>

                                <div id="hidden_div">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Date of birth</label>
                                                <input type="date" value="{{ $customer->dob }}" onchange="ofacScreen()" name="dob" id="dob" class="form-control" />
                                                @error('dob')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Place of birth</label>
                                                <input type="text" value="{{ $customer->place_of_birth }}" name="place_of_birth" class="form-control" placeholder="Enter customer birth place" />
                                                @error('place_of_birth')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Customer gender</label>
                                                <select name="gender" class="form-control select2bs4" style="width: 100%;">
                                                    <option label="Select">--Select--</option>
                                                    @foreach($gender as $item)
                                                    <option value="{{ $item->name }}" {{$customer->gender == $item->name ? 'selected' : '' }}>{{ $item->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('gender')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Marital status</label>
                                                <select name="marital_status" class="form-control select2bs4" style="width: 100%;">
                                                    <option label="Select">--Select--</option>
                                                    @foreach($marital_status as $item)
                                                    <option value="{{ $item->name }}" {{$customer->marital_status == $item->name ? 'selected' : '' }}>{{ $item->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('marital_status')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Customer occupation</label>
                                                <select name="occupation_id" class="form-control select2bs4" style="width: 100%;" required>
                                                    <option label="Select">--Select--</option>
                                                    @foreach($occupations as $occupation)
                                                    <option value="{{ $occupation->id }}" {{$customer->occupation_id == $occupation->id ? 'selected' : '' }}>{{ $occupation->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('occupation_id')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Father's name</label>
                                                <input type="text" value="{{ $customer->father_name }}" name="father_name" class="form-control" placeholder="Enter customer's father name" />
                                                @error('father_name')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Mother's name</label>
                                                <input type="text" value="{{ $customer->mother_name }}" name="mother_name" class="form-control" placeholder="Enter customer's mother name" />
                                                @error('mother_name')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Present address</label>
                                                <textarea name="present_address" class="form-control" rows="3" placeholder="Enter customer present address">{{ $customer->present_address }}</textarea>
                                                @error('present_address')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Permanent address</label>
                                                <textarea name="permanent_address" class="form-control" rows="3" placeholder="Enter customer permanent address">{{ $customer->permanent_address }}</textarea>
                                                @error('permanent_address')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title font-weight-bold">Contact Information</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Customer ID type</label>
                                            <select name="id_type" class="form-control select2bs4" style="width: 100%;" required>
                                                <option label="Select">--Select--</option>
                                                @foreach($type_ids as $item)
                                                <option value="{{ $item->id }}" {{$customer->id_type == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('id_type')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Expire Date</label>
                                            <input type="date" class="form-control" value="{{ $customer->expire_date }}" name="exp_date">
                                            @error('exp_date')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>ID number</label>
                                            <input name="id_number" value="{{ $customer->id_number  }}" type="text" class="form-control" placeholder="Enter id number" required />
                                            @error('id_number')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <!-- /.form-group -->
                                    </div>
                                    <div class="col-md-6">
                                        <label>ID document copy</label> <br>
                                        <img src="{{ asset($customer->doc_name) }}" alt="" class="img-fluid" width="100" height="100">
                                    </div>
                                    <div class="col-md-6">
                                        <label>ID document copy</label>
                                        <input type="file" name="doc_name" class="form-control" />
                                        @error('doc_name')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-5">
                                        <label>Work permit id number</label>
                                        <input type="text" name="work_permit_id_number" class="form-control" value="{{ $customer->work_permit_id_number }}" />
                                        @error('work_permit_id_number')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>


                                    <div class="col-md-2" style="margin-top: 20px;">
                                        <label>Work permit id image </label> <br>
                                        <img src="{{ asset($customer->work_permit_id_image) }}" alt="" class="img-fluid" width="100" height="100">
                                    </div>
                                    <div class="col-md-5" style="margin-top: 20px;">
                                        <label>Work permit id number image</label>
                                        <input type="file" name="work_permit_id_image" class="form-control" />
                                        @error('work_permit_id_image')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>


                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Phone number</label>
                                            <input type="text" value="{{ $customer->contact_number }}" name="contact_number" class="form-control" placeholder="Enter phone number" required />
                                            @error('contact_number')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Email address</label>
                                            <input type="email" value="{{ $customer->email }}" name="email" class="form-control" placeholder="Enter email address" required />
                                            @error('email')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Customer country</label>
                                            <select name="country_id" class="form-control select2bs4" onchange="ofacScreen()" id="country" style="width: 100%;" required>
                                                <option label="Select">--Select--</option>
                                                @foreach($countries as $country)
                                                <option value="{{ $country->id }}" {{ $customer->country_id == $country->id ? 'selected' : '' }}>{{ $country->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('country_id')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Customer city</label>
                                            <select name="city_id" class="form-control select2bs4" style="width: 100%;" required>
                                                <option label="Select">--Select--</option>
                                                @foreach($cities as $city)
                                                <option value="{{ $city->id }}" {{$customer->city_id == $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('city_id')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title font-weight-bold">Company Information</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Customer company name</label>
                                            <input name="company_name" value="{{ $customer->company_name }}" type="text" class="form-control" placeholder="Enter company name" required />
                                            @error('company_name')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label>Customer company address</label>
                                            <input name="company_address" value="{{ $customer->company_address }}" type="text" class="form-control" placeholder="Enter company address" required />
                                            @error('company_address')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Customer company phone number</label>
                                            <input type="text" value="{{ $customer->company_phone }}" name="company_phone" class="form-control" placeholder="Enter company phone number" required />
                                            @error('company_phone')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <label>Remarks</label>
                                        <textarea name="remarks" class="form-control" id="" cols="" rows="">{{ $customer->remarks }}</textarea>
                                    </div>

                                </div>
                            </div>
                            <div class="card-footer">
                                <button id="storeCustomer" type="button" class="btn custom_btn">Update Customer Info</button>
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
<script>
    function showDiv(divId, element) {
        document.getElementById(divId).style.display = element.value == 'Individual' ? 'block' : 'none';
    }
    // BS-Stepper Init
    document.addEventListener('DOMContentLoaded', function() {
        window.stepper = new Stepper(document.querySelector('.bs-stepper'))
    })

</script>
<script src="{{ asset('support_files/plugins/bs-stepper/js/bs-stepper.min.js') }}"></script>
<script>
    // BS-Stepper Init
    document.addEventListener('DOMContentLoaded', function() {
        window.stepper = new Stepper(document.querySelector('.bs-stepper'))
    })

</script>
<!-- Select2 -->
<script src="{{ asset('support_files/plugins/select2/js/select2.full.min.js') }}"></script>
<script>
    $(function() {
        //Initialize Select2 Elements
        $('.select2').select2()

        //Initialize Select2 Elements
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })

        //Datemask dd/mm/yyyy
        $('#datemask').inputmask('dd/mm/yyyy', {
            'placeholder': 'dd/mm/yyyy'
        })
        //Datemask2 mm/dd/yyyy
        $('#datemask2').inputmask('mm/dd/yyyy', {
            'placeholder': 'mm/dd/yyyy'
        })
        //Money Euro
        $('[data-mask]').inputmask()

        //Date range picker
        $('#reservation').daterangepicker()
        //Date range picker with time picker
        $('#reservationtime').daterangepicker({
            timePicker: true
            , timePickerIncrement: 30
            , locale: {
                format: 'MM/DD/YYYY hh:mm A'
            }
        })
        //Date range as a button
        $('#daterange-btn').daterangepicker({
                ranges: {
                    'Today': [moment(), moment()]
                    , 'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')]
                    , 'Last 7 Days': [moment().subtract(6, 'days'), moment()]
                    , 'Last 30 Days': [moment().subtract(29, 'days'), moment()]
                    , 'This Month': [moment().startOf('month'), moment().endOf('month')]
                    , 'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                }
                , startDate: moment().subtract(29, 'days')
                , endDate: moment()
            }
            , function(start, end) {
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

        $("input[data-bootstrap-switch]").each(function() {
            $(this).bootstrapSwitch('state', $(this).prop('checked'));
        });

    })

</script>

<script type="text/javascript">
    $(document).ready(function() {
        $('select[name="country_id"]').on('change', function() {
            var division_id = $(this).val();
            if (division_id) {
                $.ajax({
                    url: "{{  url('/admin/get-city') }}/" + division_id
                    , type: "GET"
                    , dataType: "json"
                    , success: function(data) {
                        var d = $('select[name="city_id"]').empty();
                        $.each(data, function(key, value) {
                            $('select[name="city_id"]').append('<option value="' + value.id + '">' + value.name + '</option>');
                        });
                    }
                , });
            } else {
                alert('danger');
            }
        });
    });

</script>

{{-- get screening value --}}

<script>
     function ofacScreen()
    {
        var input_name = $('#name').val().trim();
        var input_dob = $('#dob').val();
        var input_country = $('#country').val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            }
        });
        if(input_name != ''){
            $.ajax({
                type:'POST',
                url:"{{ route('sanctionScreeCheck') }}",
                data:{
                    input_name:input_name,
                    input_dob:input_dob,
                    input_country:input_country,
                },
                success:function(data){
                    if(data.parcent > 0){
                        var parcent_reuslt  = data.parcent;
                        var sanction_table  = data.table_name;
                        $("#sanctionsScreening").val(parcent_reuslt);
                        $('#sanction_table').val(sanction_table);
                    }else{
                        $("#sanctionsScreening").val(0);
                        $('#sanction_table').val('');
                    }

                    //console.log(data);
                   
                }
            });

        }else{
            $("#sanctionsScreening").val('');
            $('#sanction_table').val('');
        }
    }

</script>

{{-- end screein function  --}}

{{-- screening validation --}}
<script>
    $("#storeCustomer").click(function() {

        var srceening_result = $('#sanctionsScreening').val();

        if (srceening_result > 0) {
            if (confirm("Customer screening result is " + srceening_result + " %  !!  Do you register this ??") == true) {
                $('#storeCustomer').removeAttr('type').attr('type', 'submit');
            }
        } else if (srceening_result == '') {
            alert("Sorry !! Before submit screen this Customer Name ");
        } else {
            $(this).removeAttr('type').attr('type', 'submit');
        }

    })

</script>

{{-- end screening validation --}}
@endpush
