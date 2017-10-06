<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Bevy</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
    <script
            src="https://code.jquery.com/jquery-3.2.1.js"
            integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE="
            crossorigin="anonymous"></script>
    <!-- Styles -->
    <link href="{{ asset('css/welcome.css') }}" rel="stylesheet">
    <script src="{{ asset('js/welcome.js') }}"></script>

</head>
<body>
<div class="flex-center position-ref full-height">
    @if (Route::has('login'))
        <div class="top-right links">
            @auth
                <a href="{{ url('/home') }}">Tablica</a>
                <a href="{{ url('/profil') }}/{{Auth::user()->slug}}">Profil</a>
                @else
                    <a href="{{ route('login') }}">Logowanie</a>
                    <a href="{{ route('register') }}">Rejestracja</a>
                    @endauth
        </div>
    @endif
    <div class="page">
        <div id="home-news">
            <div class="home_header">
                <strong>Bevy</strong>
                <span>Twoje miejsce w sieci</span>
            </div>
            <div class="home_header">
                <strong>Znajdź znajomych.</strong>
                <span>Znajdź pracę !</span>
            </div>
            <div class="home_header">
                <span>Rozmawiaj. Poznawaj.</span>
                <strong>Dziel się !</strong>
            </div>
        </div>
    </div>

    <div id="isthisweird" class="aleksandra">
        <div class="face"></div>
        <div class="hair-back"></div>
        <div class="hair-front"></div>
        <div class="mouth">
            <div class="teeth"></div>
        </div>
        <div class="moustache"></div>
        <div class="beard"></div>
    </div>

    <h1></h1>
</div>
</body>
</html>
