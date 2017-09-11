@extends('layouts.app')

@section('content')
    <div class="container" id="profile">
    <div class="row">
<div class="col-md-3 sidebar" style="border:solid #eeeeee 2px; margin:2px">
    <h3 align="center">Wiadomości <a href="{{url('/noweWiadomosci')}}"><img src="http://localhost:8000/img/new.png" title="Wyślij nową wiadomość" height="30" width="30"></a></h3>
    <hr>
    <ul v-for="privateMsg in privateMsgs" style="list-style-type: none;margin-top: 10px ; background: #F3F3F3;">
    <li @click="messages(privateMsg.id)">
        <img :src="'{{Config::get('url')}}' + privateMsg.pic" :alt="privateMsg.name" width="40" height="40" class="img-circle"/>
        @{{ privateMsg.name }}
    </li>
    </ul>
</div>
<div class="col-md-6 sidebar" style="border:solid #eeeeee 2px;margin:2px">
    <h3 align="center">Wiadomości</h3>
    <hr>
    <div v-for="singleMsg in singleMsgs">
        <div v-if="singleMsg.user_from == <?php echo Auth::user()->id; ?>">
            <div class="col-md-12" style="margin-top:10px">
                <img :src="'{{Config::get('url')}}' + singleMsg.pic"
                     style="width:30px; border-radius:100%; margin-left:5px" class="pull-right">
                <div style="float:right; background-color:#0084ff; padding:5px 15px 5px 15px;
          margin-right:10px;color:#333; border-radius:10px; color:#fff;" >
                    @{{singleMsg.msg}}
                </div>
            </div>
        </div>
        <div v-else>
            <div class="col-md-12 pull-right"  style="margin:10px">
                <img :src="'{{Config::get('url')}}' + singleMsg.pic"
                     style="width:30px; border-radius:100%; margin-left:5px" class="pull-left">
                <div style="float:left; background-color:#F0F0F0; padding: 5px 15px 5px 15px;
        border-radius:10px; text-align:right; margin-left:5px ">
                    @{{singleMsg.msg}}
                </div>

            </div>
        </div>
    </div>
    <input type="hidden" v-model="conID">
    <textarea class="col-md-12 form-control" v-model="msgForm" @keydown="inputHandler"
              style="margin-top:15px; margin-bottom: 20px; border:none"></textarea>
</div>

<div class="col-md-2 sidebar" style="border:solid #eeeeee 2px;margin:2px">
    <h3 align="center">right</h3>
    <hr>
</div>
    </div>
    </div>
@endsection