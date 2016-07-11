@extends('layouts.main')
@section('meta-desc',"Server statistics of country $countryName")
@section('title',$countryName)

@section('main-container')
    <div class="col-xs-9">
        @include('partials._statistics-navbar')

        <div class="rounds panel panel-default">
            <div class="panel-heading"><strong>Top Players of {{ $countryName }} ({{ App\PlayerTotal::where('country_id',$players->first()->country_id)->count() }})</strong> <img class="tooltipster right" title="{{ $players->first()->country->countryName }}" src="{{ $players->first()->countryImage }}" alt="" height="22px"/> </div>
            <div class="panel-body">
                <table id="" class="table table-striped table-hover no-margin">
                    <thead>
                    <tr>
                        <th class="col-xs-1">{!! sort_country_players_by('position','#',$countryId,$countryName) !!}</th>
                        <th class="col-xs-1">Flag</th>
                        <th class="col-xs-1">{!! sort_country_players_by('rank_id','Rank',$countryId,$countryName) !!}</th>
                        <th class="col-xs-3">{!! sort_country_players_by('name','Name',$countryId,$countryName) !!}</th>
                        <th class="col-xs-1">{!! sort_country_players_by('player_rating','Rating',$countryId,$countryName) !!}</th>
                        <th class="col-xs-1">{!! sort_country_players_by('total_score','Score',$countryId,$countryName) !!}</th>
                        <th class="col-xs-1">{!! sort_country_players_by('total_points','Points',$countryId,$countryName) !!}</th>
                        <th class="col-xs-1">{!! sort_country_players_by('total_time_played','Time(h:m)',$countryId,$countryName) !!}</th>
                        <th class="col-xs-2 text-right">{!! sort_country_players_by('last_game_id','Last Seen',$countryId,$countryName) !!}</th>
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