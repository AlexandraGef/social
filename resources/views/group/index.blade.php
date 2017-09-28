@extends('layouts.app')

@section('content')
    <div class="container" id="groupIndex">
        <div clas="row">
            @foreach($groups as $uData)
                @foreach($uData->admins as $admin)
                    @if($admin->id == Auth::user()->id)
                        <span style="visibility: hidden"> @{{ admin = {!! $admin->id !!} }}</span>
                    @endif
                @endforeach
                <div class="col-lg-3 col-md-3 hidden-sm hidden-xs">
                    <div class="panel panel-primary index">
                        <div class="panel-body">
                            <div class="media">
                                <div align="center">
                                    <img class="img-circle" alt="{{$uData->name }}"
                                         src="{{ $uData->pic }}" width="200" height="200">
                                </div>
                                <div class="media-body">
                                    <hr>
                                    <h3><strong>Opis</strong></h3>
                                    <p>{{$uData -> description}}</p>
                                    <div style="text-align: center; margin-top: 30px;"
                                         v-if="admin == {{Auth::user()->id}} || {{Auth::user()->role_id}} == 4">
                                        <p><a href="{{ url('/edytujGrupe') }}/{{$uData->id}}" class="btn btn-primary"
                                              role="button">Edytuj grupe</a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                    <div class="panel panel-primary index">
                        <div class="panel-body">
                            <div class="col-md-1 pull-right"
                                 v-if="admin == {{Auth::user()->id}} || {{Auth::user()->role_id }}== 4">
                                <span><a
                                            href="{{ url('/usunGrupe') }}/{{$uData->id}}"><i
                                                class="fa fa-trash-o text-primary"
                                                aria-hidden="true"></i></a></span>
                            </div>


                            <h1 class="panel-title pull-left group-name">{{ucwords($uData->name)}}</h1>

                            <div style="margin-top: 50px">
                                @foreach($uData->user as $user)
                                    @if($user->id == Auth::user()->id)
                                        <span style="visibility: hidden;"> @{{ g = {!! $user->id !!} }}</span>
                                    @endif
                                @endforeach
                                @if(count($uData->user) == 0)
                                    <div class="caption form-inline">
                                        <a @click="joinToGroup({{$uData->id}})" class="btn btn-success">Dołącz</a>
                                    </div>
                                @else
                                    <div class="caption form-inline" v-if="g != {{Auth::user()->id}}">
                                        <a @click="joinToGroup({{$uData->id}})" class="btn btn-success">Dołącz</a>
                                    </div>
                                    <div class="caption form-inline" v-else>
                                        <a @click="leaveGroup(g,{{$uData->id}})" class="btn btn-danger ">Odejdź</a>
                                    </div>
                                @endif
                            </div>
                            <div
                                    v-if="admin != {{Auth::user()->id}} ">
                                <div class="pull-right">
                                <span>
                        <a href="{{ url('/zglosGrupe') }}/{{$uData->id}}" class="btn btn-link"
                           style="text-decoration:none;"><i class="fa fa-md fa-exclamation-triangle" aria-hidden="true"
                                                            data-toggle="tooltip" data-placement="bottom"
                                                            title="Zgłoś"></i></a>
                    </span>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
        <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12 pull-right">
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#posty" aria-controls="posty" role="tab"
                                                          data-toggle="tab"><i class="fa fa-fw fa-files-o"
                                                                               aria-hidden="true"></i>Posty</a></li>
                <li @click="groupMembers({{$uData->id}})" role="presentation"><a href="#czlonkowie"
                                                                                 aria-controls="czlonkowie" role="tab"
                                                                                 data-toggle="tab"><i
                                class="fa fa-fw fa-users"
                                aria-hidden="true"></i>Członkowie <span
                                class="badge">{{count($uData->user)}}</span></a></li>
            </ul>
            <div class="tab-content  ">
                <div role="tabpanel" class="tab-pane  index group active" id="posty">
                    @foreach($uData->user as $user)
                        @if($user->id == Auth::user()->id)
                            <span style="visibility: hidden"> @{{ g = {!! $user->id !!} }}</span>
                        @endif
                    @endforeach
                    <div class="panel panel-primary group-index"
                         v-if="g == {{Auth::user()->id}}">
                        <div class="panel-body group-body">
                            <div class="col-xs-12">
                                <form method="post" enctype="multipart/form-data"
                                      v-on:submit.prevent="addPostGroup({{$uData->id}})">
                                <textarea placeholder="Dodaj post..." v-model="content" rows="5"
                                          style="min-width: 100%"></textarea><br><br>
                                    <input type="submit" class="btn btn-success pull-right" value="Udostępnij">
                                </form>
                            </div>
                        </div>
                    </div>
                    <div v-for="post in posts" v-if="g == {{Auth::user()->id}}">
                        <div v-if="post.group_id == {{$uData ->id}}">
                            <div class="panel panel-primary index">
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
                                            <div class="dropdown-service">
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
                                       style="cursor: pointer;margin-right:20px;"
                                       :data-target="'#comments' + post.id">Pokaż komentarze</a><i
                                            class="fa fa-comment text-primary" aria-hidden="true">@{{
                                        post.comments.length }}</i>
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
                                                        <div class="panel panel-primary arrow left">
                                                            <div class="panel-body">
                                                                <header class="text-left">
                                                                    <time class="comment-date"><i
                                                                                class="fa fa-clock-o"></i>@{{
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
                                                                                        <figure class="thumbnail ">
                                                                                            <a :href="'{{Config::get('url')}}/profil/' + answer.user.slug"><img
                                                                                                        :src="'{{Config::get('url')}}' + answer.user.pic"
                                                                                                        class="img-circle"
                                                                                                        :alt="answer.user.name"
                                                                                                        width="50"
                                                                                                        height="50"/></a>
                                                                                            <figcaption
                                                                                                    class="text-center">
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
                                                                                                        answer.created_at
                                                                                                        |
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
                                                                                                        @{{
                                                                                                        answer.answer }}
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
                <div role="tabpanel" class="tab-pane index" id="czlonkowie" >
                    <div v-if="g == {{Auth::user()->id}}">
                        <div v-for="mem in members">
                            <div v-for="uList in mem" class="panel panel-primary">
                                <div class="panel-body">
                                    <div class="col-md-8">
                                        <div class="col-md-3">
                                            <a :href="'{{Config::get('url')}}/profil/' + uList.slug"><img
                                                        :src="'{{Config::get('url')}}' + uList.pic" class="img-circle"
                                                        :alt="uList.name" width="65" height="65"/></a>
                                        </div>
                                        <div class="col-md-5">
                                            <a :href="'{{Config::get('url')}}/profil/' + uList.slug"><h4>
                                                    @{{uList.name}}</h4>
                                            </a>
                                            <p>@{{uList.city}}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-4" v-if="{{Auth::user()->id}} != uList.id">
                                        <div v-for="check in checks" style="visibility: hidden">
                                            <div v-if="check.user_requested == uList.id && check.status == 0 ">
                                                @{{ c = uList.id }}
                                            </div>
                                            <div v-else-if="check.user_requested == uList.id && check.status == 1 || check.requester == uList.id && check.status == 1 ">
                                                @{{ b = uList.id }}
                                            </div>
                                        </div>
                                        <div>
                                            <div v-if="c != uList.id && b != uList.id">
                                                <a @click="addFriends(uList.id)"
                                                   class="btn btn-success btn-sm" style="width: 150px">Dodaj do
                                                    znajomych</a>
                                            </div>
                                            <div v-else-if="b == uList.id && c != uList.id">
                                                <a @click="deleteFromFriends(uList.id)" class="btn btn-danger btn-sm"
                                                   style="width: 150px">Usuń ze
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
            </div>
        </div>
        @endforeach
    </div>
    <!-- Scripts -->
    <script src="{{ asset('js/groupIndex.js') }}"></script>
@endsection