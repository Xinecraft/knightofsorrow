@extends('layouts.main')
@section('meta-desc',"Top 10 Section")
@section('title',"Top 10 of Server")
@section('styles')
    <style>
        .col-xs-5
        {
            width: 45.666667% !important;
        }
    </style>
@endsection
@section('main-container')
    <div class="content col-xs-9">
        @include('partials._statistics-navbar')
        <div class="row padding10">
        <div class="col-xs-5 panel panel-primary no-padding">
            <div class="panel-heading"><span class="">Top 10 Scorer</span></div>
            <div class="panel-body no-padding">
                <table class="table table-striped table-hover no-margin">
                    <thead><tr>
                        <th class="col-xs-1">#</th>
                        <th class="col-xs-1">Flag</th>
                        <th class="col-xs-1">Rank</th>
                        <th>Name</th>
                        <th class="text-right">Score</th>
                    </tr></thead>
                    @forelse($top10Score as $player)
                        <tr>
                            <th>{{ $position1++ }}</th>
                            <td>{!! Html::image($player->countryImage,$player->country->countryCode,['title' => $player->country->countryName, 'class' => 'tooltipster']) !!}</td>
                            <td>{!! Html::image($player->rankImage,'',['title' => $player->rank->name,'class' => 'tooltipster' ,'height' => '22px']) !!}</td>
                            <td class="color-main text-bold">{!! link_to_route('player-detail', $player->nameTrimmed, [$player->name]) !!}</td>
                            <td class="text-right">{{ $player->total_score }}</td>
                        </tr>
                    @empty
                        Empty
                    @endforelse
                </table>
            </div>
        </div>
        <div class="col-xs-5 col-xs-offset-1 panel panel-danger no-padding">
            <div class="panel-heading"><span class="">Top 10 Kill/Death Ratio</span> <small><i>( for kills > 99 )</i></small></div>
            <div class="panel-body no-padding">
                <table class="table table-striped table-hover no-margin">
                    <thead><tr>
                        <th class="col-xs-1">#</th>
                        <th class="col-xs-1">Flag</th>
                        <th class="col-xs-1">Rank</th>
                        <th>Name</th>
                        <th class="text-right">K/D</th>
                    </tr></thead>
                    @forelse($top10KD as $player)
                        <tr>
                            <th>{{ $position2++ }}</th>
                            <td>{!! Html::image($player->countryImage,$player->country->countryCode,['title' => $player->country->countryName, 'class' => 'tooltipster']) !!}</td>
                            <td>{!! Html::image($player->rankImage,'',['title' => $player->rank->name,'class' => 'tooltipster' ,'height' => '22px']) !!}</td>
                            <td class="color-main text-bold">{!! link_to_route('player-detail', $player->nameTrimmed, [$player->name]) !!}</td>
                            <td class="text-right">{{ $player->killdeath_ratio }}</td>
                        </tr>
                    @empty
                        Empty
                    @endforelse
                </table>
            </div>
        </div>
        </div>

        <div class="row padding10">
            <div class="col-xs-5 panel panel-info no-padding">
                <div class="panel-heading"><span class="">Top 10 Arrest/Arrested Ratio </span><small><i>( for arrests > 49 )</i></small></div>
                <div class="panel-body no-padding">
                    <table class="table table-striped table-hover no-margin">
                        <thead><tr>
                            <th class="col-xs-1">#</th>
                            <th class="col-xs-1">Flag</th>
                            <th class="col-xs-1">Rank</th>
                            <th>Name</th>
                            <th class="text-right">A/A</th>
                        </tr></thead>
                        @forelse($top10AAR as $player)
                            <tr>
                                <th>{{ $position3++ }}</th>
                                <td>{!! Html::image($player->countryImage,$player->country->countryCode,['title' => $player->country->countryName, 'class' => 'tooltipster']) !!}</td>
                                <td>{!! Html::image($player->rankImage,'',['title' => $player->rank->name,'class' => 'tooltipster' ,'height' => '22px']) !!}</td>
                                <td class="color-main text-bold">{!! link_to_route('player-detail', $player->nameTrimmed, [$player->name]) !!}</td>
                                <td class="text-right">{{ $player->arr_ratio }}</td>
                            </tr>
                        @empty
                            Empty
                        @endforelse
                    </table>
                </div>
            </div>
            <div class="col-xs-5 col-xs-offset-1 panel panel-success no-padding">
                <div class="panel-heading"><span class="">Top 10 Most Rounds Played</span></div>
                <div class="panel-body no-padding">
                    <table class="table table-striped table-hover no-margin">
                        <thead><tr>
                            <th class="col-xs-1">#</th>
                            <th class="col-xs-1">Flag</th>
                            <th class="col-xs-1">Rank</th>
                            <th>Name</th>
                            <th class="text-right">Rounds</th>
                        </tr></thead>
                        @forelse($top10Round as $player)
                            <tr>
                                <th>{{ $position4++ }}</th>
                                <td>{!! Html::image($player->countryImage,$player->country->countryCode,['title' => $player->country->countryName, 'class' => 'tooltipster']) !!}</td>
                                <td>{!! Html::image($player->rankImage,'',['title' => $player->rank->name,'class' => 'tooltipster' ,'height' => '22px']) !!}</td>
                                <td class="color-main text-bold">{!! link_to_route('player-detail', $player->nameTrimmed, [$player->name]) !!}</td>
                                <td class="text-right">{{ $player->total_round_played }}</td>
                            </tr>
                        @empty
                            Empty
                        @endforelse
                    </table>
                </div>
            </div>
        </div>

    <div class="row padding10">
        <div class="col-xs-5 panel panel-primary no-padding">
            <div class="panel-heading"><span class="">Top 10 Most Win</span></div>
            <div class="panel-body no-padding">
                <table class="table table-striped table-hover no-margin">
                    <thead><tr>
                        <th class="col-xs-1">#</th>
                        <th class="col-xs-1">Flag</th>
                        <th class="col-xs-1">Rank</th>
                        <th>Name</th>
                        <th class="text-right">Wins</th>
                    </tr></thead>
                    @forelse($top10Winners as $player)
                        <tr>
                            <th>{{ $position5++ }}</th>
                            <td>{!! Html::image($player->countryImage,$player->country->countryCode,['title' => $player->country->countryName, 'class' => 'tooltipster']) !!}</td>
                            <td>{!! Html::image($player->rankImage,'',['title' => $player->rank->name,'class' => 'tooltipster' ,'height' => '22px']) !!}</td>
                            <td class="color-main text-bold">{!! link_to_route('player-detail', $player->nameTrimmed, [$player->name]) !!}</td>
                            <td class="text-right">{{ $player->game_won }}</td>
                        </tr>
                    @empty
                        Empty
                    @endforelse
                </table>
            </div>
        </div>
        <div class="col-xs-5 col-xs-offset-1 panel panel-danger no-padding">
            <div class="panel-heading"><span class="">Top 10 Highest Score </span><small><i>( in one round )</i></small></div>
            <div class="panel-body no-padding">
                <table class="table table-striped table-hover no-margin">
                    <thead><tr>
                        <th class="col-xs-1">#</th>
                        <th class="col-xs-1">Flag</th>
                        <th class="col-xs-1">Rank</th>
                        <th>Name</th>
                        <th class="text-right">Score</th>
                    </tr></thead>
                    @forelse($top10HighestScore as $player)
                        <tr>
                            <th>{{ $position6++ }}</th>
                            <td>{!! Html::image($player->countryImage,$player->country->countryCode,['title' => $player->country->countryName, 'class' => 'tooltipster']) !!}</td>
                            <td>{!! Html::image($player->rankImage,'',['title' => $player->rank->name,'class' => 'tooltipster' ,'height' => '22px']) !!}</td>
                            <td class="color-main text-bold">{!! link_to_route('player-detail', $player->nameTrimmed, [$player->name]) !!}</td>
                            <td class="text-right">{{ $player->highest_score }}</td>
                        </tr>
                    @empty
                        Empty
                    @endforelse
                </table>
            </div>
        </div>
    </div>

    <div class="row padding10">
        <div class="col-xs-5 panel panel-info no-padding">
            <div class="panel-heading"><span class="">Top 10 Best Kill Streak</span></div>
            <div class="panel-body no-padding">
                <table class="table table-striped table-hover no-margin">
                    <thead><tr>
                        <th class="col-xs-1">#</th>
                        <th class="col-xs-1">Flag</th>
                        <th class="col-xs-1">Rank</th>
                        <th>Name</th>
                        <th class="text-right">KS</th>
                    </tr></thead>
                    @forelse($top10KillStreak as $player)
                        <tr>
                            <th>{{ $position7++ }}</th>
                            <td>{!! Html::image($player->countryImage,$player->country->countryCode,['title' => $player->country->countryName, 'class' => 'tooltipster']) !!}</td>
                            <td>{!! Html::image($player->rankImage,'',['title' => $player->rank->name,'class' => 'tooltipster' ,'height' => '22px']) !!}</td>
                            <td class="color-main text-bold">{!! link_to_route('player-detail', $player->nameTrimmed, [$player->name]) !!}</td>
                            <td class="text-right">{{ $player->best_killstreak }}</td>
                        </tr>
                    @empty
                        Empty
                    @endforelse
                </table>
            </div>
        </div>
        <div class="col-xs-5 col-xs-offset-1 panel panel-success no-padding">
            <div class="panel-heading"><span class="">Top 10 Best Arrest Streak</span></div>
            <div class="panel-body no-padding">
                <table class="table table-striped table-hover no-margin">
                    <thead><tr>
                        <th class="col-xs-1">#</th>
                        <th class="col-xs-1">Flag</th>
                        <th class="col-xs-1">Rank</th>
                        <th>Name</th>
                        <th class="text-right">AS</th>
                    </tr></thead>
                    @forelse($top10ArrestStreak as $player)
                        <tr>
                            <th>{{ $position8++ }}</th>
                            <td>{!! Html::image($player->countryImage,$player->country->countryCode,['title' => $player->country->countryName, 'class' => 'tooltipster']) !!}</td>
                            <td>{!! Html::image($player->rankImage,'',['title' => $player->rank->name,'class' => 'tooltipster' ,'height' => '22px']) !!}</td>
                            <td class="color-main text-bold">{!! link_to_route('player-detail', $player->nameTrimmed, [$player->name]) !!}</td>
                            <td class="text-right">{{ $player->best_arreststreak }}</td>
                        </tr>
                    @empty
                        Empty
                    @endforelse
                </table>
            </div>
        </div>
    </div>
    </div>

@endsection