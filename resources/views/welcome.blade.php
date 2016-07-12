@extends('layouts.main')
@section('main-container')
    <div class="content col-xs-9">
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
                    <div class="panel-heading"><span class="info-title">Online Players (<span id="ls-player-online">0</span>/<span id="ls-player-limit">0</span>)</span></div>
                    <div class="panel-body no-padding" id="ls-player-total-div">
                        <table class="table table-striped table-hover no-margin" id="ls-player-table">
                            <th class="loading-pt-info text-center" style="padding: 15px;font-size: 15px">Loading Players table...</th>
                        </table>
                    </div>
                </div>
                <div class="col-xs-12 panel panel-default no-padding">
                    <div class="panel-heading"><span class="info-title">Top Players</span></div>
                    <div class="panel-body no-padding">

                        <table class="table table-striped table-hover no-margin">
                            <thead style="font-size: 80%"><tr>
                                <th class="col-xs-1">#</th>
                                <th class="col-xs-1">Flag</th>
                                <th class="col-xs-1">Rank</th>
                                <th>Name</th>
                                <th class="text-right">Rating</th>
                            </tr></thead>
                            @forelse($topPlayers as $player)
                                <tr>
                                    <th>{{ $player->position }}</th>
                                    <td>{!! Html::image($player->countryImage,$player->country->countryCode,['title' => $player->country->countryName, 'class' => 'tooltipster']) !!}</td>
                                    <td>{!! Html::image($player->rankImage,'',['title' => $player->rank->name,'class' => 'tooltipster' ,'height' => '22px']) !!}</td>
                                    <td class="color-main text-bold">{!! link_to_route('player-detail', $player->name, [$player->name]) !!}</td>
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
                    <small class="pull-right"><i><b><a href="{{ route('chat.index') }}">» view all</a></b></i></small>
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
                                   placeholder="Type your message here..." autocomplete="off" />
                        <span class="input-group-btn">
                            <button class="btn btn-primary" id="btn-chat">
                                Send
                            </button>
                        </span>
                        </div>
                        <div id="serverchat-input-group-error" class="help-block"></div>
                        {!! Form::close() !!}
                    @else
                        <div class='panel nomargin padding10 text-muted'><b>{!!  link_to('/auth/login','Login') !!}
                                or {!! link_to('/auth/register', 'Register') !!} to chat with in-game players.</b></div>
                    @endif
                </div>

            </div> {{--Live Server Viewer Ends--}}
        </div> {{--Live Server Players,Top Players and Server Viewer Row Ends--}}

        <div class="row hidden-xs round-reports">
            <div style="" class="col-xs-12 panel panel-default no-padding no-margin no-left-padding">
                <div class="panel-heading"><span class="info-title">Round Reports</span></div>
                <div class="panel-body">
                    <table class="table table-striped table-hover no-margin">
                        <thead><tr>
                            <th class="col-xs-1">Round</th>
                            <th class="col-xs-2">Time</th>
                            <th class="col-xs-1">Swat</th>
                            <th class="col-xs-2">Suspects</th>
                            <th>Map</th>
                            <th class="col-xs-2 text-right">Date</th>
                        </tr></thead>
                        <tbody id="data-items" class="roundstabledata">
                        @foreach($latestGames as $round)
                            <tr class="item pointer-cursor" data-id="{{ $round->id }}">
                                <td class="color-main text-bold">{!! link_to_route('round-detail',$round->index,[$round->id]) !!}</td>
                                <td class="text-muted">{{ $round->time }}</td>
                                <td>{!! $round->swatScoreWithColor !!}</td>
                                <td>{!! $round->suspectsScoreWithColor !!}</td>
                                <td>{{ $round->mapName }}</td>
                                <td class="text-right">{{ $round->timeAgo }}</td>
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
                                    <li role="presentation" class=""><a class="ainorange" href="#pastweek" aria-controls="pastweek" role="tab" data-toggle="tab">Past Week</a></li>
                                    <li role="presentation"><a class="ainorange" href="#pastmonth" aria-controls="pastmonth" role="tab" data-toggle="tab">Past Month</a></li>
                                    <li role="presentation"><a class="ainorange" href="#pastyear" aria-controls="pastyear" role="tab" data-toggle="tab">Past Year</a></li>
                                    <li role="presentation" class="active"><a class="ainorange" href="#alltime" aria-controls="alltime" role="tab" data-toggle="tab">All Time</a></li>
                                </ul>
                                <!-- Tab panes -->
                                <div class="tab-content" style="background-color: #ffffff;border-left: 1px solid #ddd;border-bottom: 1px solid #ddd;border-right: 1px solid #ddd;">
                                    <div role="tabpanel" class="tab-pane" id="pastweek"><table class="table borderless playerrecordtable">
                                            <tbody><tr>
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
                                                    <span class="small">({{ $PastWeek->totalArrests->totalarrests }})</span>
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
                                                    <span class="small">({{ $PastWeek->highestScore->highestscore }})</span>
                                                </td>
                                                <td class="col-4">
                                                    <div class="player-records-icon arrested"></div>
                                                </td>
                                                <td class="col-5">
                                                    Arrested
                                                </td>
                                                <td class="col-6">
                                                    {!! link_to_route('player-detail',$PastWeek->totalArrested->name,[$PastWeek->totalArrested->name]) !!}
                                                    <span class="small">({{ $PastWeek->totalArrested->totalarrested }})</span>
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
                                                    <span class="small">({{ round($PastWeek->bestScorePerMin->toArray()['scorepermin'],2) }})</span>
                                                </td>
                                                <td class="col-4">
                                                    <div class="player-records-icon arreststreak"></div>
                                                </td>
                                                <td class="col-5">
                                                    Arrest Streak
                                                </td>
                                                <td class="col-6">
                                                    {!! link_to_route('player-detail',$PastWeek->bestArrestStreak->name,[$PastWeek->bestArrestStreak->name]) !!}
                                                    <span class="small">({{ $PastWeek->bestArrestStreak->best_arrest_streak }})</span>
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
                                                    <span class="small">({{ App\Server\Utils::getHMbyS($PastWeek->totalTimePlayed->totaltimeplayed,"%dh %dm") }})</span>
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
                                                    <span class="small">({{ $PastWeek->bestDeathStreak->best_death_streak }})</span>
                                                </td>
                                                <td class="col-4">
                                                    <div class="player-records-icon deaths"></div>
                                                </td>
                                                <td class="col-5">
                                                    Deaths
                                                </td>
                                                <td class="col-6">
                                                    {!! link_to_route('player-detail',$PastWeek->totalDeaths->name,[$PastWeek->totalDeaths->name]) !!}
                                                    <span class="small">({{ $PastWeek->totalDeaths->totaldeaths }})</span>
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
                                                    <span class="small">({{ $PastWeek->totalTeamKills->totalteamkills }})</span>
                                                </td>
                                                <td class="col-4">
                                                    <div class="player-records-icon killstreak"></div>
                                                </td>
                                                <td class="col-5">
                                                    Kill Streak
                                                </td>
                                                <td class="col-6">
                                                    {!! link_to_route('player-detail',$PastWeek->bestKillStreak->name,[$PastWeek->bestKillStreak->name]) !!}
                                                    <span class="small">({{ $PastWeek->bestKillStreak->best_kill_streak }})</span>
                                                </td>
                                            </tr>
                                            </tbody></table>
                                    </div>
                                    <div role="tabpanel" class="tab-pane" id="pastmonth"><table class="table borderless playerrecordtable">
                                            <tbody><tr>
                                                <td class="col-1">
                                                    <div class="player-records-icon totalscore"></div>
                                                </td>
                                                <td class="col-2">
                                                    Total Score
                                                </td>
                                                <td class="col-3">
                                                    {!! link_to_route('player-detail',$PastMonth->totalScore->name,[$PastMonth->totalScore->name]) !!}
                                                    <span class="small">({{ $PastMonth->totalScore->totalscore }})</span>
                                                </td>
                                                <td class="col-4">
                                                    <div class="player-records-icon arrests"></div>
                                                </td>
                                                <td class="col-5">
                                                    Arrests
                                                </td>
                                                <td class="col-6">
                                                    {!! link_to_route('player-detail',$PastMonth->totalArrests->name,[$PastMonth->totalArrests->name]) !!}
                                                    <span class="small">({{ $PastMonth->totalArrests->totalarrests }})</span>
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
                                                    <span class="small">({{ $PastMonth->highestScore->highestscore }})</span>
                                                </td>
                                                <td class="col-4">
                                                    <div class="player-records-icon arrested"></div>
                                                </td>
                                                <td class="col-5">
                                                    Arrested
                                                </td>
                                                <td class="col-6">
                                                    {!! link_to_route('player-detail',$PastMonth->totalArrested->name,[$PastMonth->totalArrested->name]) !!}
                                                    <span class="small">({{ $PastMonth->totalArrested->totalarrested }})</span>
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
                                                    <span class="small">({{ round($PastMonth->bestScorePerMin->toArray()['scorepermin'],2) }})</span>
                                                </td>
                                                <td class="col-4">
                                                    <div class="player-records-icon arreststreak"></div>
                                                </td>
                                                <td class="col-5">
                                                    Arrest Streak
                                                </td>
                                                <td class="col-6">
                                                    {!! link_to_route('player-detail',$PastMonth->bestArrestStreak->name,[$PastMonth->bestArrestStreak->name]) !!}
                                                    <span class="small">({{ $PastMonth->bestArrestStreak->best_arrest_streak }})</span>
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
                                                    <span class="small">({{ App\Server\Utils::getHMbyS($PastMonth->totalTimePlayed->totaltimeplayed,"%dh %dm") }})</span>
                                                </td>
                                                <td class="col-4">
                                                    <div class="player-records-icon kills"></div>
                                                </td>
                                                <td class="col-5">Kills</td>
                                                <td class="col-6">
                                                    {!! link_to_route('player-detail',$PastMonth->totalKills->name,[$PastMonth->totalKills->name]) !!}
                                                    <span class="small">({{ $PastMonth->totalKills->totalkills }})</span>
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
                                                    <span class="small">({{ $PastMonth->bestDeathStreak->best_death_streak }})</span>
                                                </td>
                                                <td class="col-4">
                                                    <div class="player-records-icon deaths"></div>
                                                </td>
                                                <td class="col-5">
                                                    Deaths
                                                </td>
                                                <td class="col-6">
                                                    {!! link_to_route('player-detail',$PastMonth->totalDeaths->name,[$PastMonth->totalDeaths->name]) !!}
                                                    <span class="small">({{ $PastMonth->totalDeaths->totaldeaths }})</span>
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
                                                    <span class="small">({{ $PastMonth->totalTeamKills->totalteamkills }})</span>
                                                </td>
                                                <td class="col-4">
                                                    <div class="player-records-icon killstreak"></div>
                                                </td>
                                                <td class="col-5">
                                                    Kill Streak
                                                </td>
                                                <td class="col-6">
                                                    {!! link_to_route('player-detail',$PastMonth->bestKillStreak->name,[$PastMonth->bestKillStreak->name]) !!}
                                                    <span class="small">({{ $PastMonth->bestKillStreak->best_kill_streak }})</span>
                                                </td>
                                            </tr>
                                            </tbody></table>
                                    </div>
                                    <div role="tabpanel" class="tab-pane" id="pastyear"><table class="table borderless playerrecordtable">
                                            <tbody><tr>
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
                                                    <span class="small">({{ $PastYear->totalArrests->totalarrests }})</span>
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
                                                    <span class="small">({{ $PastYear->highestScore->highestscore }})</span>
                                                </td>
                                                <td class="col-4">
                                                    <div class="player-records-icon arrested"></div>
                                                </td>
                                                <td class="col-5">
                                                    Arrested
                                                </td>
                                                <td class="col-6">
                                                    {!! link_to_route('player-detail',$PastYear->totalArrested->name,[$PastYear->totalArrested->name]) !!}
                                                    <span class="small">({{ $PastYear->totalArrested->totalarrested }})</span>
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
                                                    <span class="small">({{ round($PastYear->bestScorePerMin->toArray()['scorepermin'],2) }})</span>
                                                </td>
                                                <td class="col-4">
                                                    <div class="player-records-icon arreststreak"></div>
                                                </td>
                                                <td class="col-5">
                                                    Arrest Streak
                                                </td>
                                                <td class="col-6">
                                                    {!! link_to_route('player-detail',$PastYear->bestArrestStreak->name,[$PastYear->bestArrestStreak->name]) !!}
                                                    <span class="small">({{ $PastYear->bestArrestStreak->best_arrest_streak }})</span>
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
                                                    <span class="small">({{ App\Server\Utils::getHMbyS($PastYear->totalTimePlayed->totaltimeplayed,"%dh %dm") }})</span>
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
                                                    <span class="small">({{ $PastYear->bestDeathStreak->best_death_streak }})</span>
                                                </td>
                                                <td class="col-4">
                                                    <div class="player-records-icon deaths"></div>
                                                </td>
                                                <td class="col-5">
                                                    Deaths
                                                </td>
                                                <td class="col-6">
                                                    {!! link_to_route('player-detail',$PastYear->totalDeaths->name,[$PastYear->totalDeaths->name]) !!}
                                                    <span class="small">({{ $PastYear->totalDeaths->totaldeaths }})</span>
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
                                                    <span class="small">({{ $PastYear->totalTeamKills->totalteamkills }})</span>
                                                </td>
                                                <td class="col-4">
                                                    <div class="player-records-icon killstreak"></div>
                                                </td>
                                                <td class="col-5">
                                                    Kill Streak
                                                </td>
                                                <td class="col-6">
                                                    {!! link_to_route('player-detail',$PastYear->bestKillStreak->name,[$PastYear->bestKillStreak->name]) !!}
                                                    <span class="small">({{ $PastYear->bestKillStreak->best_kill_streak }})</span>
                                                </td>
                                            </tr>
                                            </tbody></table>
                                    </div>
                                    <div role="tabpanel" class="tab-pane active" id="alltime"><table class="table borderless playerrecordtable">
                                            <tbody><tr>
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
                                                    <span class="small">({{ $AllTime->totalArrests->totalarrests }})</span>
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
                                                    <span class="small">({{ $AllTime->highestScore->highestscore }})</span>
                                                </td>
                                                <td class="col-4">
                                                    <div class="player-records-icon arrested"></div>
                                                </td>
                                                <td class="col-5">
                                                    Arrested
                                                </td>
                                                <td class="col-6">
                                                    {!! link_to_route('player-detail',$AllTime->totalArrested->name,[$AllTime->totalArrested->name]) !!}
                                                    <span class="small">({{ $AllTime->totalArrested->totalarrested }})</span>
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
                                                    <span class="small">({{ round($AllTime->bestScorePerMin->toArray()['scorepermin'],2) }})</span>
                                                </td>
                                                <td class="col-4">
                                                    <div class="player-records-icon arreststreak"></div>
                                                </td>
                                                <td class="col-5">
                                                    Arrest Streak
                                                </td>
                                                <td class="col-6">
                                                    {!! link_to_route('player-detail',$AllTime->bestArrestStreak->name,[$AllTime->bestArrestStreak->name]) !!}
                                                    <span class="small">({{ $AllTime->bestArrestStreak->best_arrest_streak }})</span>
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
                                                    <span class="small">({{ App\Server\Utils::getHMbyS($AllTime->totalTimePlayed->totaltimeplayed,"%dh %dm") }})</span>
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
                                                    <span class="small">({{ $AllTime->bestDeathStreak->best_death_streak }})</span>
                                                </td>
                                                <td class="col-4">
                                                    <div class="player-records-icon deaths"></div>
                                                </td>
                                                <td class="col-5">
                                                    Deaths
                                                </td>
                                                <td class="col-6">
                                                    {!! link_to_route('player-detail',$AllTime->totalDeaths->name,[$AllTime->totalDeaths->name]) !!}
                                                    <span class="small">({{ $AllTime->totalDeaths->totaldeaths }})</span>
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
                                                    <span class="small">({{ $AllTime->totalTeamKills->totalteamkills }})</span>
                                                </td>
                                                <td class="col-4">
                                                    <div class="player-records-icon killstreak"></div>
                                                </td>
                                                <td class="col-5">
                                                    Kill Streak
                                                </td>
                                                <td class="col-6">
                                                    {!! link_to_route('player-detail',$AllTime->bestKillStreak->name,[$AllTime->bestKillStreak->name]) !!}
                                                    <span class="small">({{ $AllTime->bestKillStreak->best_kill_streak }})</span>
                                                </td>
                                            </tr>
                                            </tbody></table>
                                    </div>
                                </div>
                            </div>
                            <!--/Tab Ends-->
                        </div>
                    </div>
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

                <div class="panel-body">
                    @forelse($activeUsers as $user)
                        <a class="{{ $user->isAdmin() ? "text-green" : "" }}" style="margin-right:1em" href="{{ route('user.show',$user->username) }}">
                            <strong class="">{{ $user->displayName() }}</strong>
                        </a>
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
        $(document).ready(function() {
            function startInterval() {

                //-----------------------------------------------------------------------
                // Sending AJAX request to SWAT4 Server to display it live
                //-----------------------------------------------------------------------
                var refreshId = setInterval(function () {
                    $('.ls-chats').load("api/server-chats/get/");

                    $.ajax({
                        url: 'api/server-query/get', //the script to call to get data
                        data: "", //you can insert url argumnets here to pass to api.php for example "id=5&parent=6"
                        dataType: 'json', //data format
                        success: function (data)          //on recieve of reply
                        {

                            var hostname = data['hostname'];
                            var version = data['patch'];               //get server version
                            var hostname = data['hostname'];            //get server hostname
                            var gametype = data['gametype'];             //get server gametype 0-bs
                            var map = data['map'];             // or data.map         //Map Encoded into MapID
                            var player_num = data['players_current'];            // Number of Players in Server
                            var player_max = data['players_max'];           // Max Capacity of Server
                            var round_num = data['round'];          // Round Index
                            var round_max = data['numrounds'];          // Round limit per Map
                            //    var timepassed = data[10]  ;         // Time Escaped since Map Loaded
                            //    var actualtimepass = data[11];         // Time passed since Game Started
                            var timeleft = data['timeleft'];       // Round time limit of Round
                            var vict_swat = data['swatwon'];       // Rounds won by SWAT
                            var vict_sus = data['suspectswon'];       // Rounds won by Suspects
                            var swat_score = data['swatscore'];        // Round's SWAT score
                            var sus_score = data['suspectsscore'];     // Round's Suspect score

                            //    var outcome =   data[17] ;           // Outcome of round
                            var nextmap = data['nextmap'];

                            //    var mins,secs,time;
                            //    time = roundtimelimit - timepassed;
                            var mins = parseInt(timeleft / 60);
                            var secs = timeleft % 60;
                            //    round_num = parseInt(round_num)+1;
                            //map = getMapFromID(map);
                            swat_score = parseInt(swat_score);
                            sus_score = parseInt(sus_score);
                            if (isNaN(swat_score) || isNaN(sus_score)) {
                                swat_score = '0';
                                sus_score = '0';
                            }
                            else (sus_score != swat_score)
                            {
                                if (swat_score > sus_score) {
                                    swat_score = '<font color="green">' + swat_score;
                                    sus_score = '<font color="B50A0A">' + sus_score;
                                }
                                else if (swat_score < sus_score) {
                                    sus_score = '<font color="green">' + sus_score;
                                    swat_score = '<font color="B50A0A">' + swat_score;
                                }
                                else {

                                }
                            }
                            if (isNaN(player_num))
                                player_num = '0';
                            if (isNaN(player_max) || player_max == '-') {
                                player_max = '0';
                                mins = 0;
                                secs = 0;
                                map = "None";
                                nextmap = "None";
                            }
                            if (isNaN(vict_swat))
                                vict_swat = '0';
                            if (isNaN(vict_sus))
                                vict_sus = '0';
                            if (isNaN(round_num))
                                round_num = '0';
                            if (isNaN(round_max))
                                round_max = '0';
                            if (isNaN(mins)) {
                                mins = 0;
                                secs = 0;
                            }


                            $('#ls-swat-score').html(swat_score);
                            $('#ls-swat-wins').html(vict_swat + " wins");
                            $('#ls-suspects-score').html(sus_score);
                            $('#ls-suspects-wins').html(vict_sus + " wins");

                            $('#ls-round').text(round_num + '/' + round_max);
                            $('#ls-time').text(pad(mins) + ":" + pad(secs));

                            $('#ls-map-name').text(map);
                            $('#ls-next-map').text("Next : " + getMapByClass(nextmap));
                            $('#ls-player-online').text(player_num);
                            $('#ls-player-limit').text(player_max);


                            var playertable = "<thead><tr><th class='col-xs-1'>Flag</th><th class='col-xs-7'>Name</th><th class='col-xs-2'>Score</th><th class='text-right col-xs-2'>Ping</th></tr></thead><tbody id='ls-player-table-body'></tbody>";

                            var i = 0;
                            $.each(data.players, function () {

                                //console.log(data['players'][i]['team']);
                                playertable = playertable + "<tr class='text-bold'><td><img src='http://"+window.location.hostname+"/images/flags/20/"+data['players'][i]['countryCode']+".png' title='"+data['players'][i]['countryName']+"' class='' alt='"+data['players'][i]['countryCode']+"'></td>";

                                if (data['players'][i]['team'] == 0) {
                                    data['players'][i]['name'] = "<font color='blue'>" + data['players'][i]['name'];
                                }
                                else if (data['players'][i]['team'] == 1) {
                                    data['players'][i]['name'] = "<font color='red'>" + data['players'][i]['name'];
                                }
                                else {
                                    data['players'][i]['name'] = "<font color=''>" + data['players'][i]['name'];
                                }

                                playertable = playertable + "          \
                    <td>" + data['players'][i]['name'] + "</td>                    \
                    <td>" + data['players'][i]['score'] + "</td>                                  \
                    <td class='text-right'>" + data['players'][i]['ping'] + "</td>                                  \
                    </tr> ";
                                i++;
                            });
                            if (player_num != '0' && player_max != '0') {
                                $('#ls-player-table').html(playertable);
                            }
                            else if (player_max == '0' || player_max == '-') {
                                $('#ls-player-table').html('<th class="text-center" style="padding: 15px;font-size: 13px;border: 1px solid">Server Down for some reason.<br><small>Please return later.</small></th>');
                            }
                            else {
                                $('#ls-player-table').html('<th class="text-center" style="padding: 15px;font-size: 13px;border: 1px solid">No Player Online</th>');
                            }
//                    for(i=0;i<=player_num;i++)
//                    {
//                        $('#liveplayerdata').html(data['players'][0]['name']);
//                    }

                        }
                    });
                }, 2000);
            }

            startInterval();
        });
    </script>
@endsection