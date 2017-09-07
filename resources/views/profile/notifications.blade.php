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
                        <h3>Powiadomienia</h3><br>
                        @foreach($notes as $note)
                         <div class="row" style="border-bottom: 1px solid #ccc;margin-bottom: 15px;">
                             <ul>
                                 <li>
                                     <p><a href="#" style="color:green; font-weight: bold;">{{$note->name}}</a>{{$note->note}}</p>

                                 </li>
                             </ul>
                         </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </div>

@stop