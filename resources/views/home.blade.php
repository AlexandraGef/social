@extends('layouts.app')

@section('content')
    <style>

        #commentBox li {
            list-style: none;
            padding: 10px;
            border-bottom: 1px solid #ddd
        }

        .comment_form {
            padding: 10px;
            margin: 30px
        }

    </style>
    <div class="container" >
        <div class="row">
            @include('layouts.partials.sidebar')
            <div class="col-md-9">
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif

                <div class="panel panel-primary" style="box-shadow: 5px 5px 10px #888888;">
                    <div class="panel-body" style="margin-top: 20px;">
                        <div class="col-xs-1 ">
                            <img class="img-circle" src="{{ Auth::user()->pic }}" width="60" height="60"
                                 style="margin-left:-10px"/></div>
                        <div class="col-xs-11">
                            <form method="post" enctype="multipart/form-data" v-on:submit.prevent="addPost">
                                <textarea placeholder="Napisz co u Ciebie !" v-model="content" rows="5"
                                          style="min-width: 100%"></textarea><br><br>
                                <input type="submit" class="btn btn-success pull-right" value="Udostępnij">
                            </form>
                        </div>
                    </div>
                </div>
                <div v-for="post in posts">
                    <div v-if="post.group_id == 0" class="panel panel-primary"
                         style="margin-bottom:15px;background-color: white; padding:10px;box-shadow: 5px 5px 10px #888888;">
                        <div class="col-md-12">
                            <div class="col-md-2 pull-left" style="margin-bottom: 10px;">
                                <a :href="'{{Config::get('url')}}/profil/' + post.user.slug"><img
                                            :src="'{{Config::get('url')}}' + post.user.pic" class="img-circle"
                                            :alt="post.user.name" width="90" height="90"/></a>
                            </div>
                            <div class="col-md-9 ">
                                <h3><a :href="'{{Config::get('url')}}/profil/' + post.user.slug">@{{post.user.name}}</a>
                                </h3>
                                <small>@{{ post.created_at | myOwnTime }}</small>
                            </div>
                            <div class="col-md-1">
                                <a href="#" data-toggle="dropdown" aria-haspopup="true"><i class="fa fa-cog"
                                                                                           aria-hidden="true"></i></a>
                                <div class="dropdown-menu" id="dropdown">
                                    <div style="cursor: pointer; text-align: center">
                                        <li v-if="'{{Auth::user()->id}}' == post.user.id || '{{ Auth::user()->role_id}}' == 4">
                                            <a data-toggle="modal"
                                               :data-target="'#modal' + post.id"><i
                                                        class="fa fa-pencil"
                                                        aria-hidden="true"></i>Edytuj</a><br>
                                            <a
                                                    @click="deletePost(post.id)"><i class="fa fa-trash-o"
                                                                                    aria-hidden="true"></i> Usuń</a>
                                        </li>

                                        <li v-if="'{{Auth::user()->id}}' != post.user.id || '{{ Auth::user()->role_id}}' == 4">
                                            <a :href="'{{Config::get('url')}}/zglosPost/' + post.id"
                                               class="text-danger"><i
                                                        class="fa fa-exclamation-triangle" title="Zgłoś post"
                                                        aria-hidden="true"></i>Zgłoś</a>
                                        </li>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" v-bind:id="['modal'+ post.id]" role="dialog">
                                <div class="modal-dialog">

                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title">Edytuj post</h4>
                                        </div>
                                        <div class="modal-body" style="margin-bottom: 30px">
                                            <form method="get" enctype=multipart/form-data"
                                                  v-on:submit.prevent="editPost(post.id)">
                                        <textarea id="editBox" v-bind:placeholder="post.content" v-model="editContent"
                                                  rows="5"
                                                  style="min-width: 100%"></textarea><br><br>
                                                <input type="submit" class="btn btn-success pull-right" value="Edytuj">
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <p style="border-bottom: solid #eeeeee 1px; padding:20px;" class="col-md-12">
                                @{{post.content}}
                            </p>
                            <div v-for="like in post.likes" v-if="like.user_id =='{{Auth::user()->id}}' "
                                 style="visibility: hidden">
                                @{{ a = post.id }}
                            </div>
                            <div v-if="post.likes.length==0" class="col-md-1" style="padding: 15px;">
                                <i @click="likePost(post.id)" style="cursor: pointer"
                                   class="fa fa-thumbs-up fa-2x text-primary"></i>
                            </div>
                            <div v-else-if="a == post.id && post.likes.length!=0" style="padding: 15px;">
                                <div v-for="like in post.likes" v-if="like.user_id =='{{Auth::user()->id}}' ">
                                    <div class="col-md-1" style="padding: 15px;">
                                        <i @click="unlikePost(like.id)" style="cursor: pointer"
                                           class="fa fa-thumbs-down fa-2x text-default"></i>
                                    </div>
                                </div>
                            </div>
                            <div v-else-if="a != post.id && post.likes.length!=0" class="col-md-1"
                                 style="padding: 15px;">
                                <i @click="likePost(post.id)" style="cursor: pointer"
                                   class="fa fa-thumbs-up fa-2x text-primary"></i>
                            </div>
                            <div class="col-md-4" style="padding: 15px;">
                                @{{ post.likes.length }} Lubię to !
                            </div>
                        </div>
                        <div class="comment_form ">
                            <textarea class="form-control" v-model="commentData"></textarea><br>
                            <button style="margin-bottom: 15px" class="btn btn-success pull-right"
                                    @click="addComment(post.id)">Wyślij
                            </button>
                        </div>

                        <div v-if="post.comments.length != 0">
                            <a class="btn btn-primary btn-xs" data-toggle="collapse"
                               style="cursor: pointer;margin-right:20px"
                               :data-target="'#comments' + post.id">Pokaż komentarze</a><i
                                    class="fa fa-comment text-primary" aria-hidden="true">@{{ post.comments.length
                                }}</i>
                            <div v-bind:id="['comments'+ post.id]" class="panel-collapse collapse"
                                 style="margin-top:15px">
                                <div v-for="comment in post.comments">
                                    <div v-if="comment.posts_id == post.id">

                                        <article class="row">
                                            <div class="col-md-2 col-sm-2 hidden-xs">
                                                <figure class="thumbnail">
                                                    <a :href="'{{Config::get('url')}}/profil/' + comment.user.slug"><img
                                                                :src="'{{Config::get('url')}}' + comment.user.pic"
                                                                class="img-circle" :alt="comment.user.name" width="50"
                                                                height="50"/></a>
                                                    <figcaption class="text-center">@{{comment.user.name}}</figcaption>
                                                </figure>
                                            </div>
                                            <div class="col-md-10 col-sm-10">
                                                <div class="panel panel-primary arrow left">
                                                    <div class="panel-body">
                                                        <header class="text-left">
                                                            <time class="comment-date"><i class="fa fa-clock-o"></i>@{{
                                                                comment.created_at | myOwnTime }}
                                                            </time>
                                                        </header>
                                                        <header class="text-right">
                                                <span style="cursor: pointer"
                                                      v-if="comment.user_id == '{{Auth::user()->id}}' || '{{ Auth::user()->role_id}}' == 4"><a
                                                            @click="deleteComment(comment.id)"><i
                                                                class="fa fa-trash-o text-primary"
                                                                aria-hidden="true"></i></a></span>
                                                            <span style="cursor: pointer"
                                                                  v-if="comment.user_id != '{{Auth::user()->id}}' || '{{ Auth::user()->role_id}}' == 4"><a
                                                                        :href="'{{Config::get('url')}}/zglosKomentarz/' + comment.id"><i
                                                                            class="fa fa-exclamation-triangle text-danger"
                                                                            title="Zgłoś komentarz"
                                                                            aria-hidden="true"></i></a></span>
                                                        </header>
                                                        <div class="comment-post">
                                                            <p>
                                                                @{{ comment.comment }}
                                                            </p>
                                                            <a data-toggle="collapse" style="cursor: pointer;"
                                                               :data-target="'#answers' + comment.id">Odpowiedzi</a><i
                                                                    style="margin-left: 20px"
                                                                    class="fa fa-comment text-primary"
                                                                    aria-hidden="true">@{{
                                                                comment.answers.length }}</i>
                                                            <div v-bind:id="['answers'+ comment.id]"
                                                                 class="panel-collapse collapse"
                                                                 style="margin-top:15px">
                                                        <textarea class="form-control"
                                                                  v-model="answerData"></textarea><br>
                                                                <button style="margin-bottom: 15px"
                                                                        class="btn btn-success pull-right btn-xs"
                                                                        @click="addAnswer(comment.id)">Odpowiedz
                                                                </button>
                                                                <div v-for="answer in comment.answers">
                                                                    <div v-if="answer.comment_id == comment.id">

                                                                        <article class="row">
                                                                            <div class="col-md-2 col-sm-2 hidden-xs">
                                                                                <figure class="thumbnail">
                                                                                    <a :href="'{{Config::get('url')}}/profil/' + answer.user.slug"><img
                                                                                                :src="'{{Config::get('url')}}' + answer.user.pic"
                                                                                                class="img-circle"
                                                                                                :alt="answer.user.name"
                                                                                                width="50"
                                                                                                height="50"/></a>
                                                                                    <figcaption class="text-center">
                                                                                        @{{answer.user.name}}
                                                                                    </figcaption>
                                                                                </figure>
                                                                            </div>
                                                                            <div class="col-md-10 col-sm-10">
                                                                                <div class="panel panel-primary arrow left">
                                                                                    <div class="panel-body">
                                                                                        <header class="text-left">
                                                                                            <time class="comment-date">
                                                                                                <i
                                                                                                        class="fa fa-clock-o"></i>@{{
                                                                                                answer.created_at |
                                                                                                myOwnTime
                                                                                                }}
                                                                                            </time>
                                                                                        </header>
                                                                                        <header class="text-right">
                                                <span style="cursor: pointer"
                                                      v-if="answer.user_id == '{{Auth::user()->id}}' || '{{ Auth::user()->role_id}}' == 4"><a
                                                            @click="deleteAnswer(answer.id)"><i
                                                                class="fa fa-trash-o text-primary"
                                                                aria-hidden="true"></i></a></span>
                                                                                            <span style="cursor: pointer"
                                                                                                  v-if="answer.user_id != '{{Auth::user()->id}}' || '{{ Auth::user()->role_id}}' == 4"><a
                                                                                                        :href="'{{Config::get('url')}}/zglosOdpowiedz/' + answer.id"><i
                                                                                                            class="fa fa-exclamation-triangle text-danger"
                                                                                                            title="Zgłoś odpowiedź"
                                                                                                            aria-hidden="true"></i></a></span>
                                                                                        </header>
                                                                                        <div class="comment-post ">
                                                                                            <p>
                                                                                                @{{ answer.answer }}
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
                                            </div>
                                        </article>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/app.js') }}"></script>

@endsection
