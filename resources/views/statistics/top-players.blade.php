@extends('layouts.main')

@section('main-container')
    <div class="col-md-9">
        @include('partials._statistics-navbar')

        <div class="rounds panel panel-default">
            <div class="panel-heading"><strong>Top Players ({{ App\PlayerTotal::count() }})</strong></div>
            <div class="panel-body">
                <table id="" class="table table-striped table-hover no-margin">
                    <thead>
                    <tr>
                        <th class="col-md-1">{!! sort_players_by('position','#') !!}</th>
                        <th class="col-md-1">{!! sort_players_by('country_id','Flag') !!}</th>
                        <th class="col-md-1">{!! sort_players_by('rank_id','Rank') !!}</th>
                        <th class="col-md-3">{!! sort_players_by('name','Name') !!}</th>
                        <th class="col-md-1">{!! sort_players_by('player_rating','Rating') !!}</th>
                        <th class="col-md-1">{!! sort_players_by('total_score','Score') !!}</th>
                        <th class="col-md-1">{!! sort_players_by('total_points','Points') !!}</th>
                        <th class="col-md-1">{!! sort_players_by('total_time_played','Time') !!}</th>
                        <th class="col-md-2 text-right">{!! sort_players_by('last_game_id','Last Seen') !!}</th>
                    </tr>
                    </thead>
                    <tbody id="data-items">
                    @foreach($players as $player)
                        <tr class="item">
                            <td class="color-main text-bold">{{ $player->position }}</td>
                            <td class="text-muted"><img class="tooltipster" title="{{ $player->country->countryName }}" src="{{ $player->countryImage }}" alt="" height="22px"/></td>
                            <td><img class="tooltipster" title="{{ $player->rank->name }}" src="{{ $player->rankImage }}" alt="" height="22px"/></td>
                            <td class="color-main text-bold">{!! link_to_route('player-detail', $player->name, [$player->id,$player->name]) !!}</td>
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
            {!! $players->render() !!}
            <div id="loading" class="text-center"></div>
        </div>

    </div>
@endsection