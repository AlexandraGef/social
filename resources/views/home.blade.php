@extends('layouts.app')

@section('content')
    <div class="container" id="app">
        <div class="row">
            @include('layouts.partials.sidebar')
            <div class="col-md-9">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                        <div class="panel panel-default" style="box-shadow: 5px 5px 10px #888888;">
                            <div class="panel-heading">Najnowsze posty</div>

                            <div class="panel-body" >
                                <div class="col-xs-1 ">
                                    <img class="img-circle" src="{{ Auth::user()->pic }}" width="60" height="60" style="margin-left:-10px"/>                                </div>
                                <div class="col-xs-11">
                                <form method="post" enctype="multipart/form-data" v-on:submit.prevent="addPost" >
                                 <textarea placeholder="Napisz co u Ciebie !"  v-model="content" rows="5" style="min-width: 100%"></textarea><br><br>
                                    <input type="submit" class="btn btn-success pull-right" value="Udostępnij">
                                </form>
                                </div>
                            </div>
                        </div>
                       <div v-for="post in posts">
                                    <div class="col-md-12" style="margin-bottom:15px;background-color: white; padding:10px;box-shadow: 5px 5px 10px #888888;">
                                        <div class="col-md-2 pull-left" style="margin-bottom: 10px;">
                                            <a :href="'{{Config::get('url')}}/profil/' + post.user.slug"><img :src="'{{Config::get('url')}}' + post.user.pic" class="img-circle" :alt="post.user.name" width="90" height="90"/></a>
                                        </div>
                                        <div class="col-md-9 ">
                                            <h3><a :href="'{{Config::get('url')}}/profil/' + post.user.slug">@{{post.user.name}}</a></h3>
                                            <small>@{{ post.created_at | myOwnTime }}</small>
                                        </div>
                                        <div class="col-md-1">
                                            <a href="#" data-toggle="dropdown" aria-haspopup="true"><i class="fa fa-cog" aria-hidden="true"></i></a>
                                            <div class="dropdown-menu" id="dropdown">
                                                <li><a>cos tam</a></li>
                                                <li v-if="post.user_id == '{{Auth::user()->id}}'"><a @click="deletePost(post.id)"><i class="fa fa-trash-o" aria-hidden="true"></i> Usuń</a></li>
                                            </div>
                                        </div>
                                        <p style="border-bottom: solid #eeeeee 1px; padding:20px;" class="col-md-12">@{{post.content}}
                                        </p>
                                        <div  v-if="post.likes.length==0 " class="col-md-1">
                                            <i @click="likePost(post.id)"  style="cursor: pointer" class="fa fa-thumbs-up fa-2x text-primary"></i>
                                        </div>
                                        <div v-else-if="post.likes.length!=0">
                                            <div v-for="like in post.likes" :key="like.user_id =='{{Auth::user()->id}}' ">
                                                <div class="col-md-1">
                                                    <i @click="unlikePost(like.id)"  style="cursor: pointer" class="fa fa-thumbs-down fa-2x text-danger">@{{ like.length }}</i>
                                                </div>
                                            </div>
                                        </div>
                                        <div v-else class="col-md-1">
                                            <i @click="likePost(post.id)"  style="cursor: pointer" class="fa fa-thumbs-up fa-2x text-primary"></i>
                                        </div>
                                        <div class="col-md-4">
                                            @{{ post.likes.length }} Lubię
                                        </div>

                                    </div>
                                        </div>

            </div>
        </div>
    </div>
    <script src="{{ asset('js/app.js') }}"></script>

@endsection
