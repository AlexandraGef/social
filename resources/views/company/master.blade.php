<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8"/>
    <link rel="icon" type="image/png" href="assets/img/favicon.ico">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>

    <title>Firma</title>

    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport'/>
    <meta name="viewport" content="width=device-width"/>

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <!-- Bootstrap core CSS     -->
    <link href="{{ asset('company_theme/assets/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Animation library for notifications   -->
    <link href="{{ asset('company_theme/assets/css/animate.min.css') }}" rel="stylesheet">

    <!--  Light Bootstrap Table core CSS    -->
    <link href="{{ asset('company_theme/assets/css/light-bootstrap-dashboard.css') }}" rel="stylesheet">

    <!--     Fonts and icons     -->
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300' rel='stylesheet' type='text/css'>
    <link href="{{ asset('company_theme/assets/css/pe-icon-7-stroke.css') }}" rel="stylesheet">

</head>
<body>

<div class="wrapper">
    <div class="sidebar " data-color="orange"
         data-image="{{ asset('company_theme/assets/img/sidebar-1.jpg') }}">

        <div class="sidebar-wrapper">
            <div class="logo">
                <a href="{{url('/firma')}}" class="simple-text">
                    Firma
                </a>
            </div>

            <ul class="nav">
                <li class="active">
                    <a href="{{url('/firma')}}">
                        <i class="pe-7s-graph"></i>
                        <p> Dashboard</p>
                    </a>
                </li>

                <li>
                    <a href="{{url('/firma/OfertyPracy')}}">
                        <i class="pe-7s-graph3"></i>
                        <p>Pokaż oferty pracy</p>
                    </a>
                </li>

                <li>
                    <a href="{{url('/firma/dodajOfertePracy')}}">
                        <i class="pe-7s-plus"></i>
                        <p>Dodaj ofertę</p>
                    </a>
                </li>

            </ul>
        </div>

    </div>

    <div class="main-panel">
        <nav class="navbar navbar-default navbar-fixed">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse"
                            data-target="#navigation-example-2">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#"> <i class="pe-7s-home"> </i> Dashboard</a>
                </div>
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav navbar-left">

                        <!--      <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                          <i class="fa fa-globe"></i>
                                          <b class="caret hidden-sm hidden-xs"></b>
                                          <span class="notification hidden-sm hidden-xs">5</span>
                                                                      <p class="hidden-lg hidden-md">
                                                                          5 Notifications
                                                                          <b class="caret"></b>
                                                                      </p>
                                    </a>
                                    <ul class="dropdown-menu">
                                      <li><a href="#">Notification 1</a></li>
                                      <li><a href="#">Notification 2</a></li>
                                      <li><a href="#">Notification 3</a></li>
                                      <li><a href="#">Notification 4</a></li>
                                      <li><a href="#">Another notification</a></li>
                                    </ul>
                              </li>-->

                    </ul>

                    <ul class="nav navbar-nav navbar-right">

                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <p>
                                    Konto
                                    <b class="caret"></b>
                                </p>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="{{ url('/') }}">Strona domowa</a></li>
                                <li><a href="{{ url('/home') }}">Tablica</a></li>
                                <li class="divider"></li>
                                <li>
                                    <a href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        Wyloguj
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                          style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
                            </ul>
                        </li>
                        <li class="separator hidden-lg hidden-md"></li>
                    </ul>
                </div>
            </div>
        </nav>


        @yield('content')


        <footer class="footer">
            <div class="container-fluid">
                <nav class="pull-left">
                    <ul>
                        <li>
                            <a href="{{ url('/') }}">
                                Strona domowa
                            </a>
                        </li>
                        <li>
                            <a href="{{url('/firma/OfertyPracy')}}">
                                Ofert pracy
                            </a>
                        </li>

                    </ul>
                </nav>
                <p class="copyright pull-right">
                    Dashboard </p>
            </div>
        </footer>

    </div>
</div>


</body>

<!--   Core JS Files   -->
<script src="{{ asset('company_theme/assets/js/jquery-1.10.2.js') }}"></script>
<script src="{{ asset('company_theme/assets/js/bootstrap.min.js') }}"></script>
<!--  Checkbox, Radio & Switch Plugins -->
<script src="{{ asset('company_theme/assets/js/bootstrap-checkbox-radio-switch.js') }}"></script>

<!--  Charts Plugin -->
<script src="{{ asset('company_theme/assets/js/chartist.min.js') }}"></script>

<!--  Notifications Plugin    -->
<script src="{{ asset('company_theme/assets/js/bootstrap-notify.js') }}"></script>

<!--  Google Maps Plugin    -->
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>

<!-- Light Bootstrap Table Core javascript and methods for Demo purpose -->
<script src="{{ asset('company_theme/assets/js/light-bootstrap-dashboard.js') }}"></script>

</html>
