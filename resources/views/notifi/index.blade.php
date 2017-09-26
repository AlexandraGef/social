@extends('layouts.app')

@section('content')
    <style>
        .nav-tabs {
            border-bottom: 2px solid #DDD;
        }

        .nav-tabs > li.active > a, .nav-tabs > li.active > a:focus, .nav-tabs > li.active > a:hover {
            border-width: 0;
        }

        .nav-tabs > li > a {
            border: none;
            color: #666;
        }

        .nav-tabs > li.active > a, .nav-tabs > li > a:hover {
            border: none;
            color: #E95420 !important;
            background: transparent;
        }

        .nav-tabs > li > a::after {
            content: "";
            background: #E95420;
            height: 2px;
            position: absolute;
            width: 100%;
            left: 0px;
            bottom: -1px;
            transition: all 250ms ease 0s;
            transform: scale(0);
        }

        .nav-tabs > li.active > a::after, .nav-tabs > li:hover > a::after {
            transform: scale(1);
        }

        .tab-nav > li > a::after {
            background: #E95420 none repeat scroll 0% 0%;
            color: #fff;
        }

        .tab-pane {
            padding: 15px 0;
        }

        .tab-content {
            padding: 20px
        }
    </style>
    <div class="container" id="notifi">
        <div class="row">
            @include('layouts.partials.sidebar')
            <div class="col-md-9" role="tabpanel">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" id="nav-tabs" role="tablist">
                    <li role="presentation" class="active">
                        <a href="#profil" aria-controls="profil" role="tab" data-toggle="tab">
                           Profile
                        </a>
                    </li>
                    <li role="presentation">
                        <a href="#grupy" aria-controls="grupy" role="tab" data-toggle="tab">
                            Grupy
                        </a>
                    </li>
                    <li role="presentation">
                        <a href="#posty" aria-controls="posty" role="tab" data-toggle="tab">
                          Posty
                        </a>
                    </li>
                    <li role="presentation">
                        <a href="#komentarze" aria-controls="komentarze" role="tab" data-toggle="tab">
                           Komentarze
                        </a>
                    </li>
                    <li role="presentation">
                        <a href="#odpowiedzi" aria-controls="odpowiedzi" role="tab" data-toggle="tab">
                            Odpowiedzi
                        </a>
                    </li>
                </ul>

                <!-- Tab panes -->

                <div class="tab-content" id="tabs-collapse">
                    <div role="tabpanel" class="tab-pane fade in active" id="profil">
                        <div class="tab-inner">
                            <div class="alert alert-success" v-if="seen">
                                @{{ msg }}
                            </div>
                            <div v-for="service in services">
                                <div v-if="service.profile != null">
                                    <div class="col-md-12">
                                        <div class="panel panel-default" style="border: solid 2px #E95420">
                                            <div
                                                    style="cursor: pointer" class="text-right text-danger" @click="deleteNoti(service.id)"><a><i
                                                            class="fa fa-trash-o text-danger"
                                                            aria-hidden="true"></i></a>Usuń zgłoszenie</div>
                                            <div class="panel-body text-center">
                                                <h3 style="cursor:pointer" data-toggle="collapse"
                                                    :data-target="'#profile' + service.profile.id">Zgłoszony profil:
                                                    <a class="text-danger"
                                                       :href="'{{Config::get('url')}}/profil/' + service.profile.user.slug">@{{
                                                        service.profile.user.name }}</a></h3>
                                                <div v-bind:id="['profile'+ service.profile.id]"
                                                     class="panel-collapse collapse">
                                                    <hr>
                                                    <span>Zgłoszenie od użytkownika: <a
                                                                :href="'{{Config::get('url')}}/profil/' + service.user.slug">@{{ service.user.name }}</a></span>
                                                    <hr>

                                                    <span>Zgłoszenie dodane: <time>@{{service.created_at | myOwnTime }}</time></span><br><br>
                                                    <h4>Treść zgłoszenia:<br> @{{ service.excuse }}</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="grupy">
                        <div class="tab-inner">
                            <div class="alert alert-success" v-if="seen">
                                @{{ msg }}
                            </div>
                            <div v-for="service in services">
                                <div v-if="service.group != null">
                                    <div class="col-md-12">
                                        <div class="panel panel-default" style="border: solid 2px #E95420">
                                            <div
                                                    style="cursor: pointer" class="text-right text-danger"><a @click="deleteNoti(service.id)"><i
                                                            class="fa fa-trash-o text-danger"
                                                            aria-hidden="true"></i></a>Usuń zgłoszenie</div>
                                            <div class="panel-body text-center">
                                                <h3 style="cursor:pointer" data-toggle="collapse"
                                                    :data-target="'#group' + service.group.id">Zgłoszona grupa:
                                                    <a class="text-danger"
                                                       :href="'{{Config::get('url')}}/grupa/' + service.group.slug">@{{
                                                        service.group.name }}</a></h3>
                                                <div v-bind:id="['group'+ service.group.id]"
                                                     class="panel-collapse collapse">
                                                    <hr>
                                                    <span>Zgłoszenie od użytkownika: <a
                                                                :href="'{{Config::get('url')}}/grupa/' + service.user.slug">@{{ service.user.name }}</a></span>
                                                    <hr>

                                                    <span>Zgłoszenie dodane: <time>@{{service.created_at | myOwnTime }}</time></span><br><br>
                                                    <h4>Treść zgłoszenia:<br> @{{ service.excuse }}</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="posty">
                        <div class="tab-inner">
                            <div class="alert alert-success" v-if="seenPost">
                                @{{ msgPost }}
                            </div>
                            <div class="alert alert-success" v-if="seen">
                                @{{ msg }}
                            </div>
                            <div v-for="service in services">
                                <div v-if="service.post != null">
                                    <div class="col-md-12">
                                        <div class="panel panel-primary" style="border: solid 2px #E95420">
                                            <div
                                                    style="cursor: pointer" class="text-right text-danger"><a @click="deleteNoti(service.id)"><i
                                                            class="fa fa-trash-o text-danger"
                                                            aria-hidden="true"></i></a>Usuń zgłoszenie</div>
                                            <div class="panel-body text-center">
                                                <h3 style="cursor:pointer" data-toggle="collapse"
                                                    :data-target="'#post' + service.post.id">Zgłoszony post użytkownika:
                                                    <a class="text-danger"
                                                       :href="'{{Config::get('url')}}/profil/' + service.post.user.slug">@{{
                                                        service.post.user.name }}</a></h3>
                                                <div v-bind:id="['post'+ service.post.id]"
                                                     class="panel-collapse collapse">
                                                    <hr>
                                                    <span>Zgłoszenie od użytkownika: <a
                                                                :href="'{{Config::get('url')}}/profil/' + service.user.slug">@{{ service.user.name }}</a></span>
                                                    <hr>

                                                    <span>Zgłoszenie dodane: <time>@{{service.created_at | myOwnTime }}</time></span><br><br>
                                                    <h4>Treść zgłoszenia:<br> @{{ service.excuse }}</h4>
                                                    <hr>
                                                    <div>
                                                        <h4>Treść postu:
                                                            <div
                                                                    style="cursor: pointer" class="text-right"><h5><a @click="deletePost(service.post.id)"><i
                                                                            class="fa fa-trash-o text-primary"
                                                                            aria-hidden="true"></i>Usuń post</a></h5></div>
                                                        </h4>
                                                    </div>
                                                    <div class="col-md-12 text-danger"><h4>@{{ service.post.content }}</h4></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="komentarze">
                        <div class="tab-inner">
                            <div class="alert alert-success" v-if="seenCom">
                                @{{ msgCom }}
                            </div>
                            <div class="alert alert-success" v-if="seen">
                                @{{ msg }}
                            </div>
                            <div v-for="service in services">
                                <div v-if="service.comment != null">
                                    <div class="col-md-12">
                                        <div class="panel panel-default" style="border: solid 2px #E95420">
                                            <div
                                                    style="cursor: pointer" class="text-right text-danger"><a @click="deleteNoti(service.id)"><i
                                                            class="fa fa-trash-o text-danger"
                                                            aria-hidden="true"></i></a>Usuń zgłoszenie</div>
                                            <div class="panel-body text-center">
                                                <h3 style="cursor:pointer" data-toggle="collapse"
                                                    :data-target="'#comment' + service.comment.id">Zgłoszony komentarz użytkownika:
                                                    <a class="text-danger"
                                                       :href="'{{Config::get('url')}}/profil/' + service.comment.user.slug">@{{
                                                        service.comment.user.name }}</a></h3>
                                                <div v-bind:id="['comment'+ service.comment.id]"
                                                     class="panel-collapse collapse">
                                                    <hr>
                                                    <span>Zgłoszenie od użytkownika: <a
                                                                :href="'{{Config::get('url')}}/profil/' + service.user.slug">@{{ service.user.name }}</a></span>
                                                    <hr>

                                                    <span>Zgłoszenie dodane: <time>@{{service.created_at | myOwnTime }}</time></span><br><br>
                                                    <h4>Treść zgłoszenia:<br> @{{ service.excuse }}</h4>
                                                    <hr>
                                                    <div>
                                                        <h4>Treść komentarza:
                                                            <div
                                                                    style="cursor: pointer" class="text-right"><h5><a @click="deleteComment(service.comment.id)"><i
                                                                            class="fa fa-trash-o text-primary"
                                                                            aria-hidden="true"></i>Usuń komentarz</a></h5></div>
                                                        </h4>
                                                    </div>
                                                    <div class="col-md-12 text-danger"><h4>@{{ service.comment.comment }}</h4></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="odpowiedzi">
                        <div class="tab-inner">
                            <div class="alert alert-success" v-if="seenAns">
                                @{{ msgAns }}
                            </div>
                            <div class="alert alert-success" v-if="seen">
                                @{{ msg }}
                            </div>
                            <div v-for="service in services">
                                <div v-if="service.answer != null">
                                    <div class="col-md-12">
                                        <div class="panel panel-default" style="border: solid 2px #E95420">
                                            <div
                                                    style="cursor: pointer" class="text-right text-danger"><a @click="deleteNoti(service.id)"><i
                                                            class="fa fa-trash-o text-danger"
                                                            aria-hidden="true"></i></a>Usuń zgłoszenie</div>
                                            <div class="panel-body text-center">
                                                <h3 style="cursor:pointer" data-toggle="collapse"
                                                    :data-target="'#answer' + service.answer.id">Zgłoszona odpowiedź na komentarz użytkownika:
                                                    <a class="text-danger"
                                                       :href="'{{Config::get('url')}}/profil/' + service.answer.user.slug">@{{
                                                        service.answer.user.name }}</a></h3>
                                                <div v-bind:id="['answer'+ service.answer.id]"
                                                     class="panel-collapse collapse">
                                                    <hr>
                                                    <span>Zgłoszenie od użytkownika: <a
                                                                :href="'{{Config::get('url')}}profil/' + service.user.slug">@{{ service.user.name }}</a></span>
                                                    <hr>

                                                    <span>Zgłoszenie dodane: <time>@{{service.created_at | myOwnTime }}</time></span><br><br>
                                                    <h4>Treść zgłoszenia:<br> @{{ service.excuse }}</h4>
                                                    <hr>
                                                    <div>
                                                        <h4>Treść odpowiedzi:
                                                            <div
                                                                    style="cursor: pointer" class="text-right"><h5><a @click="deleteAnswer(service.answer.id)"><i
                                                                            class="fa fa-trash-o text-primary"
                                                                            aria-hidden="true"></i>Usuń odpowiedź</a></h5></div>
                                                        </h4>
                                                    </div>
                                                    <div class="col-md-12 text-danger"><h4>@{{ service.answer.answer }}</h4></div>
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
        </div>
    </div>


    <!-- Scripts -->
    <script src="{{ asset('js/notifi.js') }}"></script>
@endsection