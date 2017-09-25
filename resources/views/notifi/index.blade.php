@extends('layouts.app')

@section('content')
    <style>
        .nav.nav-justified > li > a {
            position: relative;
        }

        .nav.nav-justified > li > a:hover,
        .nav.nav-justified > li > a:focus {
            background-color: transparent;
        }

        .nav.nav-justified > li > a > .quote {
            position: absolute;
            right: 20px;
            bottom: 0;
            opacity: 0;
            width: 30px;
            height: 30px;
            padding: 5px;
            background-color: #E95420;
            border-radius: 15px;
            color: #fff;
        }

        .nav.nav-justified > li.active > a > .quote {
            opacity: 1;
        }

        .nav.nav-justified > li > a > img {
            box-shadow: 0 0 0 5px #E95420;
        }

        .nav.nav-justified > li > a > img {
            max-width: 150px;
            min-height:90px;
            opacity: .3;
            -webkit-transform: scale(.8, .8);
            transform: scale(.8, .8);
            -webkit-transition: all 0.3s 0s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            transition: all 0.3s 0s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .nav.nav-justified > li.active > a > img,
        .nav.nav-justified > li:hover > a > img,
        .nav.nav-justified > li:focus > a > img {
            opacity: 1;
            -webkit-transform: none;
            transform: none;
            -webkit-transition: all 0.3s 0s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            transition: all 0.3s 0s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .tab-pane .tab-inner {
            padding: 30px 0 20px;
        }
    </style>
    <div class="container" id="notifi">
        <div class="row">
            @include('layouts.partials.sidebar')
            <div class="col-md-9" role="tabpanel">
                <!-- Nav tabs -->
                <ul class="nav nav-justified" id="nav-tabs" role="tablist">
                    <li role="presentation" class="active">
                        <a href="#profil" aria-controls="profil" role="tab" data-toggle="tab">
                            <img class="img-circle" src="http://localhost:8000/img/profile.png" alt="profile"/>
                        </a>
                    </li>
                    <li role="presentation">
                        <a href="#grupy" aria-controls="grupy" role="tab" data-toggle="tab">
                            <img class="img-circle" src="http://localhost:8000/img/grupy.png" alt="grupy"/>
                        </a>
                    </li>
                    <li role="presentation">
                        <a href="#posty" aria-controls="posty" role="tab" data-toggle="tab">
                            <img class="img-circle" src="http://localhost:8000/img/posty.png" alt="posty"/>
                        </a>
                    </li>
                    <li role="presentation">
                        <a href="#komentarze" aria-controls="komentarze" role="tab" data-toggle="tab">
                            <img class="img-circle" src="http://localhost:8000/img/komentarze.png" alt="kometarze"/>
                        </a>
                    </li>
                    <li role="presentation">
                        <a href="#odpowiedzi" aria-controls="odpowiedzi" role="tab" data-toggle="tab">
                            <img class="img-circle" src="http://localhost:8000/img/odpowiedzi.png" alt="odpowiedzi"/>
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
                                        <div class="panel panel-default" style="border: solid 2px #E95420">
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