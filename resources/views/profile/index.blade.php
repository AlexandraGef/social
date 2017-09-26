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
    <div class="container" id="app">
        <div clas="row">
            @foreach($userData as $uData)
                <div class="col-lg-3 col-md-3 hidden-sm hidden-xs">
                    <div class="panel panel-primary"
                         style="margin-bottom:15px;background-color: white; padding:10px;box-shadow: 5px 5px 10px #888888;">
                        <div class="panel-body">
                            <div class="media">
                                <div align="center">
                                    <img class="img-circle img-responsive" alt="{{$uData->name }}"
                                         src="{{ $uData->pic }}" width="300px" height="300px">
                                </div>
                                <div class="media-body">
                                    <hr>
                                    <h3><strong>O mnie</strong></h3>
                                    <p>{{$uData -> about}}</p>
                                    <hr>
                                    <h3><strong>Płeć</strong></h3>
                                    <p>{{$uData -> gender}}</p>
                                    <hr>
                                    <h3><strong>Kraj</strong></h3>
                                    <p>{{$uData -> country}}</p>
                                    <hr>
                                    <h3><strong>Miasto</strong></h3>
                                    <p>{{$uData -> city}}</p>
                                    @if ($uData->user_id == Auth::user()->id || Auth::user()->role_id == 4 )
                                        <div style="text-align: center; margin-top: 30px;">
                                            <p><a href="{{url('/edytujProfil')}}" class="btn btn-primary"
                                                  role="button">Edytuj profil</a></p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                    <div class="panel panel-primary"
                         style="margin-bottom:15px;background-color: white; padding:10px;box-shadow: 5px 5px 10px #888888;">
                        <div class="panel-body">
                            <div>
                                <h1 class="panel-title pull-left" style="font-size:30px;">{{$uData->name}}</h1>
                                @if ($uData->user_id != Auth::user()->id )
                                    <div class="pull-right">
                                        <div v-for="check in checks" style="visibility: hidden">
                                            <div v-if="check.user_requested == {{$uData -> user_id}} && check.status == 0 ">
                                                @{{ a = {!!$uData->user_id !!} }}
                                            </div>
                                            <div v-else-if="check.user_requested == {{$uData -> user_id}} && check.status == 1 || check.requester == {{$uData -> user_id}} && check.status == 1 ">
                                                @{{ b = {!!$uData->user_id !!} }}
                                            </div>
                                        </div>
                                        <div v-if="a != {{$uData -> user_id}} && b != {{$uData -> user_id}}">
                                            <a @click="addFriends({{$uData -> user_id}})"
                                               class="btn btn-success">Dodaj do
                                                znajomych</a>
                                        </div>
                                        <div v-else-if="b == {{$uData -> user_id}} && a != {{$uData -> user_id}}">
                                            <div class="caption form-inline">
                                                <a @click="deleteFromFriends({{$uData -> user_id}})"
                                                   class="btn btn-danger">Usuń ze znajomych</a>
                                            </div>
                                        </div>
                                        <div v-else class="text-primary">
                                            Wysłano zaproszenie do znajomych
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <br><br><br><br>
                            <hr>
                            <span class="pull-left">
    <a href="#" class="btn btn-link" style="text-decoration:none;"><i class="fa fa-fw fa-files-o"
                                                                      aria-hidden="true"></i> Posty <span
                class="badge">@{{posts.length}}</span></a>
    <a href="#" class="btn btn-link" style="text-decoration:none;"><i class="fa fa-fw fa-users"
                                                                      aria-hidden="true"></i> Znajomych <span
                class="badge">@{{friends.length}}</span></a>
</span>
                            @if ($uData->user_id != Auth::user()->id )
                                <span class="pull-right">
    <a href="{{url('/zglosProfil')}}/{{$uData->id}}" class="btn btn-link"
       style="text-decoration:none;"><i class="fa fa-md fa-exclamation-triangle" aria-hidden="true"
                                        data-toggle="tooltip" data-placement="bottom"
                                        title="Zgłoś"></i></a>
</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                    <div v-for="post in posts">
                        <div v-if="post.group_id == 0 && {{$uData->user_id}} == post.user.id"
                             class="panel panel-primary"
                             style="margin-bottom:15px;background-color: white; padding:10px;box-shadow: 5px 5px 10px #888888;">

                            <div class="col-md-12" class="panel-body">
                                <div class="col-md-2 pull-left" style="margin-bottom: 10px;">
                                    <a :href="'{{Config::get('url')}}/profil/' + post.user.slug"><img
                                                :src="'{{Config::get('url')}}' + post.user.pic" class="img-circle"
                                                :alt="post.user.name" width="90" height="90"/></a>
                                </div>
                                <div class="col-md-9 ">
                                    <h3>
                                        <a :href="'{{Config::get('url')}}/profil/' + post.user.slug">@{{post.user.name}}</a>
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
                                                <button type="button" class="close" data-dismiss="modal">&times;
                                                </button>
                                                <h4 class="modal-title">Edytuj post</h4>
                                            </div>
                                            <div class="modal-body" style="margin-bottom: 30px">
                                                <form method="get" enctype=multipart/form-data"
                                                      v-on:submit.prevent="editPost(post.id)">
                    <textarea id="editBox" v-bind:placeholder="post.content" v-model="editContent"
                              rows="5"
                              style="min-width: 100%"></textarea><br><br>
                                                    <input type="submit" class="btn btn-success pull-right"
                                                           value="Edytuj">
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
                                                                    class="img-circle" :alt="comment.user.name"
                                                                    width="50"
                                                                    height="50"/></a>
                                                        <figcaption class="text-center">@{{comment.user.name}}
                                                        </figcaption>
                                                    </figure>
                                                </div>
                                                <div class="col-md-10 col-sm-10">
                                                    <div class="panel panel-default arrow left">
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
                                                                                    <div class="panel panel-default arrow left">
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
            @endforeach
        </div>
    </div>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
@stop
