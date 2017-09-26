@extends('layouts.app')

@section('content')
    <div class="container" id="friends">
        <div clas="row">
            @include('layouts.partials.sidebar')
            <div class="col-md-9">
                <div class="panel panel-primary" >
                    <div class="panel-heading text-center" data-toggle="collapse" style="cursor:pointer"
                         data-target="#search">Szukaj wśród znajomych</div>
                    <div class="panel-collapse collapse" id="search">
                        <input class="form-control" type="text" v-model="search" placeholder="Szukaj znajomych">
                    </div>
                </div>

                <div v-for="friend in filteredFriends" class="panel panel-primary" >
                    <div class="panel-body text-center">
                        <div class="col-md-12" style="margin: 2px;">
                            <a :href="'{{Config::get('url')}}/profil/' + friend.slug">
                                <div class="col-md-12">
                                    <img class="img-circle" :src="friend.pic" width="60" height="60"/>
                                    <h3>@{{ friend.name }}</h3>
                                    <div class="caption form-inline">
                                        <a @click="deleteFromFriends(friend.id)" class="btn btn-danger">Usuń ze
                                            znajomych</a>
                                    </div>
                                </div>
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Scripts -->
    <script src="{{ asset('js/friends.js') }}"></script>
@stop