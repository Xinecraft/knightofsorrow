@extends('layouts.main')
@section('title'," Ranking | Player")
@section('styles')
    <style>

        .table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td
        {
            padding:20px !important;
            text-align: center !important;
        }
    </style>
@endsection

@section('before-container')
    <div class="header wg-primary">
        <div class="container">
            <h1 class="ng-binding text-center">Players Ranking</h1>
            <!-- ngIf: ctrl.tournament.twitch --><!--end .tournament-twitch-->
        </div><!--end .container-->
    </div>
@endsection

@section('main-container')
    @include('partials._tournavbar')

    <div class="rounds panel panel-default">
        <div class="panel-heading"><strong>Players Standing</strong></div>
        <div class="panel-body">
            <table id="" class="table table-striped table-hover no-margin table-bordered">
                <thead>
                <tr>
                    <th class="col-xs-1">Ranking</th>
                    <th class="col-xs-1">Flag</th>
                    <th class="col-xs-3">Name</th>
                    <th class="col-xs-1">Points</th>
                    <th class="col-xs-2">Tourny Played</th>
                    <th class="col-xs-1">Score</th>
                </tr>
                </thead>
                <tbody id="data-items">
                @foreach($players as $player)
                    <tr class="item">
                        <td class="color-main text-bold">{{ $ranking++ }}</td>
                        <td class="text-muted"><img class="tooltipster" title="{{ $player->country->countryName }}" src="/images/flags/20_shiny/{{ $player->country->countryCode }}.png" alt="" height="22px"/></td>
                        <td class="color-main text-bold">{!! link_to_route('user.show', $player->displayName(), [$player->username]) !!}</td>
                        <td>{!! $player->points or "None" !!}</td>
                        <td>{{ $player->tourny_played or "None" }}</td>
                        <td>{!! $player->total_score or "None" !!}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        {{-- $players->appends(Request::except('page'))->render() --}}
        <div id="loading" class="text-center"></div>
    </div>

@endsection
