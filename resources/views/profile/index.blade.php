@extends('layouts.app')

@section('content')

                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-12  text-center">
                                <div class="thumbnail">
                                    <img class="img-circle" alt="{{Auth::user()->name }}" src="{{ Auth::user()->pic }}" width="160" height="160">
                                    <div class="caption">
                                        <h3>{{ Auth::user()->name }}</h3>
                                        <h4><span class="label label-primary">Kraj: </span></h4><p>{{$data -> country}}</p>
                                        <h4><span class="label label-primary">Miasto: </span></h4><p>{{$data -> city}}</p>
                                        <h4><span class="label label-primary">O mnie : </span></h4><p>{{$data -> about}}</p>
                                        <p><a href="{{url('/edytujProfil')}}" class="btn btn-primary" role="button">Edytuj profil</a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
            </div>

    @stop