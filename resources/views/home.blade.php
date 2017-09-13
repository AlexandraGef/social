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

                        <div class="panel panel-default" >
                            <div class="panel-heading">Najnowsze posty</div>

                            <div class="panel-body" >
                                <form method="post" enctype="multipart/form-data" v-on:submit.prevent="addPost" >
                                 <textarea placeholder="Napisz co u Ciebie !"  v-model="content" rows="5" style="min-width: 80%"></textarea><br><br>


                                    <input type="submit" class="btn btn-success" value="Udostępnij">
                                    <hr>

                                </form>
                            </div>
                        </div>
                       <div v-for="post in posts">
                                    <div class="col-md-12" style="margin-bottom:15px;background-color: white; padding:10px">
                                        <div class="col-md-2 pull-left" style="margin-bottom: 10px;">
                                            <a :href="'{{Config::get('url')}}/profil/' + post.slug"><img :src="'{{Config::get('url')}}' + post.pic" :alt="post.name" width="90" height="90"/></a>
                                        </div>
                                        <div class="col-md-8 ">
                                            <h3><a :href="'{{Config::get('url')}}/profil/' + post.slug">@{{post.name}}</a></h3>
                                            <small>@{{ post.created_at }}</small>
                                        </div>
                                        <div class="col-md-2">
                                            <a href="#" data-toggle="dropdown" aria-haspopup="true"><i class="fa fa-cog" aria-hidden="true"></i></a>
                                            <div class="dropdown-menu" id="dropdown">
                                                <li><a>cos tam</a></li>
                                                <li v-if="post.user_id == '{{Auth::user()->id}}'"><a @click="deletePost(post.id)"><i class="fa fa-trash-o" aria-hidden="true"></i> Usuń</a></li>
                                            </div>
                                        </div>
                                        <p class="col-md-12">@{{post.content}}
                                        </p>
                                    </div>
                            </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/app.js') }}"></script>

@endsection
