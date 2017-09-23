@extends('layouts.app')

@section('content')

    <div class="col-md-12 msgDiv" id="profile">

        <div style="background-color:#fff" class="col-md-3 pull-left">

            <div class="row" style="padding:10px">

                <div class="col-md-7">Lista znajomych</div>
                <div class="col-md-5 pull-right">
                    <a href="{{url('/wiadomosci')}}" class="btn btn-sm btn-info">Wszystkie wiadomości</a>
                </div>
            </div>

            @foreach($friends as $friend)
                <li @click="friendID({{$friend->id}})" v-on:click="seen = true" style="list-style:none;
    margin-top:10px; background-color:#F3F3F3" class="row">

                    <div class="col-md-3 pull-left">
                        <img src="{{Config::get('url')}}{{$friend->pic}}"
                             style="width:50px; border-radius:100%; margin:5px">
                    </div>

                    <div class="col-md-9 pull-left" style="margin-top:5px">
                        <b> {{$friend->name}}</b><br>
                    </div>
                </li>
            @endforeach
            <hr>
        </div>
        <div style="background-color:#fff; min-height:600px; border-left:5px solid #F5F8FA"
             class="col-md-8">
            <h3 align="center">Wiadomości</h3>
            <p class="alert alert-success">@{{msg}}</p>
            <div v-if="seen">
                <input type="hidden" v-model="friend_id">
                <textarea class="col-md-12 form-control" v-model="newMsgFrom"></textarea><br>
                <input type="button" style="margin-top: 15px;" class=" btn btn-primary" value="Wyślij"
                       @click="sendNewMsg()">
            </div>
        </div>
    </div>

    <script src="{{ asset('js/profile.js') }}"></script>
@endsection