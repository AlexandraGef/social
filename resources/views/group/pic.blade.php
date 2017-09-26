@extends('layouts.app')

@section('content')
    <div class="container">
        <div clas="row">
            @include('layouts.partials.sidebar')
            <div class="col-md-9">
                @foreach($groups as $group)
                    <div class="panel panel-primary">
                        <div class="panel-heading">{{ $group->name }}</div>
                        <div class="panel-body text-center">
                            @if(session()->has('msg'))
                                <div class="alert alert-success">{{session()->get('msg')}}</div>
                            @endif
                            <h3>Zmień avatar grupy</h3><br>
                            <img class="img-circle" src="{{ $group->pic }}" width="130" height="130"/>
                            <br><br>
                            <hr>
                            <form action="{{url('/wgrajAvatarGrupy')}}" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                                <input type="hidden" name="id" value="{{$group->id}}">
                                <input type="file" name="pic" class="btn btn-primary center-block"/>
                                <br>
                                <input type="submit" class="btn btn-success" name="btn" value="Wgraj avatar"/>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- Scripts -->
    <script src="{{ asset('js/start.js') }}"></script>
@stop