@extends('layouts.admin')
@section('title') Create new account @endsection
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
                    <h1 class="m-0">Account Registration</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Account registration</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    @if(Session::get('message'))
    <script>
        alert('{{ Session::get('message') }}')
    </script>
    @endif
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">Search value {{ $search }}</h3>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <form method="POST" enctype="multipart/form-data" action="{{ route('admin.account_store') }}">
                        @csrf
                        <input type="hidden" name="cus_id" value="{{ $customer->id }}">
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title font-weight-bold">Customer Information</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <table class="table table-bordered">
                                            <tr>
                                                <th width="25%">Customer name</th>
                                                <td width="25%">{{ $customer->name }}</td>
                                                <th width="25%">Customer type</th>
                                                <td width="25%">{{ $customer->customer_type }}</td>

                                            </tr>

                                            <tr>
                                                <th width="25%">Customer Screening  result</th>
                                                <td width="25%">{{ $customer->sanction_score_auth }} %</td>

                                                <th width="25%">New Screening Result</th>
                                                <td> <input type="text" name="customerScreening" id="customerScreening" class="form-control text-danger font-weight-bold" readonly /></td>
                                                <input type="hidden" name="customer_sanction_table" id="customer_sanction_table" value="">
                                                <input type="hidden" name="name" id="name" value="{{ $customer->name }}">
                                                <input type="hidden" name="dob" id="dob" value="{{ ($customer->dob)? date('m/d/Y', strtotime($customer->dob)) : '' }}">
                                                <input type="hidden" name="country" id="country" value="{{ ($customer->country->id)? $customer->country->id: '' }}">
                                                <input type="hidden" name="old_screen" id="old_screen" value="{{ ($customer->sanction_score_auth)? $customer->sanction_score_auth: '' }}">
                                                
                                            </tr>
                                            @if($customer->customer_type == 'Individual')
                                            <tr>
                                                <th width="25%">Date of birth</th>
                                                <td width="25%">{{ $customer->dob }}</td>
                                                <th width="25%">Place of birth</th>
                                                <td width="25%">{{ $customer->place_of_birth }}</td>
                                            </tr>
                                        </table>
                                        <table class="table table-bordered">
                                            <tr>
                                                <th>Customer gender</th>
                                                <td>{{ $customer->gender }}</td>
                                                <th>Marital status</th>
                                                <td>{{ $customer->marital_status }}</td>
                                                <th>Customer occupation</th>
                                                <td>
                                                    @foreach($occupations as $occupation)
                                                    {{-- {{ $customer->occupation->name }}--}}
                                                    {{ $customer->occupation_id == $occupation->id ? $occupation->nme : '' }}
                                                    @endforeach
                                                </td>
                                            </tr>
                                        </table>
                                        <table class="table table-bordered">
                                            <tr>
                                                <th width="25%">Father name</th>
                                                <td width="25%">{{ $customer->father_name }}</td>
                                                <th width="25%">Mother name</th>
                                                <td width="25%">{{ $customer->mother_name }}</td>
                                            </tr>
                                            <tr>
                                                <th width="25%">Present address</th>
                                                <td width="25%">{{ $customer->present_address }}</td>
                                                <th width="25%">Permanent address</th>
                                                <td width="25%">{{ $customer->permanent_address }}</td>
                                            </tr>
                                            @endif
                                            <tr>
                                                <th width="25%">Customer Id type</th>
                                                <td width="25%">{{ $customer->identification->name }}</td>
                                                <th width="25%">Id number</th>
                                                <td width="25%">{{ $customer->id_number }}</td>
                                            </tr>
                                            <tr>
                                                <th width="25%">Phone number</th>
                                                <td width="25%">{{ $customer->contact_number }}</td>
                                                <th width="25%">Email address</th>
                                                <td width="25%">{{ $customer->email }}</td>
                                            </tr>
                                            <tr>
                                                <th width="25%">Customer country</th>
                                                <td width="25%">{{ $customer->country->name }}</td>
                                                <th width="25%">Customer city</th>
                                                <td width="25%">{{ $customer->city->name }}</td>
                                            </tr>
                                        </table>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Customer signature</label>
                                            <input type="file" name="signature_image" class="form-control" placeholder="Customer signature" required />
                                            @error('signature_image')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title font-weight-bold">Nominee Information</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Nominee name</label>
                                            <input type="text" id="nominee_name" name="nominee_name" onkeyup="ofacScreen()" class="form-control" placeholder="Enter nominee name" />
                                            @error('nominee_name')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- <div class="col-2" style="margin-top: 30.5px">
                                        <button type="button" onclick="ofacScreen()" class="btn btn-warning">Check Name</button>
                                    </div> --}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Nominee NID number </label>
                                            <input type="text" name="nominee_nid_number" class="form-control" placeholder="Enter NID number" />
                                            @error('nominee_nid_number')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>Sanction screening result (%)</label>
                                            <input type="text" name="sanctionsScreening" id="sanctionsScreening" class="form-control text-danger font-weight-bold" readonly />
                                            @error('sanctionsScreening')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                            <input type="hidden"  name="sanction_table" id="sanction_table">
                                            <input type="hidden" value="{{ $customer->country->name }}"  name="country" id="country">
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Relation with nominee </label>
                                            <input type="text" name="relation_with_nominee" class="form-control" placeholder="Enter customer relation with nominee" />
                                            @error('relation_with_nominee')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Nominee date of birth</label>
                                            <input type="date" name="nominee_dob" class="form-control" onchange="ofacScreen()" placeholder="Enter nominee date of birth" id="nominee_dob" />
                                            @error('nominee_dob')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Nominee contact no</label>
                                            <input type="text" name="nominee_contact_no" class="form-control" placeholder="Enter nominee contact number" />
                                            @error('nominee_contact_no')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Nominee father name</label>
                                            <input type="text" name="nominee_father_name"  class="form-control" placeholder="Enter nominee father name" id="nominee_father_name" />
                                            @error('nominee_father_name')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label> Nominee mother name</label>
                                            <input type="text" name="nominee_mother_name"  class="form-control" placeholder="Enter nominee mother name" id="nominee_mother_name"/>
                                            @error('nominee_mother_name')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Nominee address </label>
                                            <textarea name="nominee_address" class="form-control" rows="3" placeholder="Enter nominee address"></textarea>
                                            @error('nominee_address')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title font-weight-bold">Transaction Profile</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Account type</label>
                                            <select name="account_type_id" class="form-control select2bs4" style="width: 100%;" required>
                                                <option label="Select">--Select--</option>
                                                @foreach($account_types as $account_type)
                                                <option value="{{ $account_type->id }}">{{ $account_type->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('account_type_id')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Interest rate</label>
                                            <select name="interest_rate" class="form-control select2bs4" style="width: 100%;" required>
                                                <option label="Select">--Select--</option>
                                            </select>
                                            @error('interest_rate')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Probably monthly income</label>
                                            <input name="probably_monthly_income" type="text" class="form-control" placeholder="Enter probably monthly income" required />
                                            @error('probably_monthly_income')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Probably monthly transaction</label>
                                            <input type="text" name="probably_monthly_transaction" class="form-control" placeholder="Enter probably monthly transaction" required />
                                            @error('probably_monthly_transaction')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button id="create_account" type="button" class="btn custom_btn">Create Account</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
    $(document).ready(function() {
        $('select[name="account_type_id"]').on('change', function() {
            var id = $(this).val();
            if (id) {
                $.ajax({
                    url: "{{  url('/admin/get-rate') }}/" + id
                    , type: "GET"
                    , dataType: "json"
                    , success: function(data) {
                        var d = $('select[name="interest_rate"]').empty();
                        $.each(data, function(key, value) {
                            $('select[name="interest_rate"]').append('<option value="' + value.interest_rate + '">' + value.interest_rate + '</option>');
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
        var input_name = $('#nominee_name').val().trim();
        var input_dob = $('#nominee_dob').val();
        var input_country = $('#country').val().trim();

      

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

                    console.log(data);

                }
            });

        }else{
            $("#sanctionsScreening").val('');
            $('#sanction_table').val('');
        }
    }

</script>
{{-- end screein function  --}}

{{-- customer screening value --}}

<script>
    function CustomerScreening()
    {
        var input_name = $('#name').val().trim();
        var input_dob = $('#dob').val();
        var input_country = $('#country').val();
        var old_screen = $('#old_screen').val();

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

                        if(parseFloat(data.parcent))
                        {
                            var parcent_reuslt  = data.parcent;
                            var sanction_table  = data.table_name;
                            $("#customerScreening").val(parcent_reuslt);
                            $('#customer_sanction_table').val(sanction_table);
                        }else{
                            $("#customerScreening").val(0);
                            $('#customer_sanction_table').val('');
                        }
                        
                        
                    }else{
                        $("#customerScreening").val(0);
                        $('#customer_sanction_table').val('');
                    }

                    
                   
                }
            });

        }else{
            $("#customerScreening").val('');
            $('#customer_sanction_table').val('');
        }
    }

</script>
{{-- end customer screein function  --}}
<script>
    $(document).ready(function(){
        CustomerScreening(); //customer screen function
    })
</script>

{{-- screening validation --}}
<script>
    $("#create_account").click(function() {

        var srceening_result = $('#sanctionsScreening').val();
        var customerScreening = $('#customerScreening').val();

        CustomerScreening(); //customer screen function
        if(srceening_result == '' && customerScreening == ''){
    
            alert("Sorry fill all requiered value first !!! ");
        }else if(customerScreening > 0 && srceening_result > 0){
             
            if(confirm(" Customer screening result is "+ customerScreening + " % and Nominee  Screening result is " + srceening_result + " % !!! Are you sure register this ") == true){
                $(this).removeAttr('type').attr('type', 'submit');
            }
        }else if(customerScreening > 0){
            if(confirm("Customer Screening result is " + customerScreening + " % !!! Do you register this ?? ") == true){
                $(this).removeAttr('type').attr('type', 'submit');
            }

        }else if(srceening_result > 0){

            if(confirm("Nominee  Screening result is " + srceening_result + " % !!! Do you register this ??") == true){
                $(this).removeAttr('type').attr('type', 'submit');
            }  
        }else if(srceening_result == 0 && customerScreening ==0){
            $(this).removeAttr('type').attr('type', 'submit');
        }else{
            
        }

    })

</script>

{{-- end screening validation --}}
@endpush
