@extends('layouts.admin')
@section('title') Profile settings @endsection
@section('profile') active @endsection

@section('main-content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Profile</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">User Profile</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        @if(Session::get('message'))
            <script>alert('{{ Session::get('message') }}')</script>
        @endif

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card card-info card-outline">
                            <div class="card-body box-profile">
                                <div class="text-center">
                                    <img class="profile-user-img img-fluid img-circle" src="{{ asset('support_files/img/AdminLTELogo.png') }}" alt="User profile picture">
                                </div>
                                <h3 class="profile-username text-center">{{ Auth::user()->name }}</h3>
                                <p class="text-muted text-center font-italic">{{ Auth::user()->user_id }}</p>
                                <ul class="list-group list-group-unbordered mb-3">
                                    <li class="list-group-item">
                                        <b>Email</b> <a class="float-right">{{ Auth::user()->email }}</a>
                                    </li>
                                    <li class="list-group-item">
                                        <b>Branch</b> <a class="float-right">{{ Auth::user()->branch->name }}</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header p-2">
                                <ul class="nav nav-pills">
                                    <li class="nav-item"><a class="nav-link active" href="#about" data-toggle="tab">About</a></li>
                                    <li class="nav-item"><a class="nav-link" href="#password" data-toggle="tab">Password</a></li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="tab-content">
                                    <div class="active tab-pane" id="about">
                                        <form class="form-horizontal" method="post" action="{{ route('admin.update.profile') }}">
                                            @csrf
                                            <div class="form-group">
                                                <label for="inputName" class="form-label">Name</label>
                                                <input type="text" class="form-control" id="inputName" name="name" value="{{ Auth::user()->name }}" placeholder="Name" />
                                                @error('name')
                                                    <label class="error mt-2 text-danger">{{ $message }}</label>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                                                <input type="email" class="form-control" id="inputEmail" name="email" value="{{ Auth::user()->email }}" placeholder="Email" readonly />
                                            </div>
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-info">Update</button>
                                            </div>
                                        </form>
                                    </div>

                                    <div class="tab-pane" id="password">
                                        <form class="form-horizontal" method="POST" action="{{ route('admin.update.password') }}">
                                            @csrf
                                            <div class="form-group">
                                                <label for="cPass" class="form-label">Current password</label>
                                                <input type="password" class="form-control" id="cPass" name="old_password" placeholder="Current password" />
                                                @error('old_password')
                                                <label class="error mt-2 text-danger">{{ $message }}</label>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="nPass" class="form-label">New password</label>
                                                <input type="password" class="form-control" id="nPass" name="new_password" placeholder="New password" />
                                                @error('new_password')
                                                <label class="error mt-2 text-danger">{{ $message }}</label>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="conPass" class="form-label">Confirm password</label>
                                                <input type="password" class="form-control" id="conPass" name="password_confirmation" placeholder="Confirm password">
                                                @error('password_confirmation')
                                                <label class="error mt-2 text-danger">{{ $message }}</label>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-info">Submit</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection


