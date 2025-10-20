<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }} - {{ $title ?? '' }}</title>
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous"> -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous">
    </script> -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous">
    </script>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"
        integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
        integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />


    <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css">
    <script src="{{ asset('js/jquery.dialog.js') }}" defer></script>
    <link href="{{ asset('css/jquery.dialog.css') }}" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>

    {{-- swal.js  --}}
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- <link href="{{ asset('css/fontawesome/css/all.min.css') }}" rel="stylesheet" type="text/css"> -->

</head>

<body id="page-top">

    @if (session('success'))
        <div class="position-fixed top-0 end-0 p-3" id="flash-alert" style="z-index: 1080;">
            <div class="alert alert-success alert-dismissible fade show shadow" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>

        <script>
            setTimeout(() => {
                const alertEl = document.getElementById('flash-alert');
                if (alertEl) {
                    const bsAlert = bootstrap.Alert.getOrCreateInstance(alertEl);
                    bsAlert.close();   
                }
            }, 5000);
        </script>
    @endif
    @if (session('error'))
        <div class="position-fixed top-0 end-0 p-3" id="flash-alert" style="z-index: 1080;">
            <div class="alert alert-danger alert-dismissible fade show shadow" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>

        <script>
            setTimeout(() => {
                const alertEl = document.getElementById('flash-alert');
                if (alertEl) {
                    const bsAlert = bootstrap.Alert.getOrCreateInstance(alertEl);
                    bsAlert.close();   
                }
            }, 5000);
        </script>
    @endif
    <div id="wrapper">
        <ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar" style="background-color: #008080">
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('/') }}">
                <div class="sidebar-brand-icon ">
                    {{-- <img style="height:auto;width:40%;"  src="{{URL::asset('/img/wlogow.png')}}"> --}}
                    -----
                </div>
                {{-- <!-- <div class="sidebar-brand-text mx-3 ">Dashboard</div> --> --}}
            </a>

            <hr class="sidebar-divider my-0">
            @can('home')
                <li class="nav-item active">
                    <a class="nav-link" href="{{ url('/') }}">
                        <i class="fas fa-fw fa-tachometer-alt"></i>
                        <span>Home</span></a>
                </li>
            @endcan

            @can('registration')
                <li class="nav-item active">
                    <a class="nav-link" href="/pages/modules/registration">
                        <i class="fas fa-fw fa-tachometer-alt"></i>
                        <span>Registration</span></a>
                </li>
            @endcan

            @php
                $modulePages = [
                    'checkregister' => ['name' => 'Check Register', 'url' => '/pages/modules/checkRegister'],
                    'e201' => ['name' => 'E-201', 'url' => '/pages/modules/E201'],
                    'earlyout' => ['name' => 'Earlyout', 'url' => '/pages/modules/earlyout'],
                    'enrollemployee' => ['name' => 'Enroll Employee', 'url' => '/pages/modules/registration'],
                    'leaveapplication' => ['name' => 'Leave Application', 'url' => '/pages/modules/leaveApplication'],
                    'memorandum' => ['name' => 'Memo Generator', 'url' => '/pages/modules/memorandum'],
                    'obttracker' => ['name' => 'Official Business Trip', 'url' => '/pages/modules/obtTracker'],
                    'overtime' => ['name' => 'Overtime', 'url' => '/pages/modules/overtime'],
                    'payroll' => ['name' => 'Payroll System', 'url' => '/pages/modules/payroll'],
                    'debitadvise' => ['name' => 'Debit Advise', 'url' => '/pages/modules/debitAdvise'],
                    'sendobt' => ['name' => 'Send to OBT', 'url' => '/pages/modules/sendOBT'],
                ];

                $hasPagesAccess = false;
                foreach ($modulePages as $key => $page) {
                    if (auth()->user() && auth()->user()->can($key)) {
                        $hasPagesAccess = true;
                        break;
                    }
                }
            @endphp
            @if ($hasPagesAccess)
                <div class="sidebar-heading">
                    Modules
                </div>
                <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#patient"
                        aria-expanded="true" aria-controls="collapseTwo">
                        <i class="fas fa-fw fa-cog"></i>
                        <span>Modules</span>
                    </a>

                    <div id="patient" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <h6 class="collapse-header">Modules</h6>

                                @foreach ($modulePages as $key => $page)
                                    @can($key)
                                        <a class="collapse-item" href="{{ $page['url'] }}">
                                            <i class="fa-solid fa-building pr-2"></i> {{ $page['name'] }}
                                        </a>
                                    @endcan
                                @endforeach


                        </div>
                    </div>
                </li>
            @endif


            <hr class="sidebar-divider my-0">
            
            @php
                $managementModules = [
                    'accessrights' => ['name' => 'Employee Role', 'url' => '/pages/management/accessrights'],
                    'agencies' => ['name' => 'Agencies', 'url' => '/pages/management/agencies'],
                    'archive' => ['name' => 'Archive Management', 'url' => '/pages/management/archive'],
                    'classification' => ['name' => 'Classification', 'url' => '/pages/management/classification'],
                    'companies' => ['name' => 'Companies', 'url' => '/pages/management/companies'],
                    'departments' => ['name' => 'Departments', 'url' => '/pages/management/departments'],
                    'e201' => ['name' => 'E-201', 'url' => '/pages/modules/E201'],
                    'e201document' => ['name' => 'E-201 Document', 'url' => '/pages/management/e201'],
                    'employeestatus' => ['name' => 'Employee Status', 'url' => '/pages/management/employeestatus'],
                    'hmo' => ['name' => 'HMOs', 'url' => '/pages/management/hmo'],
                    'holidaylogger' => ['name' => 'Holiday Logger', 'url' => '/pages/management/holidaylogger'],
                    'joblevels' => ['name' => 'Job Level', 'url' => '/pages/management/joblevels'],
                    'leavevalidations' => ['name' => 'Leave Validation', 'url' => '/pages/management/leavevalidations'],
                    'lilovalidations' => ['name' => 'Lilo Validation', 'url' => '/pages/management/lilovalidations'],
                    'overtime' => ['name' => 'Overtime', 'url' => '/pages/modules/overtime'],
                    'obvalidations' => ['name' => 'OB Validation', 'url' => '/pages/management/obvalidations'],
                    'otfiling' => ['name' => 'OT Filing Maintenance', 'url' => '/pages/management/otfiling'],
                    'pagibigcontribution' => ['name' => 'Pagibig Contribution', 'url' => '/pages/management/pagibigcontribution'],
                    'parentalsetting' => ['name' => 'Parental Settings', 'url' => '/pages/management/parentalsetting'],
                    'philhealth' => ['name' => 'Philhealth Contribution', 'url' => '/pages/management/philhealth'],
                    'positions' => ['name' => 'Position', 'url' => '/pages/management/positions'],
                    'registration' => ['name' => 'Registration', 'url' => '/pages/modules/registration'],
                    'relationship' => ['name' => 'Relationship', 'url' => '/pages/management/relationship'],
                    'employeeschedules' => ['name' => 'Scheduler', 'url' => '/employee-schedules'],
                    'scheduletime' => ['name' => 'Schedule Time', 'url' => '/pages/management/time'],
                    'sil' => ['name' => 'SIL Loan', 'url' => '/pages/management/sil'],
                    'ssscontribution' => ['name' => 'SSS Contribution', 'url' => '/pages/management/ssscontribution'],
                    'leavetypes' => ['name' => 'Types of Leaves', 'url' => '/pages/management/leavetypes'],
                    'userroles' => ['name' => 'User Roles', 'url' => '/user-roles'],
                ];
                $hasManagementAccess = false;
                foreach ($managementModules as $key => $module) {
                    if (auth()->user() && auth()->user()->can($key)) {
                        $hasManagementAccess = true;
                        break;
                    }
                }
            @endphp

            @if ($hasManagementAccess) 
                <div class="sidebar-heading">
                    Modules
                </div>

                <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                        aria-expanded="true" aria-controls="collapseTwo">
                        <i class="fas fa-fw fa-cog"></i>
                        <span>Settings</span>
                    </a>

                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <h6 class="collapse-header">Management</h6>
                            @foreach ($managementModules as $key => $module)
                                @can($key)
                                    <a class="collapse-item" href="{{ $module['url'] }}">
                                        <i class="fa-solid fa-building pr-2"></i> {{ $module['name'] }}
                                    </a>
                                @endcan
                            @endforeach
                        </div>
                    </div>
                </li>
            @endif

            @php
                $moduleReports = [
                    'attendance' => ['name' => 'Attendance Viewer', 'url' => '/pages/reports/attendance'],
                ];   
                $hasReportAccess = false;
                foreach ($moduleReports as $key => $module) {
                    if (auth()->user() && auth()->user()->can($key)) {
                        $hasReportAccess = true;
                        break;
                    }
                }
            @endphp

            @if ($hasReportAccess)
                <li class="nav-item ">
                    <a class="nav-link  nav-link-icon collapsed" href="#" data-toggle="collapse"
                        data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
                        <i class="fa-solid fa-gears"></i>
                        <span>Reports</span>
                    </a>
                    <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
                        data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded ">

                            @foreach ($moduleReports as $key => $page)
                                @can($key)
                                    <a class="collapse-item" href="{{ $page['url'] }}">
                                        <i class="fa-solid fa-building pr-2"></i> {{ $page['name'] }}
                                    </a>
                                @endcan
                            @endforeach

                        </div>
                    </div>
                </li>
            @endif

            <hr class="sidebar-divider d-none d-md-block">


            @php
                $moduleBottomReports = [
                    'laboratory' => ['name' => 'Laboratory', 'url' => '/users/manage'],
                ]; 
                $hasAccessBRep = false;
                foreach ($moduleBottomReports as $key => $module) {
                    if (auth()->user() && auth()->user()->can($key)) {
                        $hasAccessBRep = true;
                        break;
                    }
                }
            @endphp
            @if ($hasAccessBRep)
                <li class="nav-item ">
                    <a class="nav-link  nav-link-icon collapsed" href="#" data-toggle="collapse"
                        data-target="#report" aria-expanded="true" aria-controls="collapseUtilities">
                        <i class="fas fa-columns"></i>
                        <span>Reports</span>
                    </a>
                    <div id="report" class="collapse" aria-labelledby="headingUtilities"
                        data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded ">
                            <h6 class="collapse-header">Custom Reports:</h6>
                            @foreach ($moduleReports as $key => $page)
                                @can($key)
                                    <a class="collapse-item" href="{{ $page['url'] }}">
                                        <i class="fa-solid fa-building pr-2"></i> {{ $page['name'] }}
                                    </a>
                                @endcan
                            @endforeach
                        </div>
                    </div>
                </li>
            @endif

            <hr class="sidebar-divider d-none d-md-block">
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0 toggler-icon" id="sidebarToggle"> </button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-2 static-top border">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Search -->
                    {{-- <form
                        class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                                aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-secondary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form> --}}

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small"
                                            placeholder="Search for..." aria-label="Search"
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                                    {{ session()->get('loggedEmployee') }}</span>
                                <img class="img-profile rounded-circle"
                                    src="{{ URL::asset('/img/undraw_profile.svg') }}">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                {{-- <a class="dropdown-item" href="#">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Settings
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Activity Log
                                </a> --}}
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal"
                                    data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>
                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                @yield('content')
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Your Website 2025</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

        <a class="scroll-to-top rounded" href="#page-top">
            <i class="fas fa-angle-up"></i>
        </a>

        <!-- Logout Modal-->
        <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                    <div class="modal-footer">
                        <button class="btn btn-outline-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <a class="btn btn-outline-secondary" href="/logoutSystem">Logout</a>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script src="{{ asset('js/system.js') }}" deffer></script>
    <script src="{{ asset('js/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>


</body>

</html>
