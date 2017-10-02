@extends('layouts.app')

@section('content')
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
                        @if(session()->has('msg'))
                            <div class="alert alert-success">{{session()->get('msg')}}</div>
                        @endif
                        <div role="tabpanel" class="tab-pane active" id="grupy">
                            <div class="panel panel-primary">
                                <div class="panel-heading text-center panel-search" data-toggle="collapse"
                                     data-target="#search">Szukaj grupy
                                </div>
                                <div class="panel-collapse collapse" id="search">
                                    <input class="form-control" type="text" v-model="search" placeholder="Szukaj grupy">
                                </div>
                            </div>
                            <div v-for="group in filteredGroups">
                                <div v-for="us in group.user" style="visibility: hidden;height: 0">
                                    <div v-if="{{Auth::user()->id}} == us.id">
                                        @{{ g = group.id }}
                                    </div>
                                </div>
                                <div class="panel panel-primary" v-if="g == group.id">
                                    <div class="panel-body text-center" >
                                        <a :href="'{{Config::get('url')}}/grupa/' + group.slug">
                                            <div class="col-md-12">
                                                <div class="col-md-8">
                                                    <div class="col-md-3">
                                                        <img class="img-circle"
                                                             :src="'{{Config::get('url')}}' + group.pic"
                                                             width="60"
                                                             height="60"/>
                                                    </div>
                                                    <div class="col-md-5">
                                                        <h3>@{{ group.name }}</h3>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="caption form-inline">
                                                        <a @click="leaveGroup({{Auth::user()->id}},group.id)"
                                                           class="btn btn-danger btn-sm">Odejdź</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="mojegrupy">
                            <div class="panel ">
                                <a :href="'{{Config::get('url')}}/utworzGrupe'"
                                   class="btn btn-info"
                                >Utwórz nową grupę</a></div>
                            <div class="caption form-inline">
                                <div class="panel panel-primary">
                                    <div class="panel-heading text-center" data-toggle="collapse" style="cursor:pointer"
                                         data-target="#searchMy">Szukaj grupy
                                    </div>
                                    <div class="panel-collapse collapse" id="searchMy">
                                        <input style="width:100%" class="form-control" type="text" v-model="search"
                                               placeholder="Szukaj grupy">
                                    </div>
                                </div>
                                <div v-for="group in filteredGroups">
                                    <div v-for="ad in group.admins" style="visibility: hidden;height: 0px">
                                        <div v-if="ad.id == {{Auth::user()->id}}">
                                            @{{admin = group.id}}
                                        </div>
                                    </div>
                                    <div class="panel panel-primary" v-if="admin == group.id">
                                        <div class="panel-body text-center">
                                            <a :href="'{{Config::get('url')}}/grupa/' + group.slug">
                                                <div class="col-md-8">
                                                    <div class="col-md-3">
                                                        <img class="img-circle"
                                                             :src="'{{Config::get('url')}}' + group.pic"
                                                             width="65"
                                                             height="65"/>
                                                    </div>
                                                    <div class="col-md-5">
                                                        <h3>@{{ group.name }}</h3>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div v-for="us in group.user" style="visibility: hidden">
                                                        <div v-if="{{Auth::user()->id}} == us.id">
                                                            @{{ g = group.id }}
                                                        </div>
                                                    </div>
                                                    <div v-if="group.user.length == 0">
                                                        <div class="caption form-inline ">
                                                            <a @click="joinToGroup(group.id)"
                                                               class="btn btn-success">Dołącz</a>
                                                        </div>
                                                    </div>
                                                    <div v-else>
                                                        <div class="caption form-inline " v-if="g != group.id">
                                                            <a @click="joinToGroup(group.id)"
                                                               class="btn btn-success">Dołącz</a>
                                                        </div>
                                                        <div class="caption form-inline " v-else>
                                                            <a @click="leaveGroup({{Auth::user()->id}},group.id)"
                                                               class="btn btn-danger">Odejdź</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
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
    <script src="{{ asset('js/group.js') }}"></script>
@endsection