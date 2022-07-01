@extends('layouts.admin')
@section('title') Sanction report for files @endsection
@section('sanction_report')has-treeview menu-open @endsection
@section('sanction_report') active @endsection
@section('file') active @endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('support_files/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('support_files/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endpush

@section('main-content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Sanction Screening</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">File</li>
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
                    <div class="col-md-6">
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title font-weight-bold">Screening File Upload</h3>
                            </div>

                            <form method="POST" enctype="multipart/form-data" action="{{ route('admin.screening_data_store') }}">
                                @csrf
                                <div class="card-body">
                                    <div class="input-group input-group-md">
                                        <input type="file" class="form-control" name="file_name" placeholder="Enter customer phone or identification number" required />
                                        <span class="input-group-append">
                                            <button type="submit" class="btn custom_btn">Upload</button>
                                        </span>
                                    </div>
                                    @error('file_name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
{{--                                    <div class="form-group">--}}
{{--                                        <label>File Form</label>--}}
{{--                                        <select name="provider_name" id="provider_name" class="form-control select2bs4">--}}
{{--                                            <option value="">Select Provider </option>--}}
{{--                                            <option value="1">OFACKS</option>--}}
{{--                                            <option value="2">HM-Fast</option>--}}
{{--                                        </select>--}}
{{--                                        @error('provider_name')--}}
{{--                                            <span class="text-danger">{{ $message }}</span>--}}
{{--                                        @enderror--}}
{{--                                    </div>--}}

{{--                                    <div class="form-group">--}}
{{--                                        <label>File</label>--}}
{{--                                        <input type="file" name="file_name" class="form-control"/>--}}
{{--                                        @error('file_name')--}}
{{--                                            <span class="text-danger">{{ $message }}</span>--}}
{{--                                        @enderror--}}
{{--                                    </div>--}}
                                </div>

{{--                                <div class="card-footer">--}}
{{--                                    <button type="submit" class="btn custom_btn">Upload</button>--}}
{{--                                </div>--}}
                            </form>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title font-weight-bold">Screening File Download</h3>
                            </div>

                            <div class="card-body">
                                <a href="{{ route('admin.sanction.exportToExcel') }}" class="btn custom_btn">Download Report</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('support_files/plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
        $(function() {
            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })
        })
    </script>
@endpush
