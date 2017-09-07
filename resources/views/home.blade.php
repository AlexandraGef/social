@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @include('layouts.partials.sidebar')
            <div class="col-md-9">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                        <div class="panel panel-default">
                            <div class="panel-heading">Najnowsze posty</div>

                            <div class="panel-body">
@foreach($posts as $post)
                                    <div class="col-md-12" style="margin-bottom:15px; border-bottom: 1px solid #bdbdbd">
                                        <div class="col-md-2 pull-left" style="margin-bottom: 10px;">
                                            <a href="{{ url('/profil') }}/{{$post->slug}}"><img src="{{$post->pic}}" alt="{{$post->name}}" width="90" height="90"/></a>
                                        </div>
                                        <div class="col-md-10 ">
                                            <h3><a href="{{ url('/profil') }}/{{$post->slug}}">{{$post->name}}</a></h3>
                                        </div>
                                        <p class="col-md-12">{{$post->content}}
                                        </p>
                                    </div>

@endforeach
                            </div>
                        </div>
            </div>
        </div>
    </div>






@endsection
