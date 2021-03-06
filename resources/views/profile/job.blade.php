@extends('layouts.app')

@section('content')

    <div class="container">

        <div class="row">
            @include('layouts.partials.sidebar')


            <div class="col-md-9">
                <div class="panel panel-primary">
                    <div class="panel-heading">{{ucwords(Auth::user()->name)}}, może zainteresujesz sie tą ofertą pracy
                        <a style="color:white" class="pull-right" href="{{url('praca')}}">Wszystkie oferty pracy</a>
                    </div>

                    <div class="panel-body">
                        <div class="col-sm-12 col-md-12 jobDetails">
                            @if ( session()->has('msg') )
                                <p class="alert alert-success">
                                    {{ session()->get('msg') }}
                                </p>
                            @endif
                            @foreach($jobs as $job)
                                <div style="border: solid #E95420 2px; color: #772953; text-algin:center">
                                    <h4 style=" text-align:center">
                                        <b>{{ucwords($job->name)}}</b> potrzebuje <b>{{$job->job_title}}</b>
                                    </h4>
                                </div>
                                <br>
                                <div class="row job_company">
                                    <a href="{{ url('/profil') }}/{{$job->slug}}">
                                        <div class="col-md-2 pull-left">
                                            <img src="{{Config::get('url')}}{{$job->pic}}" class="img-rounded"
                                                 style="width:100px; height:100px; margin:5px; border:1px solid #772953; padding:5px">
                                        </div>

                                        <div class="col-md-10 pull-left">
                                            <h2 style="color:#772953">
                                                {{ucwords($job->name)}}</h2>
                                            <small>{{$job->email}}</small>
                                        </div>
                                    </a>
                                </div>
                                <hr>
                                <div class="col-md-12">
                                    <h3 class="job_point" style="color:#772953">
                                        Wymagania: </h3>
                                    <p>{{$job->requirements}}</p>
                                </div>

                                <div class="col-md-12">
                                    <h3 class="job_point" style="color:#772953">
                                        Umiejętności: </h3>
                                    <p>{{$job->skills}}</p>
                                </div>

                                <div class="col-md-12">
                                    <h3 class="job_point" style="color:#772953">
                                        Kontakt: </h3>
                                    <p>Prosimy o wysyłanie CV na adres mailowy:
                                        <a href="mailto:{{$job->contact_email}}" class="email_link"
                                           style="border:solid #772953 1px; padding:5px">{{$job->contact_email}}</a></p>
                                </div>
                        </div>
                        @endforeach
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- Scripts -->
    <script src="{{ asset('js/start.js') }}"></script>
@endsection
