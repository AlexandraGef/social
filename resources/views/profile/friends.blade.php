@extends('layouts.app')

@section('content')
    <div class="container">
        <div clas="row">
            @include('layouts.partials.sidebar')
            <div class="col-md-9">
                <div class="panel panel-primary">
                    <div class="panel-heading">{{ucwords( Auth::user()->name )}}</div>

                    <div class="panel-body text-center">
                        @if(session()->has('msg'))
                            <div class="alert alert-success">{{session()->get('msg')}}</div>
                        @endif
                        <h3>Znajomi</h3><br>
                        @foreach($friends as $uList)
                            <a href="{{ url('/profil') }}/{{$uList->slug}}">
                                <div class="thumbnail col-md-12">
                                    <img class="img-circle" src="{{ $uList->pic }}" width="60" height="60"/>
                                    <h3>{{$uList->name}}</h3>
                                    <div class="caption form-inline">
                                        <a href="{{url('/usun')}}/{{$uList->id}}" class="btn btn-danger">Usuń ze znajomych</a>
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