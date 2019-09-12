<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Bullish - Admin Dashboard</title>

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('assets/vendors/bundle.css') }}" type="text/css">
    @guest
    @else
    <link rel="stylesheet" href="{{ asset('assets/vendors/datepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/vmap/jqvmap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/icons/font-awesome/css/font-awesome.min.css') }}" type="text/css">
    @endguest

    <link rel="stylesheet" href="{{ asset('assets/css/app.min.css') }}" type="text/css">
    @guest
    @else
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}" type="text/css">
    @endguest
</head>
<body class="bg-white h-100-vh p-t-0">

<div class="page-loader">
    <div class="spinner-border"></div>
    <span>Loading ...</span>
</div>
<div class="p-b-50 d-block d-lg-none"></div>
@guest
<div class="container h-100-vh">
    @yield('content')
</div>
@else
    <!-- begin::side menu -->
    <div class="side-menu">
        <div class='side-menu-body'>
            <ul>
                <li @if(Request::segment(1) == '') class="open" @endif>
                    <a href="{{ route('home') }}"><i class="icon ti-home"></i> <span>Dashboards</span> </a>
                </li>
                <li @if(Request::segment(1) == 'groups') class="open" @endif><a href="{{ route('groups') }}"><i class="icon ti-paint-bucket"></i> <span>Groups</span> <span
                            class="badge bg-danger-gradient"></span> </a></li>
                <li @if(Request::segment(1) == 'group_owners' || Request::segment(1) == 'members')) class="open" @endif><a href="#"><i class="icon ti-rocket"></i> <span>Users</span> </a>
                    <ul>
                        <li @if(Request::segment(1) == 'group_owners') class="open" @endif><a href="{{ route('group_owners') }}">Group Owners </a></li>
                        <li @if(Request::segment(1) == 'members') class="open" @endif><a href="{{ route('members') }}">Users </a></li>
                    </ul>
                </li>
                <li><a href="#"><i class="icon ti-layers-alt"></i> <span>Payment</span> </a>
                    <ul>
                        <li><a href="payment.html">Payment Against Group </a></li>
                        <li><a href="profit.html">Payment Profit </a></li>
                    </ul>
                </li>
                <li @if(Request::segment(1) == 'categories') class="open" @endif><a href="{{ route('categories') }}"><i class="icon ti-layout-accordion-list"></i> <span>Categories</span> <span
                            class="badge bg-danger-gradient"></span> </a></li>
            </ul>
        </div>
    </div>
    <!-- end::side menu -->

    <!-- begin::navbar -->
    <nav class="navbar">
        <div class="container-fluid">

            <div class="header-logo">
                <a href="#">
                    <img src="assets/media/image/light-logo.png" alt="...">
                    <span class="logo-text d-none d-lg-block">Bullish</span>
                </a>
            </div>

            <div class="header-body">

                <form class="search">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search ..."
                               aria-label="Recipient's username"
                               aria-describedby="button-addon2">
                        <div class="input-group-append">
                            <button class="btn" type="button" id="button-addon2">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a href="#" class="d-lg-none d-sm-block nav-link search-panel-open">
                            <i class="fa fa-search"></i>
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link nav-link-notify" data-toggle="dropdown">
                            <i class="fa fa-envelope"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-big">
                            <div class="dropdown-menu-title d-flex justify-content-between">
                                <div>
                                    <h6 class="text-uppercase font-size-12 m-b-0">Messages</h6>
                                    <small class="font-size-11 opacity-7">1 unread messages</small>
                                </div>
                            </div>
                            <div class="dropdown-menu-body">
                                <ul class="list-group list-group-flush">
                                    <a href="#" class="list-group-item d-flex link-1 hide-show-toggler">
                                        <div>
                                            <figure class="avatar avatar-sm m-r-15">
                                                <span class="avatar-title bg-success rounded-circle">M</span>
                                            </figure>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="m-b-0 d-flex justify-content-between">
                                                Malanie Hanvey
                                                <i title="Read Mark" data-toggle="tooltip"
                                                   class="hide-show-toggler-item fa fa-check font-size-11"></i>
                                            </h6>
                                            <span class="text-muted m-r-10 small">PM 08:50</span>
                                            <span class="text-muted small">Have you mad...</span>
                                        </div>
                                    </a>
                                    <a href="#" class="list-group-item d-flex link-1 bg-light hide-show-toggler">
                                        <div>
                                            <figure class="avatar avatar-sm m-r-15">
                                                <span class="avatar-title bg-primary rounded-circle">TB</span>
                                            </figure>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="m-b-0 d-flex justify-content-between">
                                                Kenneth Hune
                                                <i title="Read Mark" data-toggle="tooltip"
                                                   class="hide-show-toggler-item fa fa-circle-o font-size-11"></i>
                                            </h6>
                                            <span class="text-muted m-r-10 small">PM 10:23</span>
                                            <span class="text-muted small">I have a meetin...</span>
                                        </div>
                                    </a>
                                    <a href="#" class="list-group-item d-flex align-items-center link-1 hide-show-toggler">
                                        <div>
                                            <figure class="avatar avatar-sm m-r-15">
                                                <span class="avatar-title bg-danger rounded-circle">M</span>
                                            </figure>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="m-b-0 d-flex justify-content-between">
                                                Kevin added
                                                <i title="Read Mark" data-toggle="tooltip"
                                                   class="hide-show-toggler-item fa fa-check font-size-11"></i>
                                            </h6>
                                            <span class="text-muted m-r-10 small">PM 08:50</span>
                                            <span class="text-muted small">Have you mad...</span>
                                        </div>
                                    </a>
                                    <a href="#" class="list-group-item d-flex align-items-center link-1 hide-show-toggler">
                                        <div>
                                            <figure class="avatar avatar-sm m-r-15">
                                                <span class="avatar-title bg-info rounded-circle">KC</span>
                                            </figure>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="m-b-0 d-flex justify-content-between">
                                                Katherine Ember
                                                <i title="Read Mark" data-toggle="tooltip"
                                                   class="hide-show-toggler-item fa fa-check font-size-11"></i>
                                            </h6>
                                            <span class="text-muted m-r-10 small">PM 20:13</span>
                                            <span class="text-muted small">I have a meetin...</span>
                                        </div>
                                    </a>
                                </ul>
                            </div>
                            <div class="dropdown-menu-footer text-right">
                                <ul class="list-inline small">
                                    <li class="list-inline-item">
                                        <a href="#">Mark All Read</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a href="#" data-toggle="dropdown">
                            <figure class="avatar avatar-sm avatar-state-success">
                                <img class="rounded-circle" src="assets/media/image/avatar.jpg" alt="...">
                            </figure>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a href="profile.html" class="dropdown-item">Profile</a>
                            <a href="#" data-sidebar-target="#settings" class="sidebar-open dropdown-item">Settings</a>
                            <div class="dropdown-divider"></div>
                            <a href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();" class="text-danger dropdown-item">Logout</a>
                        </div>
                    </li>
                    <li class="nav-item d-lg-none d-sm-block">
                        <a href="#" class="nav-link side-menu-open">
                            <i class="ti-menu"></i>
                        </a>
                    </li>
                </ul>
            </div>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
    </nav>
    <!-- end::navbar -->
    <main class="main-content">
        @yield('content')
    </main>
@endguest



<script src="{{ asset('assets/vendors/bundle.js') }}"></script>
@guest
@else
<!-- begin::charts -->
<script src="{{ asset('assets/vendors/charts/chartjs/chart.min.js') }}"></script>
<script src="{{ asset('assets/vendors/charts/peity/jquery.peity.min.js') }}"></script>
<script src="{{ asset('assets/vendors/circle-progress/circle-progress.min.js') }}"></script>
<script src="{{ asset('assets/js/examples/charts/chartjs.js') }}"></script>
<script src="{{ asset('assets/js/examples/charts/peity.js') }}"></script>
<!-- end::charts -->

<!-- begin::daterangepicker -->
<script src="{{ asset('assets/vendors/datepicker/daterangepicker.js') }}"></script>
<!-- end::daterangepicker -->

<!-- begin::dashboard -->
<script src="{{ asset('assets/js/examples/dashboard.js') }}"></script>
<!-- end::dashboard -->

<!-- begin::vamp -->
<script src="{{ asset('assets/vendors/vmap/jquery.vmap.min.js') }}"></script>
<script src="{{ asset('assets/vendors/vmap/maps/jquery.vmap.usa.js') }}"></script>
<script src="{{ asset('assets/js/examples/vmap.js') }}"></script>
<!-- end::vamp -->

<!-- begin::custom scripts -->
<script src="{{ asset('assets/js/custom.js') }}"></script>
@endguest
<script src="{{ asset('assets/js/app.min.js') }}"></script>
</body>
</html>
