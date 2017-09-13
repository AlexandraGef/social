@extends('layouts.app')
@section('content')

<div class="container">

    <div class="row">
        @include('layouts.partials.sidebar')


        <div class="col-md-9">
            <div class="panel panel-default">
                <div class="panel-heading"><h4><span style="color:green">{{ucwords(Auth::user()->name)}}</span>, na tej stronie znajdują się oferty pracy, które mogą Cię zainteresować</h4></div>

                <div class="panel-body">
                         @if ( session()->has('msg') )
                         <p class="alert alert-success">
                                      {{ session()->get('msg') }}
                                   </p>
                                @endif

                             @foreach($jobs as $job)
                                 <div class="col-md-4">
                                 <div class="jobDiv  col-md-12" style="border:solid #eeeeee 1px; height: 400px; padding: 10px;">
                                     <a href="{{url('szczegolyOferty')}}/{{$job->id}}">
                                         <img src="{{Config::get('url')}}{{$job->pic}}" class="img-circle" width="50" height="50">
                                     </a>
                                     <br>
                                     <br>
                                     <a href="{{url('szczegolyOferty')}}/{{$job->id}}"><li style="list-style-type: none;"><i class="fa fa-briefcase " aria-hidden="true"></i>&nbsp{{ucwords($job->job_title)}}</li></a>

                                     <a href="{{url('szczegolyOferty')}}/{{$job->id}}"><li style="list-style-type: none;"><i class="fa fa-building-o" aria-hidden="true"></i>&nbsp{{ucwords($job->name)}}</li></a>

                             <h5>Wymagana znajomość:</h5>
                                     <li style="list-style-type: none;"> <?php $skills = explode(',',$job->skills)?>
                                         @foreach($skills as $skill)
                                             <div  style="background-color:#283E4A; color:#fff; margin-top:5px; border-radius:10px; width:100%; float:left; padding:3px 15px 3px 15px">{{$skill}}</div>

                                         @endforeach
                                         <a href="{{url('szczegolyOferty')}}/{{$job->id}}" style="margin-top:10px; width:100%;" class="btn btn-primary">Pokaż szczegóły</a>
                                     </li>
                                 </div>
                                 </div>
                             @endforeach

                </div>
                </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- Scripts -->
<script src="{{ asset('js/start.js') }}"></script>
@endsection
