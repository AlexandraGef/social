@if(Auth::check())
    <div class="col-lg-3 col-md-3 hidden-sm hidden-xs">
        <div class="list-group" style="text-align: center">
            <a class="list-group-item active" href="{{ url('/profil') }}/{{Auth::user()->slug}}">
                <img class="img-circle" src="{{Config::get('url')}}{{Auth::user()->pic}}"
                     width="32"/>
                {{Auth::user()->name}}</a>
            <a class="list-group-item" href="{{url('/home')}}"> <img src="{{Config::get('url')}}/img/news_feed.png"
                                                                     width="32"/>
                Tablica</a>
            <a class="list-group-item" href="{{url('/grupy')}}"> <img src="{{Config::get('url')}}/img/group.png"
                                                                     width="32"/>
                Grupy</a>
            <a class="list-group-item" href="{{url('/znajomi')}}"> <img src="{{Config::get('url')}}/img/friends.png"
                                                                        width="32"/>
                Znajomi </a>
            <a class="list-group-item" href="{{url('/wiadomosci')}}"> <img src="{{Config::get('url')}}/img/msg.png"
                                                                           width="32"/>
                Wiadomości</a>
            <a class="list-group-item" href="{{url('/praca')}}"> <img src="{{Config::get('url')}}/img/jobs.png"
                                                                      width="32"/>
                Przeglądaj oferty pracy</a>
        </div>
    </div>

@endif

