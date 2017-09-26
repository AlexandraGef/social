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
                        <h3>Powiadomienia</h3><br>
                        @foreach($notes as $note)
                            <div class="row" style="border-bottom: 1px solid #ccc;margin-bottom: 15px;">
                                <ul>
                                    <li style="list-style-type: none;">
                                        <p><a href="{{ url('/profil') }}/{{$note->slug}}"
                                              style="color:green; font-weight: bold;"><img class="img-circle"
                                                                                           alt="{{$note->name }}"
                                                                                           src="{{ $note->pic }}"
                                                                                           width="60" height="60"
                                                                                           style="margin-right: 10px;">{{$note->name}}
                                            </a>{{$note->note}}</p>
                                        <a style="cursor:pointer" href="{{ url('/usunPowiadomienie') }}/{{$id}}"><i
                                                    class="fa fa-trash-o text-primary" aria-hidden="true"></i>Usuń
                                            powiadomienie</a>
                                    </li>
                                </ul>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Scripts -->
    <script src="{{ asset('js/start.js') }}"></script>
@stop