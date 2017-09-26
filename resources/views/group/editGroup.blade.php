@extends('layouts.app')

@section('content')
    <div class="container">
        <div clas="row">
            @include('layouts.partials.sidebar')
            <div class="col-md-9">
                @foreach($groups as $group)
                    <div class="panel panel-primary">
                        <div class="panel-heading">{{ $group->name }}</div>
                        @if(session()->has('msg'))
                            <div class="alert alert-success">{{session()->get('msg')}}</div>
                        @endif
                        <div class="panel-body text-center">
                            <h3>Edytuj grupę</h3><br>
                            <img class="img-circle" src="{{ $group->pic }}" width="130" height="130"/><br>
                            <a href="{{url('/zmienZdjecieGrupy')}}/{{$group->id}}">Zmień avatar</a>
                            <br>
                            <hr>
                            <div class="form-group" style="width: 40% ; margin: 0 auto; ">
                                <form action="{{url('/aktualizujGrupe')}}" method="post">
                                    <label for="name">Nazwa</label>
                                    <input type="text" id="name" class="form-control" name="name"
                                           value="{{$group->name}}">
                                    <label for="description">Opis</label>
                                    <textarea type="text" id="description" class="form-control" name="description"
                                    >{{$group->description}}</textarea>
                                    <br>
                                    <input type="submit" value="Edytuj" class="btn btn-primary">
                                    <input type="hidden" name="id" value="{{$group->id}}">
                                    <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                                </form>
                            </div>

                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <script src="{{ asset('js/start.js') }}"></script>
@stop