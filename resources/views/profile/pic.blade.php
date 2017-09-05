@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">{{ Auth::user()->name }}</div>
                    <div class="panel-body">
                    Witaj na swoim profilu !<br>
                        <img src="{{ Auth::user()->pic }}" width="100" height="100"/>
                        <br><br><hr>
                        <form action="{{url('/wgrajZdjecie')}}" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                            <input type="file" name="pic" class="btn btn-primary"/>
                            <br>
                            <input type="submit" class="btn btn-success" name="btn" value="Wgraj zdjęcie"/>
                        </form>
                </div>
            </div>
        </div>
    </div>
    </div>
    @stop