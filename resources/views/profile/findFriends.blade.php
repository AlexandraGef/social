@extends('layouts.app')

@section('content')
    <div class="container" id="searchUser">
        <div clas="row">
            @include('layouts.partials.sidebar')
            <div class="col-md-9">
                <div class="panel panel-primary">
                    <div class="panel-heading text-center" data-toggle="collapse" style="cursor:pointer"
                         data-target="#search">Znajdź znajomych
                    </div>
                    <div class="panel-collapse collapse" id="search">
                        <input class="form-control" type="text" v-model="search" placeholder="Szukaj znajomych">
                    </div>
                </div>
                <div v-for="uList in filteredUsers" class="panel panel-primary">
                    <div class="panel-body">
                        <div class="col-md-8">
                            <div class="col-md-3">
                                <a :href="'{{Config::get('url')}}/profil/' + uList.slug"><img
                                            :src="'{{Config::get('url')}}' + uList.pic" class="img-circle"
                                            :alt="uList.name" width="65" height="65"/></a>
                            </div>
                            <div class="col-md-5">
                                <a :href="'{{Config::get('url')}}/profil/' + uList.slug"><h4>@{{uList.name}}</h4>
                                </a>
                                <p>@{{uList.city}}</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div v-for="check in checks" style="visibility: hidden">
                                <div v-if="check.user_requested == uList.id && check.status == 0 ">
                                    @{{ a = uList.id }}
                                </div>
                                <div v-else-if="check.user_requested == uList.id && check.status == 1 || check.requester == uList.id && check.status == 1 ">
                                    @{{ b = uList.id }}
                                </div>
                            </div>
                            <div>
                                <div v-if="a != uList.id && b != uList.id">
                                    <a @click="addFriends(uList.id)"
                                       class="btn btn-success btn-sm" style="width: 150px">Dodaj do
                                        znajomych</a>
                                </div>
                                <div v-else-if="b == uList.id && a != uList.id">
                                    <a @click="deleteFromFriends(uList.id)" class="btn btn-danger btn-sm" style="width: 150px">Usuń ze
                                        znajomych</a>
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