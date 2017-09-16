@extends('layouts.app')

@section('content')
    <style>
        #commentBox{
            padding:10px;
            width:100%;
            margin:10px auto;
            background:white;
            padding:10px;
        }
        #commentBox li { list-style:none; padding:10px; border-bottom:1px solid #ddd}
        .comment_form{ padding:10px; margin:30px}

    </style>
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

                       <div v-for="post in posts" style="margin-bottom:15px;background-color: white; padding:10px;box-shadow: 5px 5px 10px #888888;">
                                    <div class="col-md-12" >
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
                                                <li style="cursor: pointer"  v-if="post.user_id == '{{Auth::user()->id}}'"><a @click="deletePost(post.id)"><i class="fa fa-trash-o" aria-hidden="true"></i> Usuń</a></li>
                                            </div>
                                        </div>
                                        <p style="border-bottom: solid #eeeeee 1px; padding:20px;" class="col-md-12">@{{post.content}}
                                        </p>
                                        <div v-for="like in post.likes" v-if="like.user_id =='{{Auth::user()->id}}' " style=" visibility: hidden">
                                                @{{ a = a + 1 }}
                                        </div>
                                        <div  v-if="post.likes.length==0 " class="col-md-1" style="padding: 15px;">
                                            <i @click="likePost(post.id)"  style="cursor: pointer" class="fa fa-thumbs-up fa-2x text-primary"></i>
                                        </div>
                                        <div v-else-if="a != 1 && post.likes.length!=0" style="padding: 15px;">
                                            <div v-for="like in post.likes" v-if="like.user_id =='{{Auth::user()->id}}' ">
                                                <div class="col-md-1"  style="padding: 15px;">
                                                    <i @click="unlikePost(like.id)"  style="cursor: pointer" class="fa fa-thumbs-down fa-2x text-danger">@{{ like.length }}</i>
                                                </div>
                                            </div>
                                        </div>
                                        <div v-else-if="a == 1 && post.likes.length!=0" class="col-md-1" style="padding: 15px;">
                                            <i @click="likePost(post.id)"  style="cursor: pointer" class="fa fa-thumbs-up fa-2x text-primary"></i>
                                        </div>
                                        <div class="col-md-4" style="padding: 15px;">
                                            @{{ post.likes.length }} Lubię to !
                                        </div>
                                    </div>
                           <div class="comment_form">
                               <textarea class="form-control"  v-model="commentData"></textarea><br>
                               <button class="btn btn-success pull-right" @click="addComment(post.id)">Wyślij</button>
                           </div>
                           <div v-for="comment in post.comments">
                               <div v-if="comment.posts_id == post.id">
                           <article class="row">
                               <div class="col-md-2 col-sm-2 hidden-xs">
                                   <figure class="thumbnail">
                                       <a :href="'{{Config::get('url')}}/profil/' + comment.user.slug"><img :src="'{{Config::get('url')}}' + comment.user.pic" class="img-circle" :alt="comment.user.name" width="90" height="90"/></a>
                                       <figcaption class="text-center">@{{comment.user.name}}</figcaption>
                                   </figure>
                               </div>
                               <div class="col-md-10 col-sm-10">
                                   <div class="panel panel-default arrow left">
                                       <div class="panel-body">
                                           <header class="text-left">
                                               <time class="comment-date" ><i class="fa fa-clock-o"></i>@{{ comment.created_at | myOwnTime }}</time>
                                           </header>
                                           <header class="text-right">
                                               <span style="cursor: pointer"  v-if="comment.user_id == '{{Auth::user()->id}}'"><a @click="deleteComment(comment.id)"><i class="fa fa-trash-o text-danger" aria-hidden="true"></i></a></span>
                                           </header>
                                           <div class="comment-post ">
                                               <p>
                                                  @{{ comment.comment }}
                                               </p>
                                           </div>

                                       </div>
                                   </div>
                               </div>
                           </article>
                               </div>
                           </div>
                       </div>
        </div>
    </div>
    </div>
    <script src="{{ asset('js/app.js') }}"></script>

@endsection
