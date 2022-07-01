@extends('layouts.admin')
@section('title') Currency Edit @endsection
@section('settings') has-treeview menu-open @endsection
@section('settings_a') active @endsection
@section('currency') active @endsection

@section('main-content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Currency Edit</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                          
                            <li class="breadcrumb-item active">Edit</li>
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
                                <h3 class="card-title">Currency Edit</h3>
                            </div>

                            <form method="POST" enctype="multipart/form-data" action="{{ route('admin.currency_update') }}">
                                @csrf
                                <input type="hidden" name="hidden_id" value="{{$get_single_data->id}}">

                                <div class="card-body">
                                    <div class="form-group">
                                        <label>Currency name</label>
                                        <input type="text" name="name" class="form-control" placeholder="Enter Currency Types" value="{{$get_single_data->name}}" required />
                                        @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label>Currency Code</label>
                                        <input type="text" name="currency_code" class="form-control" value="{{$get_single_data->code}}" placeholder="Enter Currency Code" required />
                                        @error('currency_code')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="card-footer">
                                    <button type="submit" class="btn custom_btn">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

