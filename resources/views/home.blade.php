@extends('layouts.main')
@section('styles')
    <style>
        .no-player-online {
            padding: 10px;
            text-align: center;
        }

        .font-13 {
            font-size: 13px;
        }

        .admincommandbtn {
            border-radius: 0px;
            margin-bottom: 10px;
            margin-right: 5px;
        }
        .ls-chats
        {
            word-break: break-all;
        }
        .adminsrvcommandbtn
        {
            border-radius: 0px;
            margin-bottom: 10px;
            margin-right: 5px;
        }
    </style>
@endsection
@section('main-container')
    <div class="content col-xs-9">
        @if(Auth::check() && !Auth::user()->confirmed)
            <div class="alert alert-warning text-center row">
                <strong>You account is Muted! Verify your Email Address to unmute it!</strong><br> Dear Gamer, Please check your email ({{ Auth::user()->email }}) where we have sent a mail to verify your account. Just visit the link provided and follow the instructions to get your account verified. Once verified your account will get unmuted.
                <br>
                <b>{!! link_to_route('user.email.confirmation.resend','Resend Confirmation Email') !!}</b>
            </div>
        @endif

        @if($show_donation == "Hell")
        <div class="alert alert-info alert-dismissable text-center row">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Fellow Gamers!</strong> As we all know, we are frequently upgrading website and server & everything come at a cost. We always need your supports and feedbacks.
            If are are capable then please donate & help us keep this server online. <br>
            <br>
            <a target="_blank" class="btn btn-sm btn-primary" href="https://www.nfoservers.com/donate.pl?force_recipient=1&recipient=kinnngg786%40gmail.com">
                <i class="fa fa-cc"></i>
                Donate</a>
        </div>
        @endif

        <div style="display: none" id="server-viewer">
            <div class="row panel text-center live-server-summary">
                <div class="col-xs-2 ls-swat4-summary">
                    <span class="info-title">SWAT</span>
                    <span class="info-value" id="ls-swat-score">0</span>
                    <span class="info-base" id="ls-swat-wins">0 Wins</span>
                </div>
                <div class="col-xs-2 ls-suspects-summary">
                    <span class="info-title">SUSPECTS</span>
                    <span class="info-value" id="ls-suspects-score">0</span>
                    <span class="info-base" id="ls-suspects-wins">0 Wins</span>
                </div>
                <div class="col-xs-3 ls-round-summary">
                    <span class="info-title">ROUND</span>
                    <span class="info-value" id="ls-round">0/0</span>
                    <span class="info-base" id="ls-time">00:00</span>
                </div>
                <div class="col-xs-5 ls-map-summary">
                    <span class="info-title">MAP</span>
                    <span class="info-value" id="ls-map-name">None</span>
                    <span class="info-base" id="ls-next-map">Next: None</span>
                </div>
            </div> {{--Live Server Summary Ends --}}
            <div class="row">
                <div class="ls-players-and-top-player no-left-padding col-xs-5">
                    <div class="col-xs-12 panel panel-default no-padding">
                        <div class="panel-heading">
                            <span class="pull-right">
                                @if(Auth::check() && Auth::user()->isAdmin())
                            <a style='color:red' class='fancybox livepfancy fancybox.ajax tooltipster' href='./liveserveraction' title='Server Action'><i class='fa fa-cog'></i></a>
                                @endif
                            </span>
                            <span class="info-title">Online Players <span
                                        id="ls-player-online"></span></span>
                        </div>
                        <div class="panel-body no-padding" id="ls-player-total-div">
                            <table class="table table-striped table-hover no-margin" id="ls-player-table">
                                <th class="loading-pt-info text-center" style="padding: 15px;font-size: 15px">Loading
                                    Players table...
                                </th>
                            </table>
                        </div>

                    </div>
                    <div class="col-xs-12 panel panel-default no-padding">
                        <div class="panel-heading"><span class="info-title">Top Players</span></div>
                        <div class="panel-body no-padding">

                            <table class="table table-striped table-hover no-margin">
                                <thead style="font-size: 80%">
                                <tr>
                                    <th class="col-xs-1">#</th>
                                    <th class="col-xs-1">Flag</th>
                                    <th class="col-xs-1">Rank</th>
                                    <th>Name</th>
                                    <th class="text-right">Rating</th>
                                </tr>
                                </thead>
                                @forelse($topPlayers as $player)
                                    <tr>
                                        <th>{{ $player->position }}</th>
                                        <td>{!! Html::image($player->countryImage,$player->country->countryCode,['title' => $player->country->countryName, 'class' => 'tooltipster']) !!}</td>
                                        <td>{!! Html::image($player->rankImage,'',['title' => $player->rank->name,'class' => 'tooltipster' ,'height' => '22px']) !!}</td>
                                        <td class="color-main text-bold">{!! link_to_route('player-detail', $player->nameTrimmed, [$player->name]) !!}</td>
                                        <td class="text-right">{!! $player->player_rating or "<span class='text-muted'>none</span>" !!}</td>
                                    </tr>
                                @empty
                                    Empty
                                @endforelse
                            </table>
                        </div>
                    </div>
                </div> {{--Server Players and Top Players Wrapper Ends--}}
                <div class="col-xs-7 panel panel-default no-padding">
                    <div class="panel-heading">
                        <small class="pull-right"><i><b><a href="{{ route('chat.index') }}">» view all</a></b></i>
                        </small>
                        <span class="info-title">Server Viewer</span>
                    </div>
                    <div class="panel-body ls-chats">
                        <div class="loading-pt-info">Loading Server Chat...</div>
                    </div>
                    <div class="panel-footer">
                        @if(Auth::check())
                            {!!  Form::open(['route' => 'server.chat','id' => 'serverchat-form']) !!}
                            <div id="shout-input-group" class="input-group">
                                <input name="serverchatmsg" id="btn-input" type="text" class="textarea form-control"
                                       placeholder="Type your message here..." autocomplete="off"/>
                        <span class="input-group-btn">
                            <button class="btn btn-primary" id="btn-chat">
                                Send
                            </button>
                        </span>
                            </div>

                                <div id="serverchat-input-group-error" class="help-block"></div>
                                <div class="admin-info small">
                                    <b>Translate:</b><code>!t or !tr or !translate</code> followed by text to translate from any language to english. eg: <code>!tr salut les gars</code><br>
                                @if(Auth::user()->isAdmin())
                                    <b>Note: You can run any commands using this chat too.</b> <br>
                                    Type <code>kosc</code> preceding with command you want to run. <br>
                                    Example: <code>kosc kick Name</code>, <code>kosc restart</code>, <code>kosc setmap
                                        0</code>
                                    @endif
                                </div>


                            {!! Form::close() !!}
                        @else
                            <div class='panel nomargin padding10 text-muted'><b>{!!  link_to('/auth/login','Login') !!}
                                    or {!! link_to('/auth/register', 'Register') !!} to chat with in-game players.</b>
                            </div>
                        @endif
                    </div>

                </div> {{--Live Server Viewer Ends--}}
            </div> {{--Live Server Players,Top Players and Server Viewer Row Ends--}}
        </div>
        <div class="server-viewer-loader row">
            <div id="sv-loading">Loading Server Viewer…</div>
        </div>

        <div class="row hidden-xs round-reports">
            <div style="" class="col-xs-12 panel panel-default no-padding no-margin no-left-padding">
                <div class="panel-heading">
                    <small class="pull-right"><i><b><a href="{{ route('round-reports') }}">» view all</a></b></i>
                    </small>
                    <span class="info-title">Round Reports</span>
                </div>
                <div class="panel-body">
                    <table class="table table-striped table-hover no-margin">
                        <thead>
                        <tr>
                            <th class="col-xs-1">Round</th>
                            <th class="col-xs-2">Time</th>
                            <th class="col-xs-1">Swat</th>
                            <th class="col-xs-2">Suspects</th>
                            <th>Map</th>
                            <th class="col-xs-2 text-right">Date</th>
                        </tr>
                        </thead>
                        <tbody id="data-items" class="roundstabledata">
                        @foreach($latestGames as $round)
                            <tr class="item pointer-cursor" data-id="{{ $round->id }}">
                                <td class="color-main text-bold">{!! link_to_route('round-detail',$round->index,[$round->id]) !!}</td>
                                <td class="text-muted">{{ $round->time }}</td>
                                <td>{!! $round->swatScoreWithColor !!}</td>
                                <td>{!! $round->suspectsScoreWithColor !!}</td>
                                <td>{{ $round->mapName }}</td>
                                <td class="text-right tooltipster" title="{{ $round->timeDDTS }}">{{ $round->timeAgo }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="row player-records hidden-xs">
            <div style="" class="col-xs-12 panel panel-default no-padding no-margin no-left-padding">
                <div class="panel-heading">
                    <span class="info-title">
                    Player Records
                    </span>
                </div>
                <div class="panel-body">
                    <div class="col-articles articles">
                        <div>
                            <!--Tab Starts-->
                            <div role="tabpanel">
                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs" role="tablist">
                                    <li role="presentation" class="active"><a class="ainorange" href="#pastweek"
                                                                        aria-controls="pastweek" role="tab"
                                                                        data-toggle="tab">Past Week</a></li>
                                    <li role="presentation"><a class="ainorange" href="#pastmonth"
                                                               aria-controls="pastmonth" role="tab" data-toggle="tab">Past
                                            Month</a></li>
                                    <li role="presentation"><a class="ainorange" href="#pastyear"
                                                               aria-controls="pastyear" role="tab" data-toggle="tab">Past
                                            Year</a></li>
                                    <li role="presentation"><a class="ainorange" href="#alltime"
                                                                              aria-controls="alltime" role="tab"
                                                                              data-toggle="tab">All Time</a></li>
                                </ul>
                                <!-- Tab panes -->
                                <div class="tab-content"
                                     style="background-color: #ffffff;border-left: 1px solid #ddd;border-bottom: 1px solid #ddd;border-right: 1px solid #ddd;">
                                    <div role="tabpanel" class="tab-pane active" id="pastweek">
                                        <table class="table borderless playerrecordtable">
                                            <tbody>
                                            <tr>
                                                <td class="col-1">
                                                    <div class="player-records-icon totalscore"></div>
                                                </td>
                                                <td class="col-2">
                                                    Total Score
                                                </td>
                                                <td class="col-3">
                                                    {!! link_to_route('player-detail',$PastWeek->totalScore->name,[$PastWeek->totalScore->name]) !!}
                                                    <span class="small">({{ $PastWeek->totalScore->totalscore }})</span>
                                                </td>
                                                <td class="col-4">
                                                    <div class="player-records-icon arrests"></div>
                                                </td>
                                                <td class="col-5">
                                                    Arrests
                                                </td>
                                                <td class="col-6">
                                                    {!! link_to_route('player-detail',$PastWeek->totalArrests->name,[$PastWeek->totalArrests->name]) !!}
                                                    <span class="small">({{ $PastWeek->totalArrests->totalarrests }}
                                                        )</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="col-1">
                                                    <div class="player-records-icon highscore"></div>
                                                </td>
                                                <td class="col-2">
                                                    High Score
                                                </td>
                                                <td class="col-3">
                                                    {!! link_to_route('player-detail',$PastWeek->highestScore->name,[$PastWeek->highestScore->name]) !!}
                                                    <span class="small">({{ $PastWeek->highestScore->highestscore }}
                                                        )</span>
                                                </td>
                                                <td class="col-4">
                                                    <div class="player-records-icon arrested"></div>
                                                </td>
                                                <td class="col-5">
                                                    Arrested
                                                </td>
                                                <td class="col-6">
                                                    {!! link_to_route('player-detail',$PastWeek->totalArrested->name,[$PastWeek->totalArrested->name]) !!}
                                                    <span class="small">({{ $PastWeek->totalArrested->totalarrested }}
                                                        )</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="col-1">
                                                    <div class="player-records-icon totalscore"></div>
                                                </td>
                                                <td class="col-2">
                                                    Score/Min
                                                </td>
                                                <td class="col-3">
                                                    {!! link_to_route('player-detail',$PastWeek->bestScorePerMin->name,[$PastWeek->bestScorePerMin->name]) !!}
                                                    <span class="small">({{ round($PastWeek->bestScorePerMin->toArray()['scorepermin'],2) }}
                                                        )</span>
                                                </td>
                                                <td class="col-4">
                                                    <div class="player-records-icon arreststreak"></div>
                                                </td>
                                                <td class="col-5">
                                                    Arrest Streak
                                                </td>
                                                <td class="col-6">
                                                    {!! link_to_route('player-detail',$PastWeek->bestArrestStreak->name,[$PastWeek->bestArrestStreak->name]) !!}
                                                    <span class="small">({{ $PastWeek->bestArrestStreak->best_arrest_streak }}
                                                        )</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="col-1">
                                                    <div class="player-records-icon time"></div>
                                                </td>
                                                <td class="col-2">
                                                    Time Played
                                                </td>
                                                <td class="col-3">
                                                    {!! link_to_route('player-detail',$PastWeek->totalTimePlayed->name,[$PastWeek->totalTimePlayed->name]) !!}
                                                    <span class="small">({{ App\Server\Utils::getHMbyS($PastWeek->totalTimePlayed->totaltimeplayed,"%dh %dm") }}
                                                        )</span>
                                                </td>
                                                <td class="col-4">
                                                    <div class="player-records-icon kills"></div>
                                                </td>
                                                <td class="col-5">Kills</td>
                                                <td class="col-6">
                                                    {!! link_to_route('player-detail',$PastWeek->totalKills->name,[$PastWeek->totalKills->name]) !!}
                                                    <span class="small">({{ $PastWeek->totalKills->totalkills }})</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="col-1">
                                                    <div class="player-records-icon deaths"></div>
                                                </td>
                                                <td class="col-2">
                                                    Death Streak
                                                </td>
                                                <td class="col-3">
                                                    {!! link_to_route('player-detail',$PastWeek->bestDeathStreak->name,[$PastWeek->bestDeathStreak->name]) !!}
                                                    <span class="small">({{ $PastWeek->bestDeathStreak->best_death_streak }}
                                                        )</span>
                                                </td>
                                                <td class="col-4">
                                                    <div class="player-records-icon deaths"></div>
                                                </td>
                                                <td class="col-5">
                                                    Deaths
                                                </td>
                                                <td class="col-6">
                                                    {!! link_to_route('player-detail',$PastWeek->totalDeaths->name,[$PastWeek->totalDeaths->name]) !!}
                                                    <span class="small">({{ $PastWeek->totalDeaths->totaldeaths }}
                                                        )</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="col-1">
                                                    <div class="player-records-icon teamkills"></div>
                                                </td>
                                                <td class="col-2">
                                                    Team Kills
                                                </td>
                                                <td class="col-3">
                                                    {!! link_to_route('player-detail',$PastWeek->totalTeamKills->name,[$PastWeek->totalTeamKills->name]) !!}
                                                    <span class="small">({{ $PastWeek->totalTeamKills->totalteamkills }}
                                                        )</span>
                                                </td>
                                                <td class="col-4">
                                                    <div class="player-records-icon killstreak"></div>
                                                </td>
                                                <td class="col-5">
                                                    Kill Streak
                                                </td>
                                                <td class="col-6">
                                                    {!! link_to_route('player-detail',$PastWeek->bestKillStreak->name,[$PastWeek->bestKillStreak->name]) !!}
                                                    <span class="small">({{ $PastWeek->bestKillStreak->best_kill_streak }}
                                                        )</span>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div role="tabpanel" class="tab-pane" id="pastmonth">
                                        <table class="table borderless playerrecordtable">
                                            <tbody>
                                            <tr>
                                                <td class="col-1">
                                                    <div class="player-records-icon totalscore"></div>
                                                </td>
                                                <td class="col-2">
                                                    Total Score
                                                </td>
                                                <td class="col-3">
                                                    {!! link_to_route('player-detail',$PastMonth->totalScore->name,[$PastMonth->totalScore->name]) !!}
                                                    <span class="small">({{ $PastMonth->totalScore->totalscore }}
                                                        )</span>
                                                </td>
                                                <td class="col-4">
                                                    <div class="player-records-icon arrests"></div>
                                                </td>
                                                <td class="col-5">
                                                    Arrests
                                                </td>
                                                <td class="col-6">
                                                    {!! link_to_route('player-detail',$PastMonth->totalArrests->name,[$PastMonth->totalArrests->name]) !!}
                                                    <span class="small">({{ $PastMonth->totalArrests->totalarrests }}
                                                        )</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="col-1">
                                                    <div class="player-records-icon highscore"></div>
                                                </td>
                                                <td class="col-2">
                                                    High Score
                                                </td>
                                                <td class="col-3">
                                                    {!! link_to_route('player-detail',$PastMonth->highestScore->name,[$PastMonth->highestScore->name]) !!}
                                                    <span class="small">({{ $PastMonth->highestScore->highestscore }}
                                                        )</span>
                                                </td>
                                                <td class="col-4">
                                                    <div class="player-records-icon arrested"></div>
                                                </td>
                                                <td class="col-5">
                                                    Arrested
                                                </td>
                                                <td class="col-6">
                                                    {!! link_to_route('player-detail',$PastMonth->totalArrested->name,[$PastMonth->totalArrested->name]) !!}
                                                    <span class="small">({{ $PastMonth->totalArrested->totalarrested }}
                                                        )</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="col-1">
                                                    <div class="player-records-icon totalscore"></div>
                                                </td>
                                                <td class="col-2">
                                                    Score/Min
                                                </td>
                                                <td class="col-3">
                                                    {!! link_to_route('player-detail',$PastMonth->bestScorePerMin->name,[$PastMonth->bestScorePerMin->name]) !!}
                                                    <span class="small">({{ round($PastMonth->bestScorePerMin->toArray()['scorepermin'],2) }}
                                                        )</span>
                                                </td>
                                                <td class="col-4">
                                                    <div class="player-records-icon arreststreak"></div>
                                                </td>
                                                <td class="col-5">
                                                    Arrest Streak
                                                </td>
                                                <td class="col-6">
                                                    {!! link_to_route('player-detail',$PastMonth->bestArrestStreak->name,[$PastMonth->bestArrestStreak->name]) !!}
                                                    <span class="small">({{ $PastMonth->bestArrestStreak->best_arrest_streak }}
                                                        )</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="col-1">
                                                    <div class="player-records-icon time"></div>
                                                </td>
                                                <td class="col-2">
                                                    Time Played
                                                </td>
                                                <td class="col-3">
                                                    {!! link_to_route('player-detail',$PastMonth->totalTimePlayed->name,[$PastMonth->totalTimePlayed->name]) !!}
                                                    <span class="small">({{ App\Server\Utils::getHMbyS($PastMonth->totalTimePlayed->totaltimeplayed,"%dh %dm") }}
                                                        )</span>
                                                </td>
                                                <td class="col-4">
                                                    <div class="player-records-icon kills"></div>
                                                </td>
                                                <td class="col-5">Kills</td>
                                                <td class="col-6">
                                                    {!! link_to_route('player-detail',$PastMonth->totalKills->name,[$PastMonth->totalKills->name]) !!}
                                                    <span class="small">({{ $PastMonth->totalKills->totalkills }}
                                                        )</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="col-1">
                                                    <div class="player-records-icon deaths"></div>
                                                </td>
                                                <td class="col-2">
                                                    Death Streak
                                                </td>
                                                <td class="col-3">
                                                    {!! link_to_route('player-detail',$PastMonth->bestDeathStreak->name,[$PastMonth->bestDeathStreak->name]) !!}
                                                    <span class="small">({{ $PastMonth->bestDeathStreak->best_death_streak }}
                                                        )</span>
                                                </td>
                                                <td class="col-4">
                                                    <div class="player-records-icon deaths"></div>
                                                </td>
                                                <td class="col-5">
                                                    Deaths
                                                </td>
                                                <td class="col-6">
                                                    {!! link_to_route('player-detail',$PastMonth->totalDeaths->name,[$PastMonth->totalDeaths->name]) !!}
                                                    <span class="small">({{ $PastMonth->totalDeaths->totaldeaths }}
                                                        )</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="col-1">
                                                    <div class="player-records-icon teamkills"></div>
                                                </td>
                                                <td class="col-2">
                                                    Team Kills
                                                </td>
                                                <td class="col-3">
                                                    {!! link_to_route('player-detail',$PastMonth->totalTeamKills->name,[$PastMonth->totalTeamKills->name]) !!}
                                                    <span class="small">({{ $PastMonth->totalTeamKills->totalteamkills }}
                                                        )</span>
                                                </td>
                                                <td class="col-4">
                                                    <div class="player-records-icon killstreak"></div>
                                                </td>
                                                <td class="col-5">
                                                    Kill Streak
                                                </td>
                                                <td class="col-6">
                                                    {!! link_to_route('player-detail',$PastMonth->bestKillStreak->name,[$PastMonth->bestKillStreak->name]) !!}
                                                    <span class="small">({{ $PastMonth->bestKillStreak->best_kill_streak }}
                                                        )</span>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div role="tabpanel" class="tab-pane" id="pastyear">
                                        <table class="table borderless playerrecordtable">
                                            <tbody>
                                            <tr>
                                                <td class="col-1">
                                                    <div class="player-records-icon totalscore"></div>
                                                </td>
                                                <td class="col-2">
                                                    Total Score
                                                </td>
                                                <td class="col-3">
                                                    {!! link_to_route('player-detail',$PastYear->totalScore->name,[$PastYear->totalScore->name]) !!}
                                                    <span class="small">({{ $PastYear->totalScore->totalscore }})</span>
                                                </td>
                                                <td class="col-4">
                                                    <div class="player-records-icon arrests"></div>
                                                </td>
                                                <td class="col-5">
                                                    Arrests
                                                </td>
                                                <td class="col-6">
                                                    {!! link_to_route('player-detail',$PastYear->totalArrests->name,[$PastYear->totalArrests->name]) !!}
                                                    <span class="small">({{ $PastYear->totalArrests->totalarrests }}
                                                        )</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="col-1">
                                                    <div class="player-records-icon highscore"></div>
                                                </td>
                                                <td class="col-2">
                                                    High Score
                                                </td>
                                                <td class="col-3">
                                                    {!! link_to_route('player-detail',$PastYear->highestScore->name,[$PastYear->highestScore->name]) !!}
                                                    <span class="small">({{ $PastYear->highestScore->highestscore }}
                                                        )</span>
                                                </td>
                                                <td class="col-4">
                                                    <div class="player-records-icon arrested"></div>
                                                </td>
                                                <td class="col-5">
                                                    Arrested
                                                </td>
                                                <td class="col-6">
                                                    {!! link_to_route('player-detail',$PastYear->totalArrested->name,[$PastYear->totalArrested->name]) !!}
                                                    <span class="small">({{ $PastYear->totalArrested->totalarrested }}
                                                        )</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="col-1">
                                                    <div class="player-records-icon totalscore"></div>
                                                </td>
                                                <td class="col-2">
                                                    Score/Min
                                                </td>
                                                <td class="col-3">
                                                    {!! link_to_route('player-detail',$PastYear->bestScorePerMin->name,[$PastYear->bestScorePerMin->name]) !!}
                                                    <span class="small">({{ round($PastYear->bestScorePerMin->toArray()['scorepermin'],2) }}
                                                        )</span>
                                                </td>
                                                <td class="col-4">
                                                    <div class="player-records-icon arreststreak"></div>
                                                </td>
                                                <td class="col-5">
                                                    Arrest Streak
                                                </td>
                                                <td class="col-6">
                                                    {!! link_to_route('player-detail',$PastYear->bestArrestStreak->name,[$PastYear->bestArrestStreak->name]) !!}
                                                    <span class="small">({{ $PastYear->bestArrestStreak->best_arrest_streak }}
                                                        )</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="col-1">
                                                    <div class="player-records-icon time"></div>
                                                </td>
                                                <td class="col-2">
                                                    Time Played
                                                </td>
                                                <td class="col-3">
                                                    {!! link_to_route('player-detail',$PastYear->totalTimePlayed->name,[$PastYear->totalTimePlayed->name]) !!}
                                                    <span class="small">({{ App\Server\Utils::getHMbyS($PastYear->totalTimePlayed->totaltimeplayed,"%dh %dm") }}
                                                        )</span>
                                                </td>
                                                <td class="col-4">
                                                    <div class="player-records-icon kills"></div>
                                                </td>
                                                <td class="col-5">Kills</td>
                                                <td class="col-6">
                                                    {!! link_to_route('player-detail',$PastYear->totalKills->name,[$PastYear->totalKills->name]) !!}
                                                    <span class="small">({{ $PastYear->totalKills->totalkills }})</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="col-1">
                                                    <div class="player-records-icon deaths"></div>
                                                </td>
                                                <td class="col-2">
                                                    Death Streak
                                                </td>
                                                <td class="col-3">
                                                    {!! link_to_route('player-detail',$PastYear->bestDeathStreak->name,[$PastYear->bestDeathStreak->name]) !!}
                                                    <span class="small">({{ $PastYear->bestDeathStreak->best_death_streak }}
                                                        )</span>
                                                </td>
                                                <td class="col-4">
                                                    <div class="player-records-icon deaths"></div>
                                                </td>
                                                <td class="col-5">
                                                    Deaths
                                                </td>
                                                <td class="col-6">
                                                    {!! link_to_route('player-detail',$PastYear->totalDeaths->name,[$PastYear->totalDeaths->name]) !!}
                                                    <span class="small">({{ $PastYear->totalDeaths->totaldeaths }}
                                                        )</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="col-1">
                                                    <div class="player-records-icon teamkills"></div>
                                                </td>
                                                <td class="col-2">
                                                    Team Kills
                                                </td>
                                                <td class="col-3">
                                                    {!! link_to_route('player-detail',$PastYear->totalTeamKills->name,[$PastYear->totalTeamKills->name]) !!}
                                                    <span class="small">({{ $PastYear->totalTeamKills->totalteamkills }}
                                                        )</span>
                                                </td>
                                                <td class="col-4">
                                                    <div class="player-records-icon killstreak"></div>
                                                </td>
                                                <td class="col-5">
                                                    Kill Streak
                                                </td>
                                                <td class="col-6">
                                                    {!! link_to_route('player-detail',$PastYear->bestKillStreak->name,[$PastYear->bestKillStreak->name]) !!}
                                                    <span class="small">({{ $PastYear->bestKillStreak->best_kill_streak }}
                                                        )</span>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div role="tabpanel" class="tab-pane" id="alltime">
                                        <table class="table borderless playerrecordtable">
                                            <tbody>
                                            <tr>
                                                <td class="col-1">
                                                    <div class="player-records-icon totalscore"></div>
                                                </td>
                                                <td class="col-2">
                                                    Total Score
                                                </td>
                                                <td class="col-3">
                                                    {!! link_to_route('player-detail',$AllTime->totalScore->name,[$AllTime->totalScore->name]) !!}
                                                    <span class="small">({{ $AllTime->totalScore->totalscore }})</span>
                                                </td>
                                                <td class="col-4">
                                                    <div class="player-records-icon arrests"></div>
                                                </td>
                                                <td class="col-5">
                                                    Arrests
                                                </td>
                                                <td class="col-6">
                                                    {!! link_to_route('player-detail',$AllTime->totalArrests->name,[$AllTime->totalArrests->name]) !!}
                                                    <span class="small">({{ $AllTime->totalArrests->totalarrests }}
                                                        )</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="col-1">
                                                    <div class="player-records-icon highscore"></div>
                                                </td>
                                                <td class="col-2">
                                                    High Score
                                                </td>
                                                <td class="col-3">
                                                    {!! link_to_route('player-detail',$AllTime->highestScore->name,[$AllTime->highestScore->name]) !!}
                                                    <span class="small">({{ $AllTime->highestScore->highestscore }}
                                                        )</span>
                                                </td>
                                                <td class="col-4">
                                                    <div class="player-records-icon arrested"></div>
                                                </td>
                                                <td class="col-5">
                                                    Arrested
                                                </td>
                                                <td class="col-6">
                                                    {!! link_to_route('player-detail',$AllTime->totalArrested->name,[$AllTime->totalArrested->name]) !!}
                                                    <span class="small">({{ $AllTime->totalArrested->totalarrested }}
                                                        )</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="col-1">
                                                    <div class="player-records-icon totalscore"></div>
                                                </td>
                                                <td class="col-2">
                                                    Score/Min
                                                </td>
                                                <td class="col-3">
                                                    {!! link_to_route('player-detail',$AllTime->bestScorePerMin->name,[$AllTime->bestScorePerMin->name]) !!}
                                                    <span class="small">({{ round($AllTime->bestScorePerMin->toArray()['scorepermin'],2) }}
                                                        )</span>
                                                </td>
                                                <td class="col-4">
                                                    <div class="player-records-icon arreststreak"></div>
                                                </td>
                                                <td class="col-5">
                                                    Arrest Streak
                                                </td>
                                                <td class="col-6">
                                                    {!! link_to_route('player-detail',$AllTime->bestArrestStreak->name,[$AllTime->bestArrestStreak->name]) !!}
                                                    <span class="small">({{ $AllTime->bestArrestStreak->best_arrest_streak }}
                                                        )</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="col-1">
                                                    <div class="player-records-icon time"></div>
                                                </td>
                                                <td class="col-2">
                                                    Time Played
                                                </td>
                                                <td class="col-3">
                                                    {!! link_to_route('player-detail',$AllTime->totalTimePlayed->name,[$AllTime->totalTimePlayed->name]) !!}
                                                    <span class="small">({{ App\Server\Utils::getHMbyS($AllTime->totalTimePlayed->totaltimeplayed,"%dh %dm") }}
                                                        )</span>
                                                </td>
                                                <td class="col-4">
                                                    <div class="player-records-icon kills"></div>
                                                </td>
                                                <td class="col-5">Kills</td>
                                                <td class="col-6">
                                                    {!! link_to_route('player-detail',$AllTime->totalKills->name,[$AllTime->totalKills->name]) !!}
                                                    <span class="small">({{ $AllTime->totalKills->totalkills }})</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="col-1">
                                                    <div class="player-records-icon deaths"></div>
                                                </td>
                                                <td class="col-2">
                                                    Death Streak
                                                </td>
                                                <td class="col-3">
                                                    {!! link_to_route('player-detail',$AllTime->bestDeathStreak->name,[$AllTime->bestDeathStreak->name]) !!}
                                                    <span class="small">({{ $AllTime->bestDeathStreak->best_death_streak }}
                                                        )</span>
                                                </td>
                                                <td class="col-4">
                                                    <div class="player-records-icon deaths"></div>
                                                </td>
                                                <td class="col-5">
                                                    Deaths
                                                </td>
                                                <td class="col-6">
                                                    {!! link_to_route('player-detail',$AllTime->totalDeaths->name,[$AllTime->totalDeaths->name]) !!}
                                                    <span class="small">({{ $AllTime->totalDeaths->totaldeaths }}
                                                        )</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="col-1">
                                                    <div class="player-records-icon teamkills"></div>
                                                </td>
                                                <td class="col-2">
                                                    Team Kills
                                                </td>
                                                <td class="col-3">
                                                    {!! link_to_route('player-detail',$AllTime->totalTeamKills->name,[$AllTime->totalTeamKills->name]) !!}
                                                    <span class="small">({{ $AllTime->totalTeamKills->totalteamkills }}
                                                        )</span>
                                                </td>
                                                <td class="col-4">
                                                    <div class="player-records-icon killstreak"></div>
                                                </td>
                                                <td class="col-5">
                                                    Kill Streak
                                                </td>
                                                <td class="col-6">
                                                    {!! link_to_route('player-detail',$AllTime->bestKillStreak->name,[$AllTime->bestKillStreak->name]) !!}
                                                    <span class="small">({{ $AllTime->bestKillStreak->best_kill_streak }}
                                                        )</span>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!--/Tab Ends-->
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row player-records">
            <div class="col-xs-12 panel panel-default no-padding no-margin no-left-padding">
                <div class="panel-heading">
                    <small class="pull-right"><i><b><a href="{{ route('bans.index') }}">» view all</a></b></i></small>
                    <span class="info-title">Latest Bans</span>
                </div>
                <div class="panel-body">
                    <table id="" class="table table-striped table-hover no-margin">
                        <thead>
                        <tr>
                            <th class="col-xs-1">Flag</th>
                            <th class="col-xs-3">Name</th>
                            <th class="col-xs-2">IP Address</th>
                            <th class="col-xs-3">Banned By</th>
                            <th class="col-xs-1">Status</th>
                            <th class="col-xs-2 text-right">Updated</th>
                        </tr>
                        </thead>
                        <tbody id="">
                        @foreach($bans as $ban)
                            <tr class="item">
                                <td class="text-muted"><img class="tooltipster" title="{{ $ban->countryName }}"
                                                            src="{{ $ban->countryImage }}" alt="" height="22px"/></td>
                                <td class="color-main text-bold">{!! link_to_route('bans.show',$ban->name,[$ban->id]) !!}</td>
                                <td>{!! $ban->ipAddrWithMask !!}</td>
                                <td>{!! $ban->bannedByAdminURL !!}</td>
                                <td><b>{!! $ban->statusWithColor !!}</b></td>
                                <td class="text-right tooltipster" title="{{ $ban->updated_at->toDayDateTimeString() }}">{!! $ban->updated_at->diffForHumans() !!}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="row player-records">
            <div style="" class="col-xs-12 panel panel-default no-padding no-margin no-left-padding">
                <div class="panel-heading">
                    <small class="pull-right"><i><b><a href="{{ route('notifications.index') }}">» view all</a></b></i></small>
                <span class="info-title">
                    Global Notifications
                </span>
                </div>

                <div class="panel-body font-13">
                    <ul class="notifications">
                        @forelse($notifications as $notification)
                        <li class="notification pad5">
                            <div class="media">
                                <div class="media-body">
                                    {!! $notification->body !!}

                                    <div class="notification-meta pull-right">
                                        <small class="timestamp">{{ $notification->created_at->diffForHumans() }}</small>
                                    </div>
                                </div>
                            </div>
                        </li>
                        @empty
                            <h3 class="text-center">No Notifications</h3>
                        @endforelse
                    </ul>
                </div>
              </div>
            </div>

            <div style="margin-bottom: 15px;" class="row player-records">
                <div style="" class="col-xs-12 panel panel-default no-padding no-margin no-left-padding">
                    <div class="panel-heading">
                <span class="info-title">
                    Last Active Users
                </span>
                    </div>

                    <div class="panel-body font-13">
                        @forelse($activeUsers as $user)
                            <a class="{{ "color-".$user->roles()->first()->name }}" style="margin-right:1em"
                               href="{{ route('user.show',$user->username) }}"><strong class="">{{ $user->displayName() }}{!! $user->isOnline ? "<sup class='text-green'>&#x25cf;</sup>" : "" !!}</strong></a>
                        @empty
                        @endforelse
                    </div>
                </div>
            </div>

        </div> {{--Main Content Ends--}}
        @endsection

        {{--Scripts section for Home Page--}}
        @section('scripts')
            <script type="text/javascript">

                var sv = {
                    url: '',
                    elems: {},
                    roundTime: 0,

                    init: function (obj) {
                        sv.url = obj.url;

                        //$('#ls-player-limit').text(player_max);

                        sv.elems = {
                            $container: $('#server-viewer'),
                            $scoreSwat: $('#ls-swat-score'),
                            $scoreSuspects: $('#ls-suspects-score'),
                            $swatWon: $('#ls-swat-wins'),
                            $susWon: $('#ls-suspects-wins'),
                            $onlinePlayers: $('#ls-player-total-div'),
                            $numPlayers: $('#ls-player-online'),
                            $chat: $('.ls-chats'),
                            $map: $('#ls-map-name'),
                            $nextMap: $('#ls-next-map'),
                            $roundNum: $('#ls-round'),
                            $roundTime: $('#ls-time')
                        };

                        $.doTimeout('svUpdate', 3000, sv.update);
                        $.doTimeout('svUpdate', true);

                        $.doTimeout('roundTime', 1000, sv.updateRoundTime);
                        $.doTimeout('roundTime', true);

                    },

                    update: function () {
                        $.getJSON(sv.url + '/get3', function (obj) {
                            if (!obj.isOnline) {
                                sv.elems.$container.fadeOut(300).next().show();
                                return;
                            }

                            var colors = sv.getScoreColors(obj.scoreSwat, obj.scoreSuspects);

                            sv.elems.$scoreSwat.html(obj.scoreSwat).css('color', colors[0]);
                            sv.elems.$scoreSuspects.html(obj.scoreSuspects).css('color', colors[1]);
                            sv.elems.$swatWon.html(obj.swatWon + ' win' + (obj.swatWon == 1 ? '' : 's'));
                            sv.elems.$susWon.html(obj.susWon + ' win' + (obj.susWon == 1 ? '' : 's'));
                            sv.elems.$roundNum.html(obj.roundNumber + '/' + obj.numRounds);
                            sv.updateRoundTime(obj.roundTime);
                            sv.elems.$map.html(obj.title).attr('title', obj.title);
                            sv.elems.$nextMap.html("Next: " + getMapByClass(obj.nextMap));
                            sv.elems.$numPlayers.html('(' + obj.numPlayers + '/' + obj.maxPlayers + ')');
                            sv.elems.$chat.html(obj.chatContent);

                            $('.tooltipster', sv.elems.$onlinePlayers).poshytip('destroy');
                            sv.elems.$onlinePlayers.html(obj.onlinePlayersContent);

                            sv.playerCountries = obj.playerCountries;

                            sv.elems.$container.delay(1000).fadeIn(300).next().delay(700).fadeOut(300);
                        });
                        return true; // loop
                    },

                    getScoreColors: function (swat, suspects) {
                        var tied = '#000', win = '#17AF17', loose = '#BB2F0E';

                        if (swat == suspects) {
                            return [tied, tied];
                        }
                        if (swat > suspects) {
                            return [win, loose];
                        }
                        return [loose, win];
                    },

                    updateRoundTime: function (roundTime) {
                        var mins, secs, formatted = '∞';

                        if (typeof roundTime != 'undefined') {
                            sv.roundTime = roundTime;
                        }
                        else if (sv.roundTime > 0) {
                            sv.roundTime--;
                        }

                        if (sv.roundTime > 0) {
                            mins = Math.floor(sv.roundTime / 60);
                            secs = sv.roundTime % 60;
                            formatted = mins + ':' + (secs < 10 ? '0' : '') + secs;
                        }

                        sv.elems.$roundTime.html(formatted);
                        return true; // loop
                    }
                };

                $(document).ready(function () {
                    sv.init({url: '/api/server-query'});

                    //Admin server commands ajax
                    $('body').on('click','.adminsrvcommandbtn',function(e) {

                        $('#admincommand-input-group-error').html('');

                        $.ajax({
                            type: 'POST',
                            url: '/kossrvadmin',
                            data: $('#adminsrvcommandform').serialize() + "&action=" + $(this).data('type'),
                            dataType: 'json',
                            encode: true,
                            beforeSend: function () {
                                $(this).hide();
                                $("#admincommand-input-group-error").html("<option class='text-center small'>Executing Command!  Plz wait...</option>");
                            },
                            success: function (data) {
                                $(this).show();
                                $.fancybox.close();
                                $('#admincommand-input-group-error').html('');
                            },
                            error: function (data) {
                                //$.fancybox.close();
                                var errors = data.responseJSON;
                                var message = "Unknown error! reload page.";
                                switch (data.status) {
                                    case 422:
                                        message = errors.error;
                                        break;
                                    case 500:
                                        message = "Server error! please reload the page.";
                                        break;
                                    default:
                                        message = data.statusText;
                                        break;
                                }

                                $(this).show();
                                $('#admincommand-input-group-error').html("");
                                $('#admincommand-input-group-error').html(message);
                            }
                        });
                        e.preventDefault();
                    });

                    //Admin players commands ajax
                    $('body').on('click','.admincommandbtn',function(e) {

                        $('#admincommand-input-group-error').html('');

                        $.ajax({
                            type: 'POST',
                            url: '/kosadmin',
                            data: $('#admincommandform').serialize() + "&action=" + $(this).data('type'),
                            dataType: 'json',
                            encode: true,
                            beforeSend: function () {
                                $(this).hide();
                                $("#admincommand-input-group-error").html("<option class='text-center small'>Executing Command!  Plz wait...</option>");
                            },
                            success: function (data) {
                                $(this).show();
                                $.fancybox.close();
                                $('#admincommand-input-group-error').html('');
                            },
                            error: function (data) {

                                //$.fancybox.close();
                                var errors = data.responseJSON;
                                var message = "Unknown error! reload page.";
                                switch (data.status) {
                                    case 422:
                                        message = errors.error;
                                        break;
                                    case 500:
                                        message = "Server error! please reload the page.";
                                        break;
                                    default:
                                        message = data.statusText;
                                        break;
                                }

                                $(this).show();
                                $('#admincommand-input-group-error').html("");
                                $('#admincommand-input-group-error').html(message);
                            }
                        });
                        e.preventDefault();
                    });


                    $('.fancybox').fancybox();

                    @if($show_add)
                        $.fancybox.open({
                            padding: 0,

                            openEffect: 'elastic',
                            openSpeed: 150,

                            closeEffect: 'elastic',
                            closeSpeed: 150,

                            closeClick: true,

                            helpers: {
                                title : {
                                    type : 'over'
                                }
                            },
                            href: 'images/kos_tourny.jpg',
                            title: '<a class="text-bold" href="./tournament">Click here<a/> to visit tournaments page for more information.'
                        });
                    @endif
                });
            </script>
@endsection
