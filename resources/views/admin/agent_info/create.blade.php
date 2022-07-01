@extends('layouts.admin')
@section('title') Agent Create @endsection
@section('settings')has-treeview menu-open @endsection
@section('settings_a') active @endsection
@section('agent') active @endsection

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
                        <h1 class="m-0">Agent Info</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.agent_info_list') }}">Agent Info list</a></li>
                            <li class="breadcrumb-item">Create</li>
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
                        <form method="POST" enctype="multipart/form-data" action="{{ route('admin.store_agent_info') }}">
                            @csrf
                            <div class="card card-info">
                                <div class="card-header">
                                    <h3 class="card-title font-weight-bold">Agent Info</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Country name</label>
                                                <select name="country_id" id="country_id" onchange="get_bank_from_country(this.value); " class="form-control select2bs4" required>
                                                    <option value="">--select--</option>
                                                    @foreach($CountryInfo as $single_country_info)
                                                        <option value="{{$single_country_info->id}}">{{$single_country_info->name}}</option>
                                                    @endforeach
                                                </select>
                                                @error('country_id')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Contact number</label>
                                                <input type="text" name="contact" class="form-control" placeholder="Enter contact number" required>
                                                @error('contact')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Email address</label>
                                                <input type="text" name="email" class="form-control" placeholder="Enter email" required>
                                                @error('email')
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

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Corporate Address</label>
                                                <textarea name="address" id="address" class="form-control" required></textarea>
                                                @error('address')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-footer">
                                    <button type="submit" class="btn custom_btn">Add Agent Info</button>
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
              url: "{{ url('admin/get-bank-from-country-id') }}",
              data: formData,

              success: function(data) {
                  console.log(data);
                  $("#bank_id").html(data);
              },
          });
      }
  </script>
@endpush
