@extends('layouts.app')

@section('content')
    <div class="container" id="profile">
    <div class="row">
<div class="col-md-3 sidebar" style="border:solid #eeeeee 2px; margin:2px">
    <h3 align="center">Użytkownicy</h3>
    <hr>
    <ul v-for="privateMsg in privateMsgs" style="list-style-type: none;margin-top: 10px ; background: #F3F3F3;">
    <li @click="messages(privateMsg.id)">
        <img :src="'{{Config::get('url')}}' + privateMsg.pic" :alt="privateMsg.name" width="40" height="40" class="img-circle"/>
        @{{ privateMsg.name }}
        <p>tresc wiadomosci</p>

    </li>
    </ul>
</div>
<div class="col-md-6 sidebar" style="border:solid #eeeeee 2px;margin:2px">
    <h3 align="center">Wiadomości</h3>
    <hr>
    <div v-for="singleMsg in singleMsgs">
        <div v-if="singleMsg.user_from == <?php echo Auth::user()->id; ?>">
        <div style="background: lightpink; float:right; padding: 10px; margin:15px;
        text-align: right; border-radius: 10px" class="col-md-7">
        @{{ singleMsg.user_from}} <br> @{{ singleMsg.msg }}
        </div>
        </div>
        <div v-else>
            <div style="background-color: #5e5e5e; float:left; padding: 10px; margin:15px;
        text-align: left; color: white; border-radius: 10px" class="col-md-7">
                @{{ singleMsg.user_from}} <br> @{{ singleMsg.msg }}
            </div>
        </div>
    </div>
</div>
<div class="col-md-2 sidebar" style="border:solid #eeeeee 2px;margin:2px">
    <h3 align="center">right</h3>
    <hr>
</div>
    </div>
    </div>
@endsection