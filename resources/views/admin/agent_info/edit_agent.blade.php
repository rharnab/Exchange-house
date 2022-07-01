@extends('layouts.admin')
@section('title') Agent Info Edit @endsection
@section('settings')has-treeview menu-open @endsection
@section('settings_a') active @endsection
@section('agent') active @endsection

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
                        <h1 class="m-0">Edit Agent Info</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.agent_info_list') }}">Agent Info list</a></li>
                            <li class="breadcrumb-item">Edit</li>
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
                        <form method="POST" enctype="multipart/form-data" action="{{ route('admin.update_agent_info') }}">
                            @csrf
                            <input type="hidden" name="hidden_id" value="{{$get_edit_data->id}}">
                            <div class="card card-info">
                                <div class="card-header">
                                    <h3 class="card-title font-weight-bold">Edit Agent Info</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Country</label>
                                                <select name="country_id" id="country_id" onchange="get_bank_from_country(this.value); " class="form-control select2bs4">
                                                    <option value="">--select--</option>
                                                    @foreach($countryInfo as $single_country_info)
                                                        <option value="{{$single_country_info->id}}"
                                                        @if($get_edit_data->country_id==$single_country_info->id)
                                                            {{'selected'}}
                                                        @endif
                                                        >{{$single_country_info->name}}</option>

                                                    @endforeach
                                                </select>
                                                @error('country_id')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>


                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Contact</label>
                                                <input type="text" name="contact" class="form-control" value="{{$get_edit_data->contact}}" placeholder="Enter contact number" >
                                                @error('contact')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Email</label>
                                                <input type="text" name="email" class="form-control"  value="{{$get_edit_data->email}}" placeholder="Enter email" required>
                                                @error('email')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>


                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Bank</label>
                                                <select name="bank_id" id="bank_id" class="form-control select2bs4">
                                                    <option value="">--select--</option>
                                                    @foreach($bnk_data as $single_bnk_data)
                                                        <option value="{{$single_bnk_data->id}}"
                                                        @if($get_edit_data->bankCode == $single_bnk_data->id)
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

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Corporate Address </label>
                                                <textarea name="address" id="address" class="form-control">{{$get_edit_data->corporate_address}}</textarea>
                                                @error('address')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn custom_btn">Update</button>
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
                url: "{{ url('admin/get-bank-from-country-id') }}",
                data: formData,
                success: function(data) {
                    $("#bank_id").html(data);
                },
            });
        }
    </script>

@endpush
