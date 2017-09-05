@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">{{ Auth::user()->name }}</div>

                    <div class="panel-body">

                    Witaj na swoim profilu !<br>
                        <img src="{{ Auth::user()->pic }}" width="80" height="80"/><br>
                        <a href="{{url('/zmienZdjecie')}}">Zmień zdjęcie</a>
                </div>
            </div>
        </div>
    </div>
    </div>
    @stop