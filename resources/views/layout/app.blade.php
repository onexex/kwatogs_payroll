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

            <li class="nav-item active">
                <a class="nav-link" href="/pages/modules/registration">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Registration</span></a>
            </li>

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
                        <a class="collapse-item" href="/pages/modules/checkRegister"><i
                                class="fa-solid fa-building pr-2"> </i> Check Register</a>
                        <a class="collapse-item" href="/pages/modules/E201"> <i class="fa-solid fa-building pr-2"> </i>
                            E-201</a>
                        <a class="collapse-item" href="/pages/modules/earlyout"><i class="fa-solid fa-building pr-2">
                            </i> Earlyout</a>
                        <a class="collapse-item" href="/pages/modules/registration"> <i
                                class="fa-solid fa-building pr-2"> </i> Enroll Employee</a>
                        <a class="collapse-item" href="/pages/modules/leaveApplication"><i
                                class="fa-solid fa-building pr-2"> </i> Leave Application</a>
                        <a class="collapse-item" href="/pages/modules/memorandum"> <i class="fa-solid fa-building pr-2">
                            </i> Memo Generator</a>
                        <a class="collapse-item" href="/pages/modules/obtTracker"><i class="fa-solid fa-building pr-2">
                            </i> Official Business Trip</a>
                        <a class="collapse-item" href="/pages/modules/overtime"><i class="fa-solid fa-building pr-2">
                            </i> Overtime</a>
                        <a class="collapse-item" href="/pages/modules/payroll"> <i class="fa-solid fa-building pr-2">
                            </i> Payroll System</a>
                        <a class="collapse-item" href="/pages/modules/debitAdvise"><i class="fa-solid fa-building pr-2">
                            </i>Debit Advise</a>
                        <a class="collapse-item" href="/pages/modules/sendOBT"><i class="fa-solid fa-building pr-2">
                            </i> Send to OBT</a>
                    </div>
                </div>
            </li>


            <hr class="sidebar-divider my-0">

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
                        <a class="collapse-item" href="/pages/management/accessrights"><i
                                class="fa-solid fa-building pr-2"> </i> Employee Role</a>
                        <a class="collapse-item" href="/pages/management/agencies"><i
                                class="fa-solid fa-building pr-2"> </i> Agencies</a>
                        <a class="collapse-item" href="/pages/management/archive"><i
                                class="fa-solid fa-building pr-2"> </i> Archive Management</a>
                        <a class="collapse-item" href="/pages/management/classification"><i
                                class="fa-solid fa-building pr-2"> </i> Classification</a>
                        <a class="collapse-item" href="/pages/management/companies"><i
                                class="fa-solid fa-building pr-2"> </i> Companies</a>
                        <a class="collapse-item" href="/pages/management/departments"><i
                                class="fa-solid fa-building pr-2"> </i> Departments</a>
                        <a class="collapse-item" href="/pages/modules/E201"> <i class="fa-solid fa-building pr-2">
                            </i> E-201</a>
                        <a class="collapse-item" href="/pages/management/e201"><i class="fa-solid fa-building pr-2">
                            </i> e-201 Document</a>
                        <a class="collapse-item" href="/pages/management/employeestatus"><i
                                class="fa-solid fa-building pr-2"> </i> Employee Status</a>
                        <a class="collapse-item" href="/pages/management/hmo"><i class="fa-solid fa-building pr-2">
                            </i> HMOs</a>
                        <a class="collapse-item" href="/pages/management/holidaylogger"><i
                                class="fa-solid fa-building pr-2"> </i> Holiday Logger</a>
                        <a class="collapse-item" href="/pages/management/joblevels"><i
                                class="fa-solid fa-building pr-2"> </i> Job Level</a>
                        <a class="collapse-item" href="/pages/management/leavevalidations"><i
                                class="fa-solid fa-building pr-2"> </i> Leave Validation</a>
                        <a class="collapse-item" href="/pages/management/lilovalidations"><i
                                class="fa-solid fa-building pr-2"> </i> Lilo Validation</a>
                        <a class="collapse-item" href="/pages/modules/overtime"><i class="fa-solid fa-building pr-2">
                            </i> Overtime</a>
                        <a class="collapse-item" href="/pages/management/obvalidations"><i
                                class="fa-solid fa-building pr-2"> </i> OB Validation</a>
                        <a class="collapse-item" href="/pages/management/otfiling"><i
                                class="fa-solid fa-building pr-2"> </i> OT Filing Maintenance</a>
                        <a class="collapse-item" href="/pages/management/pagibigcontribution"><i
                                class="fa-solid fa-building pr-2"> </i> Pagibig Contribution</a>
                        <a class="collapse-item" href="/pages/management/parentalsetting"><i
                                class="fa-solid fa-building pr-2"> </i> Parental Settings</a>
                        <a class="collapse-item" href="/pages/management/philhealth"><i
                                class="fa-solid fa-building pr-2"> </i> Philhealth Contribution</a>
                        <a class="collapse-item" href="/pages/management/positions"><i
                                class="fa-solid fa-building pr-2"> </i> Position</a>
                        <a class="collapse-item" href="/pages/modules/registration"><i
                                class="fa-solid fa-building pr-2"> </i> Registration</a>
                        <a class="collapse-item" href="/pages/management/relationship"><i
                                class="fa-solid fa-building pr-2"> </i> Relationship</a>
                        <a class="collapse-item" href="/employee-schedules"><i
                                class="fa-solid fa-building pr-2"> </i> Scheduler</a>
                        <a class="collapse-item" href="/pages/management/time"><i class="fa-solid fa-building pr-2">
                            </i> Schedule Time</a>
                        <a class="collapse-item" href="/pages/management/sil"><i class="fa-solid fa-building pr-2">
                            </i> SIL Loan</a>
                        <a class="collapse-item" href="/pages/management/ssscontribution"><i
                                class="fa-solid fa-building pr-2"> </i> SSS Contribution</a>
                        <a class="collapse-item" href="/pages/management/leavetypes"> <i
                                class="fa-solid fa-building pr-2"> </i> Types of Leaves</a>
                        <a class="collapse-item" href="/user-roles"><i class="fa-solid fa-building pr-2">
                            </i> User Roles</a>
                    

                    </div>
                </div>
            </li>


            <li class="nav-item ">
                <a class="nav-link  nav-link-icon collapsed" href="#" data-toggle="collapse"
                    data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fa-solid fa-gears"></i>
                    <span>Reports</span>
                </a>
                <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded ">
                        <a class="collapse-item" href="/pages/reports/attendance">Attendance Viewer</a>
                    </div>
                </div>
            </li>

            <hr class="sidebar-divider d-none d-md-block">




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
                        <a class="collapse-item" href="{{ url('/users/manage') }}">Laboratory</a>
                    </div>
                </div>
            </li>

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
