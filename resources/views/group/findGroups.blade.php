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
    <div class="container" id="group">
        <div clas="row">
            @include('layouts.partials.sidebar')
            <div class="col-md-9">
                <!-- Nav tabs -->
                <div class="card">
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#grupy" aria-controls="grupy" role="tab"
                                                                  data-toggle="tab">Grupy</a></li>
                        <li role="presentation"><a href="#mojegrupy" aria-controls="mojegrupy" role="tab"
                                                   data-toggle="tab">Moje grupy</a></li>
                    </ul>

                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="grupy">
                            <div class="panel panel-primary">
                                @if(session()->has('msg'))
                                    <div class="alert alert-success">{{session()->get('msg')}}</div>
                                @endif
                                <div class="panel-heading text-center" data-toggle="collapse" style="cursor:pointer"
                                     data-target="#search">Szukaj grupy
                                </div>
                                <div class="panel-collapse collapse" id="search">
                                    <input class="form-control" type="text" v-model="search" placeholder="Szukaj grupy">
                                </div>
                            </div>
                            <div class="panel panel-primary" v-for="group in filteredGroups">
                                <div class="panel-body text-center">
                                    <a :href="'{{Config::get('url')}}/grupa/' + group.slug">
                                        <div class="col-md-12">
                                            <img class="img-circle" :src="'{{Config::get('url')}}' + group.pic"
                                                 width="60"
                                                 height="60"/>
                                            <h3>@{{ group.name }}</h3>
                                            <div v-for="us in group.user" style="visibility: hidden">
                                                <div v-if="{{Auth::user()->id}} == us.id">
                                                    @{{ g = group.id }}
                                                </div>
                                            </div>
                                            <div v-if="group.user.length == 0">
                                                <div class="caption form-inline">
                                                    <a @click="joinToGroup(group.id)" class="btn btn-success">Dołącz</a>
                                                </div>
                                            </div>
                                            <div v-else>
                                                <div class="caption form-inline" v-if="g != group.id">
                                                    <a @click="joinToGroup(group.id)" class="btn btn-success">Dołącz</a>
                                                </div>
                                                <div class="caption form-inline" v-else>
                                                    <a @click="leaveGroup({{Auth::user()->id}},group.id)"
                                                       class="btn btn-danger">Odejdź</a>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>


                        <div role="tabpanel" class="tab-pane" id="mojegrupy">
                            <div class="caption form-inline" >
                                <a :href="'{{Config::get('url')}}/utworzGrupe'"
                                   class="btn btn-primary pull-right"
                                   style="margin-bottom:20px">Utwórz nową grupę</a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>


    <!-- Scripts -->
    <script src="{{ asset('js/group.js') }}"></script>
@endsection