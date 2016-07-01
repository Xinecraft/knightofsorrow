<aside class="col-md-3">
    <div class="panel pad5" style="padding: 10px !important;">
        <h4 class="" style="margin:0 0 10px 0;border-bottom:2px dashed grey">Join Server
            <small>(using)</small>
        </h4>

        <ul class="list-group">
            <li class="list-group-item">
                <span class="small tooltipster" title="~ join 81.4.127.91:10480"><kbd>ip</kbd> &nbsp;&nbsp;&nbsp;&nbsp;  -  <b
                            class="text-danger">81.4.127.91:10480</b></span>
            </li>
            <li class="list-group-item">
                <span class="small tooltipster" title="~ open knightofsorrow.tk"><kbd>name</kbd> - <b
                            class="text-danger">knightofsorrow.tk:10480</b></span>
            </li>
        </ul>
    </div>

    @include('partials._shoutbox',['shouts' => App\Shout::limit(25)->latest()->get()->sortBy('created_at')])

            <!-- <div class="panel pad5" style="padding: 10px !important;">
        <h5 class="info-title" style="margin:0 0 10px 0;border-bottom:2px dashed grey">Donate</h5>
        <a href="donate">Donate for KoS</a>
    </div>
    -->

    {{--Only display this section on homepage--}}
    @if(Request::getRequestUri() == "/" || Request::getRequestUri() == "/home")

        <div class="panel pad5" style="padding: 10px !important;">
            <small class="pull-right"><i><b><a href="{{ route('news.index') }}">» view all</a></b></i></small>
            <h4 class="" style="margin:0 0 10px 0;border-bottom:2px dashed grey">Latest News</h4>

            <ul class="no-padding">
                @foreach(\App\News::forSidebar() as $news)
                    <li class="list-group-item pad5">
                        <h4 class="side-news-title nomargin"><a
                                    href="{{ route('news.show',$news->summary) }}">{{ $news->title }}</a></h4>
                        <p class="side-news-body">{{ str_limit(BBCode::stripBBCodeTags($news->text)) }}</p>
                    </li>
                @endforeach
            </ul>
        </div>

        @if(\App\Didyouknow::count() > 0)
            <div class="panel pad5" style="padding: 10px !important;">
                <h4 class="" style="margin:0 0 10px 0;border-bottom:2px dashed grey">Did You Know</h4>
                <p class="small convert-emoji"
                   style="color:rgb({{ rand(0,200) }},{{ rand(0,200) }},{{ rand(0,200) }});">{!!  BBCode::parseCaseInsensitive((htmlentities(\App\Didyouknow::get()->random()->body))) !!}</p>
            </div>
        @endif
    @endif

    @if($poll = App\Pollq::latest()->limit(1)->first())
        <div class="poll-cont">
        @if(!$poll->isExpired() && !$poll->isVoted())
            <div class="panel pad10">
                <h4 class="" style="margin:0 0 10px 0;border-bottom:2px dashed grey">Poll</h4>
                {!! Form::open(['route' => ['poll.vote',$poll->id]]) !!}
                <h5 class=""><b>{{ $poll->question }}</b></h5>
                <div class="panel pad10 no-margin">
                    @foreach($poll->pollos as $pollo)
                        <input type="radio" name="option" value="{{ $pollo->id }}"> {{ $pollo->option }}<br>
                    @endforeach
                    <input type="submit" value="Vote" class="btn btn-primary btn-xs">
                    {!! Form::close() !!}
                </div>
                <span class="small">Total Votes: <b>{{ $poll->users()->count() }}</b></span>
            </div>

        @else
            <div class="panel pad10">
                <h4 class="" style="margin:0 0 10px 0;border-bottom:2px dashed grey">Poll</h4>
                <h5 class=""><b>{{ $poll->question }}</b></h5>
                <div class="panel pad10 no-margin">
                    @foreach($poll->pollos as $pollo)
                        {{ $pollo->option }}<br>
                        <div class="progress">
                            <div class="progress-bar progress-bar-striped active" role="progressbar"
                                 aria-valuenow="{{ $percent = $poll->users()->count() == 0 ? 0 : ( $pollo->users()->count() / $poll->users()->count())*100 }}"
                                 aria-valuemin="0" aria-valuemax="100" style="width: {{ $percent }}%;">
                                {{ $percent }}% ({{ $pollo->users()->count() }})
                            </div>
                        </div>
                    @endforeach
                </div>

                <span class="small">Total Votes: <b>{{ $poll->users()->count() }}</b></span>
            </div>
        @endif
        </div>
    @endif

</aside>
