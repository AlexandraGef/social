@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="container">
            <div clas="row">
                @include('layouts.partials.sidebar')
                @foreach($userData as $uData)
                    <div class="col-md-9">
                        <div class="panel panel-default">
                            <div class="panel-heading" style="min-height: 40px;">
                                <div class="pull-left">{{$uData->name}}</div>
                                @if ($uData->user_id != Auth::user()->id)
                                    <div style="cursor: pointer">
                                        <a href="{{url('/zglosProfil')}}/{{$uData->id}}"><i
                                                    class="fa fa-exclamation-triangle text-danger pull-right"
                                                    title="Zgłoś profil"
                                                    aria-hidden="true"></i></a></div>
                                @endif
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-sm-12  text-center">
                                        <div class="thumbnail">
                                            <img class="img-circle" alt="{{$uData->name }}" src="{{ $uData->pic }}"
                                                 width="160" height="160">
                                            <div class="caption">
                                                <h3>{{ $uData->name }}</h3>
                                                <h4><span class="label label-primary">Kraj: </span></h4>
                                                <p>{{$uData -> country}}</p>
                                                <h4><span class="label label-primary">Miasto: </span></h4>
                                                <p>{{$uData -> city}}</p>
                                                <h4><span class="label label-primary">O mnie : </span></h4>
                                                <p>{{$uData -> about}}</p>
                                                @if ($uData->user_id == Auth::user()->id || Auth::user()->role_id == 4 )
                                                    <p><a href="{{url('/edytujProfil')}}" class="btn btn-primary"
                                                          role="button">Edytuj profil</a></p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- Scripts -->
    <script src="{{ asset('js/start.js') }}"></script>
@stop