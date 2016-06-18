<aside class="col-md-3">
    <div class="panel pad5" style="padding: 10px !important;">
        <h4 class="" style="margin:0 0 10px 0;border-bottom:2px dashed grey">Join Server <small>(using)</small></h4>

        <ul class="list-group">
            <li class="list-group-item">
                <span class="small tooltipster" title="~ join 81.4.127.91:10480"><kbd>ip</kbd> &nbsp;&nbsp;&nbsp;&nbsp;  -  <b class="text-danger">81.4.127.91:10480</b></span>
            </li>
            <li class="list-group-item">
                <span class="small tooltipster" title="~ open knightofsorrow.tk"><kbd>name</kbd> - <b class="text-danger">knightofsorrow.tk:10480</b></span>
            </li>
        </ul>
    </div>

    @include('partials._shoutbox',['shouts' => App\Shout::limit(25)->latest()->get()->sortBy('created_at')])

      <!-- <div class="panel pad5" style="padding: 10px !important;">
        <h5 class="info-title" style="margin:0 0 10px 0;border-bottom:2px dashed grey">Donate</h5>
        <a href="donate">Donate for KoS</a>
    </div>
    -->
    <div class="panel pad5" style="padding: 10px !important;">
        <small class="pull-right"><i><b><a href="{{ url('news.index') }}">» view all</a></b></i></small>
        <h4 class="" style="margin:0 0 10px 0;border-bottom:2px dashed grey">Latest News</h4>

        <ul class="no-padding">
            @foreach(\App\News::forSidebar() as $news)
            <li class="list-group-item pad5">
                <h4 class="side-news-title nomargin"><a href="{{ route('news.show',$news->summary) }}">{{ $news->title }}</a></h4>
                <p class="side-news-body">{{ str_limit(BBCode::stripBBCodeTags($news->text)) }}</p>
            </li>
            @endforeach
        </ul>
    </div>

    {{--Only display this section on homepage--}}
    @if(Request::getRequestUri() == "/" || Request::getRequestUri() == "/home")

        @if(\App\Didyouknow::count() > 0)
        <div class="panel pad5" style="padding: 10px !important;">
            <h4 class="" style="margin:0 0 10px 0;border-bottom:2px dashed grey">Did You Know</h4>
            <p class="small convert-emoji" style="color:rgb({{ rand(0,200) }},{{ rand(0,200) }},{{ rand(0,200) }});">{!!  BBCode::parseCaseInsensitive((htmlentities(\App\Didyouknow::get()->random()->body))) !!}</p>
        </div>
        @endif

    <script type="text/javascript" src="http://www.easypolls.net/ext/scripts/emPoll.js?p=5753d3d5e4b073540521b847"></script><a class="OPP-powered-by" href="https://www.murvey.com" style="text-decoration:none;"><div style="font: 9px arial; color: gray;">survey software</div></a>

    @endif
</aside>