<!--

=========================================================
* Argon Dashboard - v1.1.0
=========================================================

* Product Page: https://www.creative-tim.com/product/argon-dashboard
* Copyright 2019 Creative Tim (https://www.creative-tim.com)
* Licensed under MIT (https://github.com/creativetimofficial/argon-dashboard/blob/master/LICENSE.md)

* Coded by Creative Tim

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software. -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>
        Admin Dashboard
    </title>
    <!-- Favicon -->
    <link href="{{asset('img/brand/favicon.png')}}" rel="icon" type="image/png">
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
    <!-- Icons -->
    <link href="{{asset('js/plugins/nucleo/css/nucleo.css')}}" rel="stylesheet" />
    <link href="{{asset('js/plugins/@fortawesome/fontawesome-free/css/all.min.css')}}" rel="stylesheet" />
    <!-- CSS Files -->
    <link href="{{asset('css/argon-dashboard.css?v=1.1.0')}}" rel="stylesheet" />
    <link href="{{asset('css/sweetalert/sweetalert.css')}}" rel="stylesheet" />
    <link href="{{ asset('css/custom.css?v=1') }}" rel="stylesheet">

    @yield('head');

</head>

<body class="">
    <nav class="navbar navbar-vertical fixed-left navbar-expand-md navbar-light bg-white" id="sidenav-main">
        <div class="container-fluid">
            <!-- Toggler -->
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidenav-collapse-main"
                aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!-- Brand -->
            <a class="navbar-brand pt-0" href="#">
                <img src="{{asset('img/brand/white-2.png')}}" class="navbar-brand-img" alt="...">
            </a>
            <!-- User -->
            <ul class="nav align-items-center d-md-none">
                <li class="nav-item dropdown">
                    <a class="nav-link nav-link-icon" href="{{route('/admin')}}" role="button" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <i class="ni ni-bell-55"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right"
                        aria-labelledby="navbar-default_dropdown_1">
                        <a class="dropdown-item" href="#">Action</a>
                        <a class="dropdown-item" href="#">Another action</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Something else here</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        <div class="media align-items-center">
                            <span class="avatar avatar-sm rounded-circle">
                                <img alt="Image placeholder" src="{{asset('img/theme/team-1-800x800.jpg')}}">
                            </span>
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
                        <div class=" dropdown-header noti-title">
                            <h6 class="text-overflow m-0">Welcome!</h6>
                        </div>
                        <a href="{{route('profile')}}" class="dropdown-item">
                            <i class="ni ni-single-02"></i>
                            <span>My profile</span>
                        </a>
                        <a href="{{route('profile')}}" class="dropdown-item">
                            <i class="ni ni-settings-gear-65"></i>
                            <span>Settings</span>
                        </a>
                        <a href="{{route('profile')}}" class="dropdown-item">
                            <i class="ni ni-calendar-grid-58"></i>
                            <span>Activity</span>
                        </a>
                        <a href="{{route('profile')}}" class="dropdown-item">
                            <i class="ni ni-support-16"></i>
                            <span>Support</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                            <i class="ni ni-user-run"></i>
                            <span>Logout</span>
                        </a>
                        @include('includes.logoutform')
                    </div>
                </li>
            </ul>
            <!-- Collapse -->
            <div class="collapse navbar-collapse" id="sidenav-collapse-main">
                <!-- Collapse header -->
                <div class="navbar-collapse-header d-md-none">
                    <div class="row">
                        <div class="col-6 collapse-brand">
                            <a href="{{route('/admin')}}">
                                <img src="{{asset('img/brand/blue.png')}}">
                            </a>
                        </div>
                        <div class="col-6 collapse-close">
                            <button type="button" class="navbar-toggler" data-toggle="collapse"
                                data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false"
                                aria-label="Toggle sidenav">
                                <span></span>
                                <span></span>
                            </button>
                        </div>
                    </div>
                </div>
                <!-- Form -->
                <form class="mt-4 mb-3 d-md-none">
                    <div class="input-group input-group-rounded input-group-merge">
                        <input type="search" class="form-control form-control-rounded form-control-prepended"
                            placeholder="Search" aria-label="Search">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <span class="fa fa-search"></span>
                            </div>
                        </div>
                    </div>
                </form>
                <!-- Navigation -->
                <ul class="navbar-nav">
                    <li class="nav-item" class="active">
                        <a class=" nav-link active " href="{{route('/admin')}}"> <i class="ni ni-tv-2 text-primary"></i>
                            Dashboard
                        </a>
                    </li>
                    <li class="nav-item sub-menu">
                        <a class="nav-link " href="javascript:void(0);">
                            <i class="fas fa-calendar text-green"></i> Events
                        </a>
                        <ul style="list-style: none; display: none;">
                            <li style="font-size: 14px; margin-bottom: 20px; margin-top: 10px;
                            padding-left: 35px;"><i class="fas fa-users text-blue"></i> <a
                                    href="{{route('allevents')}}">All
                                    Events</a></li>
                            <li style="font-size: 14px; margin-bottom: 20px;
                              padding-left: 35px;"><i class="fas fa-plus-circle text-yellow"></i> <a
                                    href="{{route('addevent')}}">Create Event</a></li>

                        </ul>
                    </li>
                    <li class="nav-item sub-menu">
                        <a class="nav-link " href="javascript:void(0);">
                            <i class="fas fa-archive text-orange"></i> Managers
                        </a>
                        <ul style="list-style: none; display: none;">
                            <li style="font-size: 14px; margin-bottom: 20px; margin-top: 10px;
                            padding-left: 35px;"><i class="fas fa-users text-blue"></i> <a
                                    href="{{route('register-managers')}}">All Managers</a></li>
                            <li style="font-size: 14px; margin-bottom: 20px;
                              padding-left: 35px;"><i class="fas fa-user text-yellow"></i> <a
                                    href="{{route('create-manager')}}">Create Manager</a></li>

                        </ul>
                    </li>
                    <li class="nav-item sub-menu">
                        <a class="nav-link " href="javascript:void(0);">
                            <i class="ni ni-single-02 text-yellow"></i> Clients
                        </a>
                        <ul style="list-style: none; display: none;">
                            <li style="font-size: 14px; margin-bottom: 20px; margin-top: 10px;
                                padding-left: 35px;"><i class="fas fa-users text-blue"></i> <a
                                    href="{{route('clients')}}">All Clients</a></li>
                            <li style="font-size: 14px; margin-bottom: 20px;
                                  padding-left: 35px;"><i class="fas fa-user text-yellow"></i> <a
                                    href="{{route('create-client')}}">Add Client</a></li>

                        </ul>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                            <i class="ni ni-key-25 text-info"></i> Logout
                        </a>
                        @include('includes.logoutform')
                    </li>

                </ul>
                <!-- Divider -->
                <hr class="my-3">

            </div>
        </div>
    </nav>
    <div class="main-content">
        <!-- Navbar -->
        <nav class="navbar navbar-top navbar-expand-md navbar-dark" id="navbar-main">
            <div class="container-fluid">
                <!-- Brand -->
                <a class="h4 mb-0 text-white text-uppercase d-none d-lg-inline-block" href="{{url('/')}}">Dashboard</a>
                <!-- Form -->
                <!--                <form class="navbar-search navbar-search-dark form-inline mr-3 d-none d-md-flex ml-lg-auto">
                    <div class="form-group mb-0">
                        <div class="input-group input-group-alternative">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-search"></i></span>
                            </div>
                            <input class="form-control" placeholder="Search" type="text">
                        </div>
                    </div>
                </form>-->
                <!-- User -->
                <ul class="navbar-nav align-items-center d-none d-md-flex">
                    <li class="nav-item dropdown">
                        <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">
                            <div class="media align-items-center">
                                <span class="avatar avatar-sm rounded-circle">
                                    <img alt="Image placeholder"
                                        src="{{(Auth::user()->avatar)?asset('img/userImages/'.Auth::user()->avatar):asset('img/avatar.png')}}">
                                </span>
                                <div class="media-body ml-2 d-none d-lg-block">
                                    <span class="mb-0 text-sm  font-weight-bold">{{Auth::user()->name}}</span>
                                </div>
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
                            <div class=" dropdown-header noti-title">
                                <h6 class="text-overflow m-0">Welcome!</h6>
                            </div>
                            <a href="{{route('profile')}}" class="dropdown-item">
                                <i class="ni ni-single-02"></i>
                                <span>My profile</span>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="{{ route('logout') }}" onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();" class="dropdown-item">
                                <i class="ni ni-user-run"></i>
                                <span>Logout</span>
                            </a>
                            @include('includes.logoutform')
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
        <!-- End Navbar -->
        @yield('content')
        <!-- Footer -->
        <footer class="footer">
            <div class="row align-items-center justify-content-xl-between">
                <div class="col-xl-6">
                    <div class="copyright text-center text-xl-left text-muted">
                        &copy; 2019 <a href="javascript:void(0);" class="font-weight-bold ml-1" target="_blank">Events
                            System</a>
                    </div>
                </div>
                <div class="col-xl-6">
                    <ul class="nav nav-footer justify-content-center justify-content-xl-end">
                        <li class="nav-item">
                            <a href="javascript:void(0);" class="nav-link" target="_blank">Privacy Policy</a>
                        </li>
                        <li class="nav-item">
                            <a href="javascript:void(0);" class="nav-link" target="_blank">About Us</a>
                        </li>
                        <li class="nav-item">
                            <a href="javascript:void(0);" class="nav-link" target="_blank">Blog</a>
                        </li>
                        <li class="nav-item">
                            <a href="javascript:void(0);" class="nav-link" target="_blank">MIT License</a>
                        </li>
                    </ul>
                </div>
            </div>
        </footer>
    </div>
    </div>
    <!--   Core   -->
    <script src="{{asset('js/plugins/jquery/dist/jquery.min.js')}}"></script>
    <script src="{{asset('js/plugins/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>
    <!--   Optional JS   -->
    <script src="{{asset('js/plugins/chart.js/dist/Chart.min.js')}}"></script>
    <script src="{{asset('js/plugins/chart.js/dist/Chart.extension.js')}}"></script>
    <script src="{{asset('js/plugins/sweetalert/sweetalert.min.js')}}"></script>
    <!--   Argon JS   -->
    <script src="{{asset('js/argon-dashboard.min.js?v=1.1.0')}}"></script>
    <script src="https://cdn.trackjs.com/agent/v3/latest/t.js"></script>

    <script>
        window.TrackJS &&
            TrackJS.install({
                token: "ee6fab19c5a04ac1a32a645abde4613a",
                application: "argon-dashboard-free"
            });

        $(document).ready(function() {
            $('.sub-menu').click(function() {
                $(this).find('ul').slideToggle();

            });
        });
    </script>
    @yield('scripts');
    <script src="{{asset('js/common.js')}}"></script>
</body>

</html>