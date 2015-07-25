@extends('layouts.main')
@section('main-container')
    <div class="content col-md-9">
        <div class="row panel text-center live-server-summary">
            <div class="col-md-3 ls-swat4-summary">
                <span class="info-title">SWAT</span>
                <span class="info-value" id="ls-swat-score">0</span>
                <span class="info-base" id="ls-swat-wins">0 Wins</span>
            </div>
            <div class="col-md-3 ls-suspects-summary">
                <span class="info-title">SUSPECTS</span>
                <span class="info-value" id="ls-suspects-score">0</span>
                <span class="info-base" id="ls-suspects-wins">0 Wins</span>
            </div>
            <div class="col-md-3 ls-round-summary">
                <span class="info-title">ROUND</span>
                <span class="info-value" id="ls-round">0/0</span>
                <span class="info-base" id="ls-time">00:00</span>
            </div>
            <div class="col-md-3 ls-map-summary">
                <span class="info-title">MAP</span>
                <span class="info-value" id="ls-map-name">None</span>
                <span class="info-base" id="ls-next-map">Next: None</span>
            </div>
        </div> {{--Live Server Summary Ends --}}
        <div class="row">
            <div class="ls-players-and-top-player no-left-padding col-md-5">
                <div class="col-md-12 panel panel-default no-padding">
                    <div class="panel-heading"><span class="info-title">Online Players (<span id="ls-player-online">0</span>/<span id="ls-player-limit">0</span>)</span></div>
                    <div class="panel-body no-padding">
                        <table class="table table-striped table-hover no-margin" id="ls-player-table">
                            <th class="loading-pt-info">Loading Players table...</th>
                            <tr>
                                <td>Zishan</td>
                                <td>123</td>
                                <td>211</td>
                            </tr>
                            <tr>
                                <td>Ansari Khan</td>
                                <td>12</td>
                                <td>32</td>
                            </tr>
                            <tr>
                                <td>No Mans Sky</td>
                                <td>321</td>
                                <td>1</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="col-md-12 panel panel-default no-padding">
                    <div class="panel-heading"><span class="info-title">Top Players</span></div>
                    <div class="panel-body no-padding">
                        <table class="table table-striped table-hover no-margin">
                            <thead><tr>
                                <th class="col-md-1">#</th>
                                <th class="col-md-1">Flag</th>
                                <th class="col-md-1">Rank</th>
                                <th>Name</th>
                            </tr></thead>
                            @foreach($topPlayers as $player)
                                <tr>
                                    <th>{{ $player->position }}</th>
                                    <td>{!! Html::image($player->countryImage) !!}</td>
                                    <td>{!! Html::image($player->rankImage,'',['height' => '22px']) !!}</td>
                                    <td>{{ $player->name }}</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div> {{--Server Players and Top Players Wrapper Ends--}}
            <div class="col-md-7 panel panel-default no-padding">
                <div class="panel-heading"><span class="info-title">Server Viewer</span></div>
                <div class="panel-body ls-chats">
                    <div class="loading-pt-info">Loading Server Chat...</div>
                </div>
                <div class="panel-footer">
                    <p class="margin5 padding10 lorchat">Please <a class="ainorange" href="./?login">Login</a> or <a class="ainorange" href="./?register">Register</a> to Chat</p>
                </div>
            </div> {{--Live Server Viewer Ends--}}
        </div> {{--Live Server Players,Top Players and Server Viewer Row Ends--}}

        <div class="row">
            <div class="col-md-12 panel panel-default no-padding no-margin no-left-padding">
                <div class="panel-heading"><span class="info-title">Round Reports</span></div>
                <div class="panel-body">
                    <table class="table table-striped table-hover no-margin">
                        <thead><tr>
                            <th class="col-md-1">Round</th>
                            <th class="col-md-2">Time</th>
                            <th class="col-md-1">Swat</th>
                            <th class="col-md-2">Suspects</th>
                            <th>Map</th>
                            <th class="col-md-2 text-right">Date</th>
                        </tr></thead>
                        @foreach($latestGames as $round)
                            <tr>
                                <td>{{ $round->id }}</td>
                                <td>{{ $round->time }}</td>
                                <td>{{ $round->swat_score }}</td>
                                <td>{{ $round->suspects_score }}</td>
                                <td>{{ $round->mapName }}</td>
                                <td class="text-right">{{ $round->timeAgo }}</td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>

    </div> {{--Main Content Ends--}}
@endsection