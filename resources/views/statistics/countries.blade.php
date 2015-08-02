@extends('layouts.main')
@section('meta-desc','Server statistics per country')
@section('title','Countries')

@section('main-container')
    <div class="col-md-9">
        @include('partials._statistics-navbar')

        <div class="rounds panel panel-default">
            <div class="panel-heading"><strong>All Countries ({{ $players->count() }})</strong></div>
            <div class="panel-body">
                <table id="" class="table table-striped table-hover no-margin">
                    <thead>
                    <tr>
                        <th class="col-md-1">#</th>
                        <th class="col-md-1">Flag</th>
                        <th class="col-md-3">{!! sort_countries_by('country_id','Name') !!}</th>
                        <th class="col-md-2">{!! sort_countries_by('total_players','Total Players') !!}</th>
                        <th class="col-md-2">{!! sort_countries_by('total_score','Total Score') !!}</th>
                        <th class="col-md-2">{!! sort_countries_by('total_points','Total Points') !!}</th>
                        <th class="col-md-2 text-right">{!! sort_countries_by('total_time_played','Time') !!}</th>
                    </tr>
                    </thead>
                    <tbody id="data-items">
                    @foreach($players as $player)
                        <tr class="item">
                            <td class="text-bold">{{ $position++ }}</td>
                            <td class="text-muted"><img class="tooltipster" title="{{ $player->country->countryName }}" src="{{ $player->countryImage }}" alt="" height="22px"/></td>
                            <td class="color-main text-bold">{!! link_to_route('country-detail', $player->country->countryName, [$player->country_id,$player->country->countryName]) !!}</td>
                            <td>{{ $player->total_players }}</td>
                            <td>{{ $player->total_score }}</td>
                            <td>{{ $player->total_points }}</td>
                            <td class="text-right">{{ \App\Server\Utils::getHMbyS($player->total_time_played,"%dh %dm") }}</td>
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