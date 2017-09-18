@extends('layouts.app')

@section('content')
    <div class="container">
        <div clas="row">
            @include('layouts.partials.sidebar')
            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">{{ucwords( Auth::user()->name )}}</div>

                    <div class="panel-body text-center">
                        @if(session()->has('msg'))
                            <div class="alert alert-success">{{session()->get('msg')}}</div>
                        @endif
                        <h3>Zaproszenia do znajomych</h3><br>
                        @foreach($FriendRequests as $uList)
                            <a href="{{ url('/profil') }}/{{$uList->slug}}">
                                <div class="thumbnail col-md-4" style="margin: 5px;">
                                    <img class="img-circle" src="{{ $uList->pic }}" width="60" height="60"/>
                                    <h3>{{$uList->name}}</h3>
                                    <div class="caption form-inline">
                                        <a href="{{url('/akceptuj')}}/{{$uList->name}}/{{$uList->id}}"
                                           class="btn btn-success">Potwierdź</a>
                                        <a href="{{url('/odrzuc')}}/{{$uList->id}}" class="btn btn-danger">Odrzuć</a>
                                    </div>
                                </div>
                            </a>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Scripts -->
    <script src="{{ asset('js/start.js') }}"></script>
@stop