<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('admin.dashboard') }}" class="brand-link">
        <img src="{{ asset('support_files/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">

        <span class="brand-text font-weight-light">VSL</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link @yield('dashboard')">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                {{-- Settings --}}
                <li class="nav-item @yield('settings')">
                    <a href="#" class="nav-link @yield('settings_a')">
                        <i class="nav-icon fas fa-tools"></i>
                        <p>
                            Settings
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @isset(auth()->user()->role->permission['permission']['agent']['view'])
                            <li class="nav-item">
                                <a href="{{ route('admin.agent_info_list') }}" class="nav-link @yield('agent')">
                                    <i class="fas fa-user-cog nav-icon"></i>
                                    <p>Agent Bank Setup</p>
                                </a>
                            </li>
                        @endisset
                        @isset(auth()->user()->role->permission['permission']['currency']['view'])
                            <li class="nav-item">
                                <a href="{{ route('admin.currency') }}" class="nav-link @yield('currency')">
                                    <i class="fas fa-plus nav-icon"></i>
                                    <p>Add New Currency</p>
                                </a>
                            </li>
                        @endisset
                        @isset(auth()->user()->role->permission['permission']['rate']['view'])
                            <li class="nav-item">
                                <a href="{{ route('admin.currency_rate') }}" class="nav-link @yield('currency-rate')">
                                    <i class="nav-icon fas fa-money-bill-alt"></i>
                                    <p>Currency Rate</p>
                                </a>
                            </li>
                        @endisset
                        @isset(auth()->user()->role->permission['permission']['fee']['view'])
                            <li class="nav-item">
                                <a href="{{ route('admin.transaction_charge_list') }}" class="nav-link @yield('trn-fee')">
                                    <i class="fab fa-cuttlefish nav-icon"></i>
                                    <p>Charge Setup</p>
                                </a>
                            </li>
                        @endisset

                        {{-- @isset(auth()->user()->role->permission['permission']['fee']['view'])
                            <li class="nav-item">
                                <a href="{{ route('admin.screening_file_upload') }}" class="nav-link @yield('trn-fee')">
                                    <i class="fab fa-cuttlefish nav-icon"></i>
                                    <p>Upload Screening File</p>
                                </a>
                            </li>
                        @endisset --}}
                        @isset(auth()->user()->role->permission['permission']['sanction']['view'])
                            <li class="nav-item">
                                <a href="{{ route('admin.sanction.parameter') }}" class="nav-link @yield('sanction')">
                                    <i class="fab fa-buffer nav-icon"></i>
                                    <p>Sanction parameter</p>
                                </a>
                            </li>
                        @endisset
                    </ul>
                </li>

                {{-- Customer info --}}
                @isset(auth()->user()->role->permission['permission']['customer']['view'])
                    <li class="nav-item @yield('c_info')">
                        <a href="#" class="nav-link @yield('c_info_a')">
                            <i class="nav-icon fas fa-users"></i>
                            <p>
                                Customer info
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @isset(auth()->user()->role->permission['permission']['customer.index']['list'])
                                <li class="nav-item">
                                    <a href="{{ route('admin.customer_list') }}" class="nav-link @yield('c_list')">
                                        <i class="nav-icon fas fa-list-ol"></i>
                                        <p>Customer List</p>
                                    </a>
                                </li>
                            @endisset
                            @isset(auth()->user()->role->permission['permission']['customer.create']['create'])
                                <li class="nav-item">
                                    <a href="{{ route('admin.customer_add') }}" class="nav-link @yield('c_add')">
                                        <i class="nav-icon fas fa-user-plus"></i>
                                        <p>Customer Add</p>
                                    </a>
                                </li>
                            @endisset
                            @isset(auth()->user()->role->permission['permission']['customer.auth']['auth'])
                                <li class="nav-item">
                                    <a href="{{ route('admin.customer_auth') }}" class="nav-link @yield('c_auth')">
                                        <i class="nav-icon fas fa-user-check"></i>
                                        <p>Customer Authorize</p>
                                    </a>
                                </li>
                            @endisset
                            @isset(auth()->user()->role->permission['permission']['customer.edit']['edit'])
                                <li class="nav-item">
                                    <a href="{{ route('admin.customer_edit') }}" class="nav-link @yield('c_update')">
                                        <i class="nav-icon fas fa-user-edit"></i>
                                        <p>Customer Update</p>
                                    </a>
                                </li>
                            @endisset
                        </ul>
                    </li>
                @endisset

                {{-- Account info --}}
                @isset(auth()->user()->role->permission['permission']['account']['view'])
                    <li class="nav-item @yield('a_info')">
                        <a href="#" class="nav-link @yield('a_info_a')">
                            <i class="nav-icon fas fa-address-book"></i>
                            <p>
                                Account info
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @isset(auth()->user()->role->permission['permission']['account.index']['list'])
                                <li class="nav-item">
                                    <a href="{{ route('admin.account_list') }}" class="nav-link @yield('a_list')">
                                        <i class="nav-icon fas fa-list-ol"></i>
                                        <p>Account List</p>
                                    </a>
                                </li>
                            @endisset

                            @isset(auth()->user()->role->permission['permission']['account.create']['create'])
                                <li class="nav-item">
                                    <a href="{{ route('admin.account_create') }}" class="nav-link @yield('a_add')">
                                        <i class="nav-icon fas fa-user-plus"></i>
                                        <p>Account Create</p>
                                    </a>
                                </li>
                            @endisset
                            @isset(auth()->user()->role->permission['permission']['account.auth']['auth'])
                                <li class="nav-item">
                                    <a href="{{ route('admin.account_authorize') }}" class="nav-link @yield('a_auth')">
                                        <i class="nav-icon fas fa-user-check"></i>
                                        <p>Account Authorize</p>
                                    </a>
                                </li>
                            @endisset
                            @isset(auth()->user()->role->permission['permission']['account.edit']['edit'])
                                <li class="nav-item">
                                    <a href="{{ route('admin.account_edit') }}" class="nav-link @yield('a_update')">
                                        <i class="nav-icon fas fa-user-edit"></i>
                                        <p>Account Update</p>
                                    </a>
                                </li>
                            @endisset
                        </ul>
                    </li>
                @endisset

                {{-- Transaction info --}}
                @isset(auth()->user()->role->permission['permission']['remittance']['view'])
                    <li class="nav-item @yield('t_info')">
                        <a href="#" class="nav-link @yield('t_info_a')">
                            <i class="nav-icon fas fa-exchange-alt"></i>
                            <p>
                                Remittance info
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @isset(auth()->user()->role->permission['permission']['remittance.index']['list'])
                                <li class="nav-item">
                                    <a href="{{ route('admin.transaction.list') }}" class="nav-link @yield('t_add')">
                                        <i class="nav-icon fas fa-list-ol"></i>
                                        <p>Remittance List</p>
                                    </a>
                                </li>
                            @endisset

                            @isset(auth()->user()->role->permission['permission']['remittance.create']['create'])
                                <li class="nav-item">
                                    <a href="{{ route('admin.transaction_crate_search') }}" class="nav-link @yield('t_add')">
                                        <i class="nav-icon fas fa-wallet"></i>
                                        <p>Remittance</p>
                                    </a>
                                </li>
                            @endisset
                            @isset(auth()->user()->role->permission['permission']['remittance.auth']['auth'])
                                <li class="nav-item">
                                    <a href="{{ route('admin.transaction_auth') }}" class="nav-link @yield('t_auth')">
                                        <i class="nav-icon fas fa-check-double"></i>
                                        <p>Remittance Authorize</p>
                                    </a>
                                </li>
                            @endisset

                            <li class="nav-item">
                                <a href="{{ route('admin.trackTransaction') }}" class="nav-link @yield('t_track')">
                                    <i class="nav-icon fas fa-map-pin"></i>
                                    <p>Track</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endisset

                {{-- Report --}}
                <li class="nav-item @yield('report')">
                    <a href="#" class="nav-link @yield('report_a')">
                        <i class="nav-icon fab fa-readme"></i>
                        <p>
                            Report
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin.transaction_report')}}" class="nav-link @yield('transaction')">
                                <i class="nav-icon fas fa-file-invoice-dollar"></i>
                                <p>Transaction Report</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{route('admin.account_report')}}" class="nav-link @yield('account')">
                                <i class="nav-icon fas fa-id-badge"></i>
                                <p>Account Report</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{route('admin.bank_wise_online_summary_report')}}" class="nav-link @yield('bank_wise_online_summary_report')">
                                <i class="nav-icon fas fa-id-badge"></i>
                                <p>Bank Wise Online Summary Report</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{route('admin.beneficiary_wise_report')}}" class="nav-link @yield('beneficiary_wise_report')">
                                <i class="nav-icon fas fa-id-badge"></i>
                                <p>Beneficiary Wise  Report</p>
                            </a>
                        </li>


                        <li class="nav-item">
                            <a href="{{route('admin.transaction_payout_summary_report')}}" class="nav-link @yield('transaction_payout_summary_report')">
                                <i class="nav-icon fas fa-id-badge"></i>
                                <p>Transaction Payout Summary Report</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{route('admin.id_type_expire_date_report')}}" class="nav-link @yield('id_type_report_expired_date')">
                                <i class="nav-icon fas fa-id-badge"></i>
                                <p>ID Type Expire Date Report</p>
                            </a>
                        </li>


                        <li class="nav-item">
                            <a href="{{route('admin.cashier_wise_task_report')}}" class="nav-link @yield('cashier_wise_task_report')">
                                <i class="nav-icon fas fa-id-badge"></i>
                                <p>Cashier Wise Task Report</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{route('admin.new_customer_creation_report')}}" class="nav-link @yield('new_customer_creation_report')">
                                <i class="nav-icon fas fa-id-badge"></i>
                                <p>New Customer Creation Report</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{route('admin.payment_method_wise_report')}}" class="nav-link @yield('payment_method_wise_report')">
                                <i class="nav-icon fas fa-id-badge"></i>
                                <p>Payment Method Wise Report</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{route('admin.rate_history_report')}}" class="nav-link @yield('rate_history_report')">
                                <i class="nav-icon fas fa-id-badge"></i>
                                <p>Rate History Report</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{route('admin.reconcilation-report')}}" class="nav-link @yield('reconcilation_report')">
                                <i class="nav-icon fas fa-id-badge"></i>
                                <p>Reconciliation Report</p>
                            </a>
                        </li>


                        <li class="nav-item">
                            <a href="{{route('admin.remitter-certificate')}}" class="nav-link @yield('remitter_certificate')">
                                <i class="nav-icon fas fa-id-badge"></i>
                                <p>Remitter Certificate</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{route('admin.remitter-transaction-history')}}" class="nav-link @yield('remitter_transaction_history')">
                                <i class="nav-icon fas fa-id-badge"></i>
                                <p>Remitter Transaction History</p>
                            </a>
                        </li>
                    </ul>
                </li>
                {{-- Sanction report --}}
                <li class="nav-item @yield('sanction_report')">
                    <a href="#" class="nav-link @yield('sanction_report')">
                        <i class="fas fa-book-open nav-icon"></i>
                        <p>
                            Sanction report
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin.sanction.customer.report')}}" class="nav-link @yield('customer')">
                                <i class="nav-icon fas fa-file-invoice-dollar"></i>
                                <p>Customer Report</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{route('admin.sanction.account.report')}}" class="nav-link @yield('account')">
                                <i class="nav-icon fas fa-id-badge"></i>
                                <p>Account Report</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{route('admin.sanction.transaction.report')}}" class="nav-link @yield('transaction')">
                                <i class="nav-icon fas fa-id-badge"></i>
                                <p>Remittance Report</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{route('admin.sanction.individual.report')}}" class="nav-link @yield('individual')">
                                <i class="fas fa-user nav-icon"></i>
                                <p>Individual Report</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{route('admin.screening_file_upload')}}" class="nav-link @yield('file')">
                                <i class="fas fa-file-upload nav-icon"></i>
                                <p>File Upload</p>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- Role and permission Section --}}
                @isset(auth()->user()->role->permission['permission']['role']['view'])
                    <li class="nav-item  @yield('role_permission')">
                        <a href="#" class="nav-link @yield('role_permission_a')">
                            <i class="nav-icon fas fa-project-diagram"></i>
                            <p>Role & Permission <i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            @isset(auth()->user()->role->permission['permission']['role']['view'])
                                <li class="nav-item">
                                    @isset(auth()->user()->role->permission['permission']['role.index']['list'])
                                        <a href="{{ route('role.index') }}" class="nav-link @yield('role')">
                                            <i class="nav-icon fas fa-plus-circle"></i>
                                            <p>Create new role</p>
                                        </a>
                                    @endisset
                                </li>
                            @endisset

                            @isset(auth()->user()->role->permission['permission']['permission.index']['list'])
                                <li class="nav-item">
                                    <a href="{{ route('permission.index') }}" class="nav-link @yield('permission')">
                                        <i class="nav-icon fas fa-parking"></i>
                                        <p>Permission List</p>
                                    </a>
                                </li>
                            @endisset

                            @isset(auth()->user()->role->permission['permission']['permission.index']['list'])
                                <li class="nav-item">
                                    <a href="{{ route('permission.create') }}" class="nav-link @yield('permission_create')">
                                        <i class="nav-icon fas fa-plus"></i>
                                        <p>Permission add</p>
                                    </a>
                                </li>
                            @endisset
                        </ul>
                    </li>
                @endisset

                {{-- User Section --}}
                @isset(auth()->user()->role->permission['permission']['user']['view'])
                    <li class="nav-item  @yield('user')">
                        <a href="#" class="nav-link @yield('user_a')">
                            <i class="nav-icon fas fa-user-cog"></i>
                            <p>User management<i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            @isset(auth()->user()->role->permission['permission']['user.index']['list'])
                                <li class="nav-item">
                                    <a href="{{ route('admin.user_list') }}" class="nav-link @yield('user_list')">
                                        <i class="nav-icon fas fa-id-card"></i>
                                        <p>User list</p>
                                    </a>
                                </li>
                            @endisset

                            @isset(auth()->user()->role->permission['permission']['user.create']['create'])
                                <li class="nav-item">
                                    <a href="{{ route('admin.user_create') }}" class="nav-link @yield('user_create')">
                                        <i class="nav-icon fas fa-user-plus"></i>
                                        <p>User add</p>
                                    </a>
                                </li>
                            @endisset
                        </ul>
                    </li>
                @endisset

                <li class="nav-item">
                    <a href="{{ route('admin.profile.index') }}" class="nav-link @yield('profile')">
                        <i class="nav-icon fas fa-address-card"></i>
                        <p>Profile settings</p>
                    </a>
                </li>

                {{-- Logout --}}
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="nav-icon icon ion-power"></i> Sign Out
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
