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

                        <div class="panel panel-default">
                            <div class="panel-heading">Najnowsze posty</div>

                            <div class="panel-body">
                                @{{ message }}<h3>@{{ content }}</h3>
                                <form method="post" enctype="multipart/form-data" v-on:submit.prevent="addPost">
                                 <textarea placeholder="Napisz co u Ciebie !" v-model="content" rows="5" style="min-width: 80%"></textarea><br><br>


                                    <input type="submit" class="btn btn-success" value="Udostępnij">
                                    <hr>

                                </form>
                       <div v-for="post in posts">
                                    <div class="col-md-12" style="margin-bottom:15px; border-bottom: 1px solid #bdbdbd">
                                        <div class="col-md-2 pull-left" style="margin-bottom: 10px;">
                                            <a :href="'{{Config::get('url')}}/profil/' + post.slug"><img :src="'{{Config::get('url')}}' + post.pic" :alt="post.name" width="90" height="90"/></a>
                                        </div>
                                        <div class="col-md-10 ">
                                            <h3><a :href="'{{Config::get('url')}}/profil/' + post.slug">@{{post.name}}</a></h3>
                                            <small>@{{ post.created_at }}</small>
                                        </div>
                                        <p class="col-md-12">@{{post.content}}
                                        </p>
                                    </div>
                            </div>
                            </div>
                        </div>
            </div>
        </div>
    </div>






@endsection
