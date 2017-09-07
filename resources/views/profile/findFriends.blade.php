@extends('layouts.app')

@section('content')
    <div class="container">
        <div clas="row">
            @include('layouts.partials.sidebar')
            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">{{ucwords( Auth::user()->name )}}</div>

                    <div class="panel-body text-center">
                        <h3>Znajdź znajomych</h3><br>
                      @foreach($allUsers as $uList)
                          <a href="{{ url('/profil') }}/{{$uList->slug}}">
                          <div class="thumbnail col-md-12" style="margin: 5px;">
                              <img class="img-circle" src="{{ $uList->pic }}" width="60" height="60"/>
                              <h3>{{$uList->name}}</h3>
                              <div class="caption">
                                  <p>{{$uList->country}} - {{$uList->city}}</p>
                                      <?php
                                      $check = DB::table('friendships')
                                              ->where('user_requested', '=', $uList->id)
                                              ->where('requester','=', Auth::user()->id)
                                              ->first();
                                      if($check =='') {
                                          ?>
                                  <a href="{{url('/dodajZnajomego')}}/{{$uList->id}}" class="btn btn-primary">Dodaj do znajomych</a>
                                  <?php } else {?>
                                  <p>Zaproszenie zostało wysłane</p>
                                  <?php } ?>
                              </div>
                          </div>
                          </a>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </div>

@stop