@extends('layouts.app')

@section('content')
    <div class="container">
        <div clas="row">
            @include('layouts.partials.sidebar')
            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">{{ Auth::user()->name }}</div>
                    <div class="panel-body text-center">
                        @if(session()->has('msg'))
                            <div class="alert alert-success">{{session()->get('msg')}}</div>
                        @endif
                        <h3>Zmień zdjęcie profilowe</h3><br>
                        <img class="img-circle" src="{{ Auth::user()->pic }}" width="130" height="130"/>
                        <br><br><hr>
                        <form action="{{url('/wgrajZdjecie')}}" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                            <input type="file" name="pic" class="btn btn-primary center-block"/>
                            <br>
                            <input type="submit" class="btn btn-success" name="btn" value="Wgraj zdjęcie"/>
                        </form>
                </div>

                </div></div></div>       </div>
    @stop