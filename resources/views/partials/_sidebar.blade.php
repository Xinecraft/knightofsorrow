<aside class="col-xs-3 main-sidebar">
    <div class="panel pad5" style="padding: 10px !important;">
        <h4 class="" style="margin:0 0 10px 0;border-bottom:2px dashed grey">Join Server
        </h4>

        <ul class="list-group">
            <li class="list-group-item" style="padding: 5px 15px;">
                <span class="small tooltipster" title="SWAT4 Normal Server">
                    <img class="img img20" src="/images/swat.png" alt=""> -
                    <span class="text-danger text-bold"><a href="http://knightofsorrow.in/news/different-ways-to-join-server--author-Kinnngg">31.186.250.32:10480</a></span>
                </span>
            </li>
            <li class="list-group-item" style="padding: 5px 15px;"> <span class="small tooltipster" title="KoS Discord Group"> <img class="img img20" src="/images/logo_ds.png" alt=""> - <span class="text-danger text-bold"><a
                                href="https://discord.gg/Y8DzuUU" target="_blank">https://discord.gg/Y8DzuUU</a></span> </span> </li>

            <li class="list-group-item" style="padding: 5px 15px;"> <span class="small tooltipster" title="KoS TeamSpeak3 Server"> <img class="img img20" src="/images/Logo_ts3.png" alt=""> - <span class="text-danger text-bold"><a
                                href="ts3server://88.198.67.94?port=9987">88.198.67.94:9987</a></span> </span> </li>
        </ul>
    </div>

    @include('partials._shoutbox',['shouts' => App\Shout::limit(20)->with('user')->latest()->get()->sortBy('created_at')])
            <!-- <div class="panel pad5" style="padding: 10px !important;">
        <h5 class="info-title" style="margin:0 0 10px 0;border-bottom:2px dashed grey">Donate</h5>
        <a href="donate">Donate for KoS</a>
    </div>
    -->

    @if($poll = App\Pollq::where('disabled','!=','1')->latest()->limit(1)->first())
        <div class="poll-cont">
            @if(!$poll->isExpired() && !$poll->isVoted())
                <div class="panel pad10">
                    <small class="pull-right"><i><b><a href="{{ route('poll.index') }}">» view all</a></b></i></small>
                    <h4 class="" style="margin:0 0 10px 0;border-bottom:2px dashed grey">Poll</h4>
                    {!! Form::open(['route' => ['poll.vote',$poll->id]]) !!}
                    <h5 class=""><b>{{ $poll->question }}</b></h5>
                    <div class="panel pad10 no-margin" style="font-size: small !important;">
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
                    <small class="pull-right"><i><b><a href="{{ route('poll.index') }}">» view all</a></b></i></small>
                    <h4 class="" style="margin:0 0 10px 0;border-bottom:2px dashed grey">Poll</h4>
                    <h5 class=""><b>{{ $poll->question }}</b></h5>
                    <div class="panel pad10 no-margin" style="font-size: small !important;">
                        @foreach($poll->pollos as $pollo)
                            {{ $pollo->option }}<br>
                            <div class="progress">
                                <div class="progress-bar progress-bar-striped active {{ $polluserscount = $poll->users()->count() }}" role="progressbar"
                                     aria-valuenow="{{ $percent = round($polluserscount == 0 ? 0 : ( $pollo->users->count() / $polluserscount)*100) }}"
                                     aria-valuemin="0" aria-valuemax="100" style="width: {{ $percent }}%;">
                                    {{ $percent }}% ({{ $pollo->users->count() }})
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <span class="small">Total Votes: <b>{{ $poll->users()->count() }}</b></span>
                </div>
            @endif
        </div>
    @endif

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

        <div class="panel pad5 text-center" style="padding: 10px !important;">
            <h4 class="" style="margin:0 0 10px 0;border-bottom:2px dashed grey">Donate</h4>
            <p>If you are capable then please contribute in development of server.</p>
            <a target="_blank" class="btn btn-sm btn-primary" href="https://www.nfoservers.com/donate.pl?force_recipient=1&recipient=kinnngg786%40gmail.com">
                <i class="fa fa-cc"></i>
                Donate</a>
        </div>
    @endif

</aside>
