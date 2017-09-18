@extends('layouts.app')

@section('content')
    <div class="container" id="searchUser">
        <div clas="row">
            @include('layouts.partials.sidebar')
            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">{{ucwords( Auth::user()->name )}}</div>

                    <div class="panel-body text-center">
                        <h3>Znajdź znajomych</h3>
                        <div class="col-md-12">
                            <div class="col-md-5 pull-left">
                                <input class="form-control" type="text" v-model="search" placeholder="Szukaj znajomych">
                            </div>
                        </div>
                        <hr>
                        <div v-for="uList in filteredUsers">

                            <div class="thumbnail col-md-12" style="margin: 5px;">
                                <a :href="'{{Config::get('url')}}/profil/' + uList.slug"><img
                                            :src="'{{Config::get('url')}}' + uList.pic" class="img-circle"
                                            :alt="uList.name" width="90" height="90"/></a>
                                <a :href="'{{Config::get('url')}}/profil/' + uList.slug"><h3>@{{uList.name}}</h3></a>
                                <div v-for="check in checks" style="visibility: hidden">
                                    <div v-if="check.user_requested == uList.id && check.status == 0 ">
                                        @{{ a = uList.id }}
                                    </div>
                                    <div v-else-if="check.user_requested == uList.id && check.status == 1 || check.requester == uList.id && check.status == 1 ">
                                        @{{ b = uList.id }}
                                    </div>
                                </div>
                                <div class="caption">
                                    <p>@{{uList.country}} - @{{uList.city}}</p>
                                    <div v-if="a != uList.id && b != uList.id">
                                        <a :href="'{{Config::get('url')}}/dodajZnajomego/' + uList.id"
                                           class="btn btn-primary">Dodaj do
                                            znajomych</a>
                                    </div>
                                    <div v-else-if="b == uList.id && a != uList.id">
                                        <div class="caption form-inline">
                                            <a :href="'{{Config::get('url')}}/usun/' + uList.id" class="btn btn-danger">Usuń ze znajomych</a>
                                        </div>
                                    </div>
                                    <div v-else>
                                        Wysłano zaproszenie do znajomych
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Scripts -->
    <script src="{{ asset('js/searchUser.js') }}"></script>

@endsection