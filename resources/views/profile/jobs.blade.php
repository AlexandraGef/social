@extends('layouts.app')
@section('content')

<div class="container" id="search">

    <div class="row">
        @include('layouts.partials.sidebar')


        <div class="col-md-9" >
            <div class="panel panel-default">
                <div class="panel-heading"><h4><span style="color:green">{{ucwords(Auth::user()->name)}}</span>, na tej stronie znajdują się oferty pracy, które mogą Cię zainteresować</h4></div>
                <input class="form-control " type="text" v-model="search" placeholder="Szukaj ofert pracy">
                <div class="panel-body">
                         @if ( session()->has('msg') )
                         <p class="alert alert-success">
                                      {{ session()->get('msg') }}
                                   </p>
                                @endif

                           <div v-for="job in jobs">
                                 <div class="col-md-4">
                                 <div class="jobDiv  col-md-12" style="border:solid #eeeeee 1px; height: 400px; padding: 10px;">
                                         <a :href="'{{Config::get('url')}}/szczegolyOferty/' + job.id"><img :src="'{{Config::get('url')}}' + job.pic" class="img-circle" :alt="job.job_title" width="50" height="50"/></a>
                                     <br>
                                     <br>
                                     <a :href="'{{Config::get('url')}}/szczegolyOferty/' + job.id"><li style="list-style-type: none;"><i class="fa fa-briefcase " aria-hidden="true"></i>&nbsp@{{ucwords(job.job_title)}}</li></a>

                                     <a :href="'{{Config::get('url')}}/szczegolyOferty/' + job.id"><li style="list-style-type: none;"><i class="fa fa-building-o" aria-hidden="true"></i>&nbsp@{{ucwords(job.name)}}</li></a>

                             <h5>Wymagana znajomość:</h5>

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
<script src="{{ asset('js/search.js') }}"></script>
@endsection
