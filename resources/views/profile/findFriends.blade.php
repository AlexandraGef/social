@extends('layouts.app')

@section('content')
    <div class="container" id="searchUser">
        <div clas="row">
            @include('layouts.partials.sidebar')
            <div class="col-md-9">
                <div class="panel panel-primary" >
                    <div class="panel-heading text-center" data-toggle="collapse" style="cursor:pointer"
                         data-target="#search">Znajdź znajomych</div>
                    <div class="panel-collapse collapse" id="search">
                        <input class="form-control" type="text" v-model="search" placeholder="Szukaj znajomych">
                    </div>
                </div>
                <div v-for="uList in filteredUsers" class="panel panel-primary" >
                    <div class="panel-body text-center">
                        <div class="col-md-12" style="margin: 2px;">
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
                                    <a @click="addFriends(uList.id)"
                                       class="btn btn-success">Dodaj do
                                        znajomych</a>
                                </div>
                                <div v-else-if="b == uList.id && a != uList.id">
                                    <div class="caption form-inline">
                                        <a @click="deleteFromFriends(uList.id)" class="btn btn-danger">Usuń ze
                                            znajomych</a>
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

    <!-- Scripts -->
    <script src="{{ asset('js/searchUser.js') }}"></script>

@endsection