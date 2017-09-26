@extends('layouts.app')

@section('content')
    <div class="container" id="group">
        <div clas="row">
            @include('layouts.partials.sidebar')
            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-body text-center">
                        @if(session()->has('msg'))
                            <div class="alert alert-success">{{session()->get('msg')}}</div>
                        @endif
                        <h3>Grupy</h3><br>
                        <div class="col-md-5 pull-left">
                            <input class="form-control" type="text" v-model="search" placeholder="Wyszukaj grupę">
                        </div>
                        <div class="caption form-inline">
                            <a :href="'{{Config::get('url')}}/utworzGrupe'" class="btn btn-primary pull-right"
                               style="margin-bottom:20px">Utwórz nową grupę</a>
                        </div>
                        <div v-for="group in filteredGroups">
                            <a :href="'{{Config::get('url')}}/grupa/' + group.slug">
                                <div class="thumbnail col-md-12">
                                    <img class="img-circle" :src="'{{Config::get('url')}}' + group.pic" width="60"
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
            </div>
        </div>
    </div>
    <!-- Scripts -->
    <script src="{{ asset('js/group.js') }}"></script>
@endsection