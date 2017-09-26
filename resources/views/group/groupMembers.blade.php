@extends('layouts.app')

@section('content')
    <div class="container">
        <div clas="row">
            @include('layouts.partials.sidebar')
            <div class="col-md-9">
                <div class="panel panel-primary">
                    <div class="panel-body text-center">
                        @if(session()->has('msg'))
                            <div class="alert alert-success">{{session()->get('msg')}}</div>
                        @endif
                        <h3>Człokowie grupy</h3><br>
                        @foreach($members as $uList)
                            @foreach($uList as $u)
                                <div class="col-md-4">
                                    <a href="{{ url('/profil') }}/">
                                        <div class="thumbnail col-md-12">
                                            <img class="img-circle" src="{{ $u->pic }}" width="60" height="60"/>
                                            <h3>{{$u->name}}</h3>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Scripts -->
    <script src="{{ asset('js/start.js') }}"></script>
@stop