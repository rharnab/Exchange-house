@extends('layouts.admin')
@section('title') Account authorize @endsection
@section('a_info')has-treeview menu-open @endsection
@section('a_info_a') active @endsection
@section('a_auth') active @endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('support_files/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('support_files/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('support_files/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endpush

@section('main-content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Account List</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Account list</li>
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
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Customers</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>Sl</th>
                                    <th>Customer name</th>
                                    <th>Customer Maker sanction score</th>
                                    <th>Customer Checker sanction score</th>
                                    <th>Sanction source</th>
                                    <th>Sanction remarks</th>
                                    <th>Account type</th>
                                    <th>Interest rate</th>
                                    <th>Account no</th>
                                    <th>Customer signature</th>
                                    <th>Monthly income/transaction</th>
                                    <th>Nominee name</th>
                                    <th>Nominee Maker sanction score</th>
                                    <th>Nominee Checker sanction score</th>
                                    <th>Nominee contact</th>
                                    <th>Entry by</th>
                                    {{-- <th>Entry date</th>
                                    <th>Action</th> --}}
                                </tr>
                                </thead>
                                <tbody>
                                @php
                                    $i = 1;
                                @endphp
                                @foreach($accounts as $account)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $account->customer->name }}</td>
                                        @php
                                            $customersData = App\Models\CustomerInfo::where('id', $account->customer_id)->get();
                                        @endphp
                                        @foreach($customersData as $cusData)
                                            <td>
                                                {{ $cusData->sanction_score }}
                                            </td>
                                            <td>
                                                {{ $cusData->sanction_score_auth }}
                                            </td>
                                            <td>
                                                {{ $cusData->sanction_table }}
                                            </td>
                                            <td>
                                                {{ $cusData->sanction_remarks }}
                                            </td>
                                        @endforeach
                                        <td>{{ $account->accountType->name }}</td>
                                        <td>{{ $account->accountType->interest_rate }} %</td>
                                        <td>{{ $account->account_no }}</td>
                                        <td>
                                            <img src="{{ asset($account->signature_image) }}" alt="" height="100" width="120">
{{--                                            <a href="{{ route('admin.download_signature', $account->id) }}">--}}
{{--                                                Download--}}
{{--                                            </a>--}}
                                        </td>
                                        <td>{{ $account->probably_monthly_income }}/{{ $account->probably_monthly_transaction }}</td>
                                        <td>{{ $account->nominee_name }}</td>
                                        <td>{{ $account->sanction_score }}</td>
                                        <td>{{ $account->sanction_score_auth }}</td>
                                        <td>{{ $account->nominee_contact_no }}</td>
                                       {{--  <td>{{ $account->entry_by }}</td>
                                        <td>{{ $account->entry_date }}</td> --}}

                                        <td>
                                            @if($account->entry_by != Auth::user()->user_id)
                                                @if ($account->status == 0)
                                                    @isset(auth()->user()->role->permission['permission']['account.decline']['decline'])
                                                        <a href="{{ url('/admin/account-inactive/'.$account->id) }}" class="btn btn-sm btn-danger" title="Declined"> <i class="fa fa-arrow-down"></i> Declined</a>
                                                    @endisset
                                                    <button type="button"  onclick="ScreenBtn({{ $account->id }})"  class="btn btn-sm btn-warning" title="authorize"><i class="fas fa-ban"></i> Authorize</button>
                                                @endif
                                            @endif
                                        </td>

                                        {{---------------------- screening modal -----------------------------}}
                                        <div id="screent-modal" class="modal fade" data-backdrop="static">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true" style="color: #000">&times;</span>
                                                        </button>
                                                    </div>


                                                        <div class="modal-body result">

                                                            {{-- <input type="hidden" name="id" value="{{ $customer->id }}" />
                                                            <div class="form-group">
                                                                <label for="message-text" class="col-form-label">Please provide the reason to authorise sanction data:</label>
                                                                <input type="text" name="remarks"  class="form-control field" id="remarks" >
                                                            </div>

                                                            <div class="col-6">
                                                                <div class="form-group">
                                                                    <label>Sanction screening result (%)</label>
                                                                    <input type="text" name="sanctionsScreening" id="sanctionsScreening" class="form-control text-danger font-weight-bold" readonly />
                                                                    @error('sanctionsScreening')
                                                                    <span class="text-danger">{{ $message }}</span>
                                                                    @enderror
                                                                    <input type="hidden" name="sanction_table" id="sanction_table">
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" onclick="authSubmit()" class="btn btn-success authorize_btn">Authorize</button>
                                                            </div> --}}

                                                        </div>


                                                </div>
                                            </div>
                                        </div>
                                        {{---------------------- screening modal -----------------------------}}
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>Sl</th>
                                    <th>Customer name</th>
                                    <th>Customer Maker sanction score</th>
                                    <th>Customer Checker sanction score</th>
                                    <th>Sanction source</th>
                                    <th>Sanction remarks</th>
                                    <th>Account type</th>
                                    <th>Interest rate</th>
                                    <th>Account no</th>
                                    <th>Customer signature</th>
                                    <th>Monthly income/transaction</th>
                                    <th>Nominee name</th>
                                    <th>Nominee Maker sanction score</th>
                                    <th>Nominee Checker sanction score</th>
                                    <th>Nominee contact</th>
                                    <th>Entry by</th>
                                    {{-- <th>Entry date</th>
                                    <th>Action</th> --}}
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </section>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('support_files/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('support_files/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('support_files/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('support_files/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('support_files/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('support_files/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('support_files/plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('support_files/plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('support_files/plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('support_files/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('support_files/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('support_files/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>

    <script>
        $(function () {
            $("#example1").DataTable({
                "responsive": true, "lengthChange": false, "autoWidth": false,
                "buttons": [ "csv", "excel"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });
    </script>

    {{-- get screening value --}}

<script>
    function ofacScreen() {
        var input_name = $('#name').val().trim();
        var input_dob = $('#dob').val();
        var input_country = $('#country').val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            , }
        });
        if (input_name != '') {
            $.ajax({
                type: 'POST'
                , url: "{{ route('sanctionScreeCheck') }}"
                , data: {
                    input_name: input_name
                    , input_dob: input_dob
                    , input_country: input_country
                , }
                , success: function(data) {
                    if (data.parcent > 0) {
                        var parcent_reuslt = data.parcent;
                        var sanction_table = data.table_name;
                        $("#sanctionsScreening").val(parcent_reuslt);
                        $('#sanction_table').val(sanction_table);
                    } else {
                        $("#sanctionsScreening").val(0);
                        $('#sanction_table').val('');
                    }

                    console.log(data);

                }
            });

        } else {
            $("#sanctionsScreening").val('');
            $('#sanction_table').val('');
        }
    }

    function ScreenBtn(id)
    {
        $('#screent-modal').modal('show');
        if(id !=''){
            $.ajax({
                type: 'POST'
                , url: "{{ route('authAccountScreen') }}"
                , data: {id: id, "_token": "{{ @csrf_token() }}"}
                , success: function(data) {
                    $('.result').html(data);
                    ofacScreen();
                }
            });
        }
    }

</script>

{{-- end screein function  --}}

<script>
    function authSubmit()
    {
        var sanctionsScreening = $('#sanctionsScreening').val();
        var remarks = $('#remarks').val();
        if(parseInt(sanctionsScreening) > 0 &&  remarks == '' ){
            alert('Please give remarks');
        }else{
            $('.authorize_btn').removeAttr('type').attr('type', 'submit');
        }
    }

</script>
@endpush
