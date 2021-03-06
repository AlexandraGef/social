<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Bevy</title>

    <!-- Styles -->
    <link href="{{ asset('css/jquery-ui.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
<style>
    a.anav {
        height: 60px;
    }

    .scrollable-menu {
        height: auto;
        max-height: 300px;
        overflow-x: hidden;
    }
</style>

<div>
    <nav class="navbar navbar-default navbar-static-top" id="search-nav">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#app-navbar-collapse">
                    <span class="sr-only">Rozwijana nawigacja</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    Bevy
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    @if(Auth::check())
                        <li><a class="anav" href="{{ url('/home') }}">Tablica</a></li>
                        <li><a class="anav" href="{{ url('/zaproszenia') }}">Moje zaproszenia <span style="color:#772953; font-weight:bold;
                                       font-size:16px">({{App\friendships::where('status', 0)
                                                  ->where('user_requested', Auth::user()->id)
                                                  ->count()}})</span></a></li>
                    @endif
                    @if(Auth::check() && Auth::user()->role_id == "3")
                        <li><a class="anav" href="{{ url('/firma') }}">Firma</a></li>
                    @endif
                    @if(Auth::check() && Auth::user()->role_id == "4")
                        <li><a class="anav" href="{{ url('/zgloszenia') }}">Zgłoszenia</a></li>
                    @endif
                    @if(Auth::check())
                        <li class="input"><input class="form-control" placeholder="Szukaj znajomych i grup" type="text"
                                                 v-model="queryString" v-on:keyup="getResult()">
                            <div class="panel panel-primary search" v-if="us.length != 0">
                                <ul class="list-group">
                                    <li v-for="u in us">
                                        <a v-if="u.description == null"
                                           :href="'{{Config::get('url')}}/profil/' + u.slug"
                                           class="list-group-item"><img :src="'{{Config::get('url')}}' + u.pic"
                                                                        class="img-circle img-search"
                                                                        :alt="u.name" width="35" height="35"/>@{{u.name}}</a>
                                        <a v-if="u.description != null" :href="'{{Config::get('url')}}/grupa/' + u.slug"
                                           class="list-group-item"><img :src="'{{Config::get('url')}}' + u.pic"
                                                                        class="img-circle img-search"
                                                                        :alt="u.name" width="35" height="35"/>@{{u.name}}</a>
                                    </li>
                                </ul>
                            </div>
                        <li>
                    @endif
                </ul>
                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right" style="height: 100%">
                    <!-- Authentication Links -->
                    @guest
                        <li><a href="{{ route('login') }}">Logowanie</a></li>
                        <li><a href="{{ route('register') }}">Rejestracja</a></li>
                        @else
                            <li style="height: 100%"><a href="{{ url('/wiadomosci') }}"><i class="fa fa-envelope fa-2x"
                                                                                           aria-hidden="true"></i>
                                </a></li>
                            <li><a class="anav" href="{{ url('/znajomi') }}"><i class="fa fa-users fa-2x"
                                                                                aria-hidden="true"></i>
                                </a></li>
                            <li class="dropdown">
                                <a class="anav" href="" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                   aria-expanded="false">
                                    <i class="fa fa-globe fa-2x" aria-hidden="true"></i>
                                    <span class="badge"
                                          style="background: #772953; position: relative;top: -15px;left: -10px;">
                                            {{App\notifications::where('status',1)->where('user_hero',Auth::user()->id)->count()}}</span>

                                </a>

                                <?php
                                $notes = DB::table('users')
                                    ->leftJoin('notifications', 'users.id', 'notifications.user_logged')
                                    ->where('user_hero', Auth::user()->id)
                                    ->orderBy('notifications.created_at', 'desc')
                                    ->get();
                                ?>

                                <ul class="dropdown-menu scrollable-menu" role="menu" style="width:320px">
                                    @foreach($notes as $note)
                                        <a class="anav" href="{{url('/powiadomienia')}}/{{$note->id}}">
                                            @if($note->status==1)
                                                <li style="background:#E4E9F2; padding:10px">
                                            @else
                                                <li style="padding:10px">
                                                    @endif
                                                    <div class="row">
                                                        <div class="col-md-2">
                                                            <img src="{{$note->pic}}"
                                                                 style="width:50px; padding:5px; background:#fff; border:1px solid #eee"
                                                                 class="img-rounded">
                                                        </div>
                                                        <div class="col-md-10">
                                                            <b style="color:orangered; font-size:90%">{{ucwords($note->name)}}</b>
                                                            <span style="color:#000; font-size:90%">{{$note->note}}</span>
                                                            <br/>
                                                            <small style="color:#90949C"><i aria-hidden="true"
                                                                                            class="fa fa-users"></i>
                                                                {{date('F j, Y', strtotime($note->created_at))}}
                                                                at {{date('H: i', strtotime($note->created_at))}}
                                                            </small>
                                                        </div>
                                                    </div>
                                                </li></a>
                                    @endforeach
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a class="anav" href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                   aria-expanded="false">
                                    <img class="img-circle" src="{{ Auth::user()->pic }}" width="40" height="40"/>
                                    {{ ucwords(Auth::user()->name) }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li class="text-center"><a href="{{ url('/profil') }}/{{Auth::user()->slug}}">Twój
                                            profil</a></li>
                                    <li class="text-center"><a href="{{url('/edytujProfil')}}">Edytuj profil</a></li>
                                    <li class="text-center">
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

                            @endguest
                </ul>
            </div>
        </div>
    </nav>
    <script src="{{ asset('js/search.js') }}"></script>
    @yield('content')
</div>


</body>
</html>
