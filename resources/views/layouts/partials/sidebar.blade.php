<div class="col-md-3 left-sidebar">
    <div class="panel panel-default">
        <div class="panel-heading"></div>
        @if(Auth::check())
            <ul style="list-style-type: none" class="left">
                <li style="margin-top:10px">
                    <a href="{{ url('/profil') }}/{{Auth::user()->slug}}">
                        <img class="img-circle" src="{{Config::get('url')}}{{Auth::user()->pic}}"
                             width="32"/>
                        {{Auth::user()->name}}</a>
                    <hr>
                </li>
                <li>
                    <a href="{{url('/znajomi')}}"> <img src="{{Config::get('url')}}/img/friends.png"
                                                        width="32"/>
                        Znajomi </a>
                    <hr>
                </li>
                <li>
                    <a href="{{url('/home')}}"> <img src="{{Config::get('url')}}/img/news_feed.png"
                                                     width="32"/>
                        Tablica</a>
                    <hr>
                </li>
                <li>
                    <a href="{{url('/wiadomosci')}}"> <img src="{{Config::get('url')}}/img/msg.png"
                                                           width="32"/>
                        Wiadomości</a>
                    <hr>
                </li>

                <li>
                    <a href="{{url('/znajdzZnajomych')}}"> <img src="{{Config::get('url')}}/img/search.png"
                                                                width="32"/>
                        Poszukaj znajomych</a>
                    <hr>
                </li>

                <li>
                    <a href="{{url('/praca')}}"> <img src="{{Config::get('url')}}/img/jobs.png"
                                                      width="32"/>
                        Przeglądaj oferty pracy</a>
                    <hr>
                </li>
            </ul>

        @endif
    </div>
</div>