@extends('layouts.app')

@section('content')
    <div class="container">
        <div clas="row">
            @include('layouts.partials.sidebar')
            <div class="col-md-9">

                <div class="panel panel-default">
                    <div class="panel-heading">{{ Auth::user()->name }}</div>

                    <div class="panel-body text-center">
                        <h3>Edytuj profil</h3><br>
                        <img class="img-circle" src="{{ Auth::user()->pic }}" width="130" height="130"/><br>
                        <a href="{{url('/zmienZdjecie')}}">Zmień zdjęcie</a>
                        <br>
                        <hr>
                        <div class="form-group" style="width: 40% ; margin: 0 auto; ">
                            <form action="{{url('/aktualizujProfil')}}" method="post">
                            <label for="name">Imię i nazwisko</label>
                            <input type="text" id="name" class="form-control" name="name" value="{{Auth::user()->name}}">
                            <label for="email">Email</label>
                            <input type="email" id="email" class="form-control" name="email" value="{{Auth::user()->email}}">
                            <label for="city">Miasto</label>
                            <input type="text" id="city" class="form-control" name="city" placeholder="{{$data->city}}">
                            <label for="city">Kraj</label>
                            <input type="text" id="country" class="form-control" name="country" placeholder="{{$data->country}}">
                            <label for="about">O mnie</label>
                            <textarea type="text" id="about" class="form-control" name="about" placeholder="{{$data->about}}"></textarea>
                            <br>
                            <input type="submit" value="Edytuj" class="btn btn-primary">
                            <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                            </form>
                        </div>

                </div>
                </div>
            </div>
        </div>
            </div>

    @stop