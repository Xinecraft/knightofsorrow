@extends('layouts.main')
@section('meta-desc',"List of all players.")
@section('title',"Top Players")

@section('styles')
    <style>
        .pad10lr
        {
            padding: 0px 10px 0px 10px !important;
        }
        .pad10lf
        {
            padding: 0px 10px 0px 15px !important;
        }
        .pad10ll
        {
            padding: 0px 15px 0px 10px !important;
        }
    </style>
@endsection

@section('main-container')
    <div class="col-xs-9">
        @include('partials._statistics-navbar')
        <div class="row">
            <div class="col-xs-3 pad10lf">
                <div class="panel col-xs-12 pad10">
                    <div class="col-xs-3"><i class="fa fa-user fa-3x text-danger"></i></div>
                    <div class="col-xs-9 no-padding text-right"><b>Players Today:</b><br>{{ \App\PlayerTotal::todaycount() }}</div>
                </div>
            </div>
            <div class="col-xs-3 pad10lr">
                <div class="panel col-xs-12 pad10">
                    <div class="col-xs-3"><i class="fa fa-users fa-3x text-success"></i></div>
                    <div class="col-xs-9 no-padding text-right"><b>Total Players:</b><br>{{ \App\PlayerTotal::count() }}</div>
                </div>
            </div>
            <div class="col-xs-3 pad10lr">
                <div class="panel col-xs-12 pad10">
                    <div class="col-xs-3"><i class="fa fa-database fa-3x text-warning"></i></div>
                    <div class="col-xs-9 no-padding text-right"><b>Rounds Played:</b><br>{{ \App\Game::count() }}</div>
                </div>
            </div>
            <div class="col-xs-3 pad10ll">
                <div class="panel col-xs-12 pad10">
                    <div class="col-xs-3"><i class="fa fa-clock-o fa-3x text-info"></i></div>
                    <div class="col-xs-9 no-padding text-right"><b>Last updated:</b><br>{{ \App\PlayerTotal::first()->updated_at->diffForHumans() }}</div>
                </div>
            </div>
        </div>

        <div class="rounds panel panel-default">
            <div class="panel-heading"><strong>Top Players ({{ App\PlayerTotal::count() }})</strong></div>
            <div class="panel-body">
                <table id="" class="table table-striped table-hover no-margin">
                    <thead>
                    <tr>
                        <th class="col-xs-1">{!! sort_players_by('position','#') !!}</th>
                        <th class="col-xs-1">{!! sort_players_by('country_id','Flag') !!}</th>
                        <th class="col-xs-1">{!! sort_players_by('rank_id','Rank') !!}</th>
                        <th class="col-xs-3">{!! sort_players_by('name','Name') !!}</th>
                        <th class="col-xs-1">{!! sort_players_by('player_rating','Rating') !!}</th>
                        <th class="col-xs-1">{!! sort_players_by('total_score','Score') !!}</th>
                        <th class="col-xs-1">{!! sort_players_by('total_points','Points') !!}</th>
                        <th class="col-xs-1">{!! sort_players_by('total_time_played','Time(h:m)') !!}</th>
                        <th class="col-xs-2 text-right">{!! sort_players_by('last_game_id','Last Seen') !!}</th>
                    </tr>
                    </thead>
                    <tbody id="data-items">
                    @foreach($players as $player)
                        <tr class="item">
                            <td class="color-main text-bold">{{ $player->position }}</td>
                            <td class="text-muted"><img class="tooltipster" title="{{ $player->country->countryName }}" src="{{ $player->countryImage }}" alt="" height="22px"/></td>
                            <td><img class="tooltipster" title="{{ $player->rank->name }}" src="{{ $player->rankImage }}" alt="" height="22px"/></td>
                            <td class="color-main text-bold">{!! link_to_route('player-detail', $player->name, [$player->name]) !!}</td>
                            <td>{!! $player->playerRating !!}</td>
                            <td>{{ $player->total_score }}</td>
                            <td>{{ $player->total_points }}</td>
                            <td>{{ $player->timePlayed }}</td>
                            <td class="text-right">{!! link_to_route('round-detail',$player->lastGame->created_at->diffForHumans(),[$player->lastGame->id]) !!}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            {!! $players->appends(Request::except('page'))->render() !!}
            <div id="loading" class="text-center"></div>
        </div>

    </div>
@endsection