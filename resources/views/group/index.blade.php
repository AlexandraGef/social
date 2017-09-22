@extends('layouts.app')

@section('content')
    <div class="container" id="app">
        <div clas="row">
            @foreach($groups as $uData)
                <div class="col-lg-3 col-md-3 hidden-sm hidden-xs">
                    <div class="panel panel-default"
                         style="margin-bottom:15px;background-color: white; padding:10px;box-shadow: 5px 5px 10px #888888;">
                        <div class="panel-body">
                            <div class="media">
                                <div align="center">
                                    <img class="img-circle img-responsive" alt="{{$uData->name }}"
                                         src="{{ $uData->pic }}" width="300px" height="300px">
                                </div>
                                <div class="media-body">
                                    <hr>
                                    <h3><strong>Opis</strong></h3>
                                    <p>{{$uData -> description}}</p>
                                    @if ($uData->user_id == Auth::user()->id || Auth::user()->role_id == 4 )
                                        <div style="text-align: center; margin-top: 30px;">
                                            <p><a href="{{url('/edytujProfil')}}" class="btn btn-primary"
                                                  role="button">Edytuj grupe</a></p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                    <div class="panel panel-default"
                         style="margin-bottom:15px;background-color: white; padding:10px;box-shadow: 5px 5px 10px #888888;">
                        <div class="panel-body">
                    <span>
                        <h1 class="panel-title pull-left" style="font-size:30px;">{{$uData->name}}</h1>

                    </span>
                            <br><br><br><br>
                            <hr>
                            <span class="pull-left">
                        <a href="#" class="btn btn-link" style="text-decoration:none;"><i class="fa fa-fw fa-files-o"
                                                                                          aria-hidden="true"></i> Posty <span
                                    class="badge"></span></a>
                        <a href="#" class="btn btn-link" style="text-decoration:none;"><i class="fa fa-fw fa-users"
                                                                                          aria-hidden="true"></i> Członkowie <span
                                    class="badge"></span></a>
                    </span>
                            <span class="pull-right">
                        <a href="{{url('/zglosProfil')}}/{{$uData->id}}" class="btn btn-link"
                           style="text-decoration:none;"><i class="fa fa-lg fa-ban" aria-hidden="true"
                                                            data-toggle="tooltip" data-placement="bottom"
                                                            title="Ignore"></i></a>
                    </span>
                        </div>
                    </div>
                </div>
                @endforeach
        </div>
    </div>
@endsection