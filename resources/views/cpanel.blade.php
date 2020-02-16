<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->

    <title>TOEFL</title>
    <!-- Custom CSS -->
    <!-- Custom CSS -->
    {{--    <link href="{{asset('css/materialdesignicons.min.css')}}" rel="stylesheet">--}}
    <link href="{{asset('css/style.min.css')}}" rel="stylesheet">

    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <link rel="stylesheet" href="{{asset('css/all.min.css')}}">
    <style>
        a:hover{
            text-decoration: none !important;

        }
    </style>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
<!-- ============================================================== -->
<!-- Preloader - style you can find in spinners.css -->
<!-- ============================================================== -->
<div class="preloader">
    <div class="lds-ripple">
        <div class="lds-pos"></div>
        <div class="lds-pos"></div>
    </div>
</div>
<!-- ============================================================== -->
<!-- Main wrapper - style you can find in pages.scss -->
<!-- ============================================================== -->
<div id="main-wrapper">
    <!-- ============================================================== -->
    <!-- Topbar header - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <header class="topbar" data-navbarbg="skin5">
        <nav class="navbar top-navbar navbar-expand-md navbar-dark">
            <div class="navbar-header" data-logobg="skin5">
                <!-- This is for the sidebar toggle which is visible on mobile only -->
                <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)"><i
                        class="ti-menu ti-close"></i></a>
                <!-- ============================================================== -->
                <!-- Logo -->
                <!-- ============================================================== -->
                <a class="navbar-brand" href="{{route('admin')}}">

                    <!-- Logo text -->
                    <span class="logo-text ">
                             <!-- dark Logo text -->
                            <strong style="padding: 0 6vw;">TOEFL</strong>
                        </span>
                    <!-- Logo icon -->
                    <!-- <b class="logo-icon"> -->
                    <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                    <!-- Dark Logo icon -->
                    <!-- <img src="../../assets/images/logo-text.png" alt="homepage" class="light-logo" /> -->

                    <!-- </b> -->
                    <!--End Logo icon -->
                </a>
                <!-- ============================================================== -->
                <!-- End Logo -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Toggle which is visible on mobile only -->
                <!-- ============================================================== -->
                <a class="topbartoggler d-block d-md-none waves-effect waves-light" href="javascript:void(0)"
                   data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                   aria-expanded="false" aria-label="Toggle navigation"><i class="ti-more"></i></a>
            </div>
            <!-- ============================================================== -->
            <!-- End Logo -->
            <!-- ============================================================== -->
            <div class="navbar-collapse collapse" id="navbarSupportedContent" data-navbarbg="skin5">
                <!-- ============================================================== -->
                <!-- toggle and nav items -->
                <!-- ============================================================== -->
                <ul class="navbar-nav float-left mr-auto">
                    <li class="nav-item d-none d-md-block">
                        <a class="nav-link sidebartoggler waves-effect waves-light"
                           href="javascript:void(0)" data-sidebartype="mini-sidebar">
                            <i class="fas fa-bars"></i></a></li>

                </ul>
                <!-- ============================================================== -->
                <!-- Right side toggle and nav items -->
                <!-- ============================================================== -->

                <ul class="navbar-nav float-right">
                <li class="nav-item mt-4" style="color:#fff">{{auth()->user()->name}}</li>
                    <!-- ============================================================== -->
                    <!-- User profile and search -->
                    <!-- ============================================================== -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark pro-pic" href=""
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img
                                src="{{asset('img/1.jpg')}}" alt="user" class="rounded-circle" width="31"></a>
                        <div class="dropdown-menu dropdown-menu-right user-dd animated">

                            <a class="dropdown-item" href="javascript:void(0)"><i
                                    class="fa fa-power-off m-r-5 m-l-5"></i> Logout</a>

                        </div>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <!-- ============================================================== -->
    <!-- End Topbar header -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Left Sidebar - style you can find in sidebar.scss  -->
    <!-- ============================================================== -->
    <aside class="left-sidebar" data-sidebarbg="skin5">
        <!-- Sidebar scroll-->
        <div class="scroll-sidebar">
            <!-- Sidebar navigation-->
            <nav class="sidebar-nav">
                <ul id="sidebarnav" class="p-t-30">
                    @if(auth()->user()->canManageReservationsPanel())
                        <li class="sidebar-item"><a class="sidebar-link waves-effect waves-dark sidebar-link"
                                                    href="{{route('reservations-panel')}}" aria-expanded="false">
                                <i class="far fa-calendar-alt mr-2 ml-1 fa-1x"></i><span class="hide-menu">Reservations</span></a>
                        </li>
                    @endif
                    @if(auth()->user()->canManageStudentsPanel())
                        <li class="sidebar-item"><a class="sidebar-link waves-effect waves-dark sidebar-link"
                                                    href="{{route('cpanel.students-panel')}}" aria-expanded="false">
                                <i class="fas fa-user-graduate mr-2 ml-1 fa-1x"></i><span class="hide-menu">Students</span></a>
                        </li>
                    @endif
                        @if(auth()->user()->canManageExamsPanel())
                    <li class="sidebar-item"><a class="sidebar-link waves-effect waves-dark sidebar-link"
                                                href="{{route('cpanel.exams-panel')}}" aria-expanded="false">
                            <i class="fas fa-stopwatch mr-2 ml-1 fa-1x"></i><span class="hide-menu">Exams Panel</span></a></li>

                            <li class="sidebar-item"><a class="sidebar-link waves-effect waves-dark sidebar-link"
                                                href="{{route('cpanel.attempts-panel')}}" aria-expanded="false">
                            <i class="fas fa-stopwatch mr-2 ml-1 fa-1x"></i><span class="hide-menu">Attempts Panel</span></a></li>

                            <li class="sidebar-item"><a class="sidebar-link waves-effect waves-dark sidebar-link"
                                                        href="{{route('cpanel.student-data')}}" aria-expanded="false">
                                    <i class="fas fa-user-edit mr-2 ml-1 fa-1x">
                                    </i><span class="hide-menu">Edit Students' Marks</span></a>
                            </li>
                   @endif
                    @if(auth()->user()->canPrintCertificates())
                        <li class="sidebar-item"><a class="sidebar-link waves-effect waves-dark sidebar-link"
                                                    href="{{route('cpanel.certificates-panel')}}" aria-expanded="false"><i
                                    class="fas fa-medal mr-2 ml-1 fa-1x"></i><span class="hide-menu">Certificates</span></a>
                        </li>
                    @endif
                    @if(auth()->user()->isSuperAdmin())
                        <li class="sidebar-item"><a class="sidebar-link waves-effect waves-dark sidebar-link"
                                                    href="{{route('cpanel.configs-panel')}}" aria-expanded="false">
                                <i class="fas fa-cogs mr-2 ml-1 fa-1x"></i><span class="hide-menu">Configs Panel</span></a></li>
                        <li class="sidebar-item"><a class="sidebar-link waves-effect waves-dark sidebar-link"
                                                    href="{{route('cpanel.users-panel')}}" aria-expanded="false">
                                <i class="fas fa-users mr-2 ml-1 fa-1x"></i><span class="hide-menu">Users Panel</span></a></li>
                    @endif
                        @if(auth()->user()->canManageGrammarSection())
                        <li class="sidebar-item"><a class="sidebar-link waves-effect waves-dark sidebar-link"
                                                    href="{{route('grammar.questions-panel')}}" aria-expanded="false">
                                <i class="fas fa-question-circle mr-2 ml-1 fa-1x"></i><span class="hide-menu">Grammar Questions</span></a></li>
                        <li class="sidebar-item"><a class="sidebar-link waves-effect waves-dark sidebar-link"
                                                    href="{{route('grammar.exam-panel')}}" aria-expanded="false">
                                <i class="fas fa-file-signature mr-2 ml-1 fa-1x"></i><span class="hide-menu">Grammar Exams</span></a></li>
                    @endif
                        @if(auth()->user()->canManageListeningSection())
                        <li class="sidebar-item"><a class="sidebar-link waves-effect waves-dark sidebar-link"
                                                    href="{{route('audio-panel')}}" aria-expanded="false">
                                <i class="fas fa-music mr-2 ml-1 fa-1x"></i><span class="hide-menu">Audio Files</span></a></li>
                        <li class="sidebar-item"><a class="sidebar-link waves-effect waves-dark sidebar-link"
                                                    href="{{route('listening.exam-panel')}}" aria-expanded="false">
                                <i class="fas fa-file-signature mr-2 ml-1 fa-1x"></i><span class="hide-menu">Listening Exams</span></a></li>
                    @endif
                        @if(auth()->user()->canManageReadingSection())
                        <li class="sidebar-item"><a class="sidebar-link waves-effect waves-dark sidebar-link"
                                                    href="{{route('vocab-panel')}}" aria-expanded="false">
                                <i class="fas fa-question-circle mr-2 ml-1 fa-1x"></i><span class="hide-menu">Vocab Questions</span></a></li>
                            <li class="sidebar-item"><a class="sidebar-link waves-effect waves-dark sidebar-link"
                                                    href="{{route('paragraph-panel')}}" aria-expanded="false">
                                <i class="fas fa-align-left mr-2 ml-1 fa-1x"></i><span class="hide-menu">Paragraphs</span></a></li>
                        <li class="sidebar-item"><a class="sidebar-link waves-effect waves-dark sidebar-link"
                                                    href="{{route('reading.exam-panel')}}" aria-expanded="false">
                                <i class="fas fa-file-signature mr-2 ml-1 fa-1x"></i><span class="hide-menu">Reading Exams</span></a></li>
                    @endif
                        @if(auth()->user()->canEditMarks())
                            <li class="sidebar-item"><a class="sidebar-link waves-effect waves-dark sidebar-link"
                                                        href="{{route('cpanel.marks-panel')}}" aria-expanded="false">
                                    <i class="fas fa-user-edit mr-2 ml-1 fa-1x"></i><span class="hide-menu">Edit Failed Students' Scores </span></a></li>
                        @endif
                        <li class="sidebar-item"><a class="sidebar-link waves-effect waves-dark sidebar-link"
                                                    href="{{route('logout')}}" aria-expanded="false"
                                                    onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                <i class="far fa-times-circle mr-2 ml-1 fa-1x"></i><span class="hide-menu">Logout</span></a></li>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                </ul>
            </nav>
            <!-- End Sidebar navigation -->
        </div>
        <!-- End Sidebar scroll-->
    </aside>
    <!-- ============================================================== -->
    <!-- End Left Sidebar - style you can find in sidebar.scss  -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Page wrapper  -->
    <!-- ============================================================== -->
    <div class="page-wrapper">
        <div class="container-fluid">
            <div id="app">
                @yield('content')
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
</div>
<script src="{{asset('js/app.js')}}"></script>
<script src="{{asset('js/all.min.js')}}"></script>
<script src="{{asset('js/jquery.min.js')}}"></script>
<!-- Bootstrap tether Core JavaScript -->
<script src="{{asset('js/popper.min.js')}}"></script>
<script src="{{asset('js/perfect-scrollbar.jquery.min.js')}}"></script>
{{--<script src="{{asset('js/sparkline.js')}}"></script>--}}
<!--Wave Effects -->
{{--<script src="{{asset('js/waves.js')}}"></script>--}}
<!--Menu sidebar -->
<script src="{{asset('js/sidebarmenu.js')}}"></script>
<!--Custom JavaScript -->
<script src="{{asset('js/custom.min.js')}}"></script>
<script src="{{asset('js/bootstrap.min.js')}}"></script>


</body>

</html>
