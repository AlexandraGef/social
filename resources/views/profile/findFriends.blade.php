@extends('layouts.app')

@section('content')
    <div class="container" id="search">
        <div clas="row">
            @include('layouts.partials.sidebar')
            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">{{ucwords( Auth::user()->name )}}</div>

                    <div  class="panel-body text-center">
                        <h3 >Znajdź znajomych</h3> <input class="form-control " type="text" v-model="search" placeholder="Szukaj znajomych"> <br>
                      <div v-for="uList in filteredUsers">
                          <div class="thumbnail col-md-12" style="margin: 5px;">
                              <a :href="'{{Config::get('url')}}/profil/' + uList.slug"><img :src="'{{Config::get('url')}}' + uList.pic" class="img-circle" :alt="uList.name" width="90" height="90"/></a>
                              <a :href="'{{Config::get('url')}}/profil/' + uList.slug"><h3>@{{uList.name}}</h3></a>
                              <div class="caption">
                                  <p>@{{uList.country}} - @{{uList.city}}</p>
                                      <?php

                                      $check = '';

                                      if($check =='') {
                                          ?>
                                  <a :href="'{{Config::get('url')}}/' + uList.id" class="btn btn-primary">Dodaj do znajomych</a>
                                  <?php } else {?>
                                  <p>Zaproszenie zostało wysłane</p>
                                  <?php } ?>
                              </div>
                          </div>
                      </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Scripts -->
    <script src="{{ asset('js/search.js') }}"></script>
@stop