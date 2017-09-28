@extends('layouts.app')
@section('content')

    <div class="container" id="searchJobs">

        <div class="row">
            @include('layouts.partials.sidebar')


            <div class="col-md-9">
                <div class="panel panel-primary">
                    <div class="panel-heading"><h4><span style="color:#772953">{{ucwords(Auth::user()->name)}}</span>, na
                            tej stronie znajdują się oferty pracy, które mogą Cię zainteresować</h4></div>
                    <div class="col-md-12">
                        <div class="col-md-5 pull-right" style="margin: 20px">
                            <input class="form-control" type="text" v-model="search" placeholder="Szukaj ofert pracy">
                        </div>
                    </div>
                    <hr>
                    <div class="panel-body">
                        @if ( session()->has('msg') )
                            <p class="alert alert-success">
                                {{ session()->get('msg') }}
                            </p>
                        @endif

                        <div v-for="job in filteredJobs" div class="col-md-4 ">
                            <div class="col-md-12 panel panel-primary">
                                <div style="height: 400px; padding: 10px">
                                    <a :href="'{{Config::get('url')}}/szczegolyOferty/' + job.id"><img
                                                :src="'{{Config::get('url')}}' + job.pic" class="img-circle"
                                                :alt="job.job_title" width="50" height="50"/></a>
                                    <br>
                                    <br>
                                    <a :href="'{{Config::get('url')}}/szczegolyOferty/' + job.id">
                                        <li style="list-style-type: none;"><i class="fa fa-briefcase "
                                                                              aria-hidden="true"></i>&nbsp@{{job.job_title}}
                                        </li>
                                    </a>

                                    <a :href="'{{Config::get('url')}}/szczegolyOferty/' + job.id">
                                        <li style="list-style-type: none;"><i class="fa fa-building-o"
                                                                              aria-hidden="true"></i>&nbsp@{{job.name}}
                                        </li>
                                    </a>

                                    <h5>Wymagana znajomość:</h5>
                                    <li style="list-style-type: none;"> <?php $skills = explode(',', "{{job.skills}}")?>
                                        @foreach($skills as $skill)
                                            <div style="background-color:#772953; color:#fff; margin-top:5px; border-radius:10px; width:100%; float:left; padding:3px 15px 3px 15px">{{$skill}}</div>

                                        @endforeach
                                        <a :href="'{{Config::get('url')}}/szczegolyOferty/' + job.id"
                                           style="margin-top:10px; width:100%;" class="btn btn-primary">Pokaż
                                            szczegóły</a>
                                    </li>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/searchJobs.js') }}"></script>
@endsection
