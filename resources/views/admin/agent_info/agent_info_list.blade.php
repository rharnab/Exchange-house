@extends('layouts.admin')
@section('title') Agent Info List @endsection
@section('settings')has-treeview menu-open @endsection
@section('settings_a') active @endsection
@section('agent') active @endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('support_files/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('support_files/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('support_files/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endpush

@section('main-content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Agent bank information</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item">Agent bank info list</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        @if(Session::get('message'))
            <script>alert('{{ Session::get('message') }}')</script>
        @endif

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-default">
                            <div class="card-header">
                                <h3 class="card-title font-weight-bold">Agent bank</h3>
                                @isset(auth()->user()->role->permission['permission']['agent.create']['create'])
                                    <a href="{{ route('admin.agent_info') }}" class="float-right btn custom_btn">Add +</a>
                                @endisset
                            </div>
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>Sl</th>
                                        <th>Country</th>
                                        <th>Bank</th>
                                        <th>Contact</th>
                                        <th>Email</th>
                                        <th>Corporate Address</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php($i = 1)
                                    @foreach($agent_info_list as  $single_agent_info_list)
                                        <tr>
                                            <td>{{$i++}}</td>
                                            <td>{{$single_agent_info_list->country->name}}</td>
                                            <td>{{$single_agent_info_list->bank->name}}</td>
                                            <td>{{$single_agent_info_list->contact}}</td>
                                            <td>{{$single_agent_info_list->email}}</td>
                                            <td>{{$single_agent_info_list->corporate_address}}</td>
                                            <td>
                                                @if ($single_agent_info_list->status == 1)
                                                    @isset(auth()->user()->role->permission['permission']['agent.edit']['edit'])
                                                        <a href="{{url('/admin/agent-info-edit')}}/{{$single_agent_info_list->id}}" class="ml-1 btn custom_btn btn-sm"><i class="fa fa-pencil-alt"></i> Edit</a>
                                                    @endisset
                                                @elseif($single_agent_info_list->status == 2)
                                                    Declined
                                                @else
                                                    @isset(auth()->user()->role->permission['permission']['agent.auth']['auth'])
                                                        <a href="{{url('/admin/agent-info-authorize')}}/{{$single_agent_info_list->id}}" class="btn btn-sm custom_btn mr-1" title="Authorized"> <i class="fa fa-arrow-up"></i> Authorized</a>
                                                    @endisset

                                                    @isset(auth()->user()->role->permission['permission']['agent.decline']['decline'])
                                                        <a href="{{url('/admin/agent-info-decline')}}/{{$single_agent_info_list->id}}" class="btn btn-sm btn-danger mr-1" title="Declined"> <i class="fa fa-arrow-down"></i> Declined</a>
                                                    @endisset
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>Sl</th>
                                        <th>Country</th>
                                        <th>Bank</th>
                                        <th>Contact</th>
                                        <th>Email</th>
                                        <th>Corporate Address</th>
                                        <th>Action</th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
                "buttons": ["csv", "excel"]
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
@endpush

