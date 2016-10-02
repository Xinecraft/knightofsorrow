@extends('layouts.main')
@section('title'," Ranking | Teams")
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
            <h1 class="ng-binding text-center">Teams Ranking</h1>
            <!-- ngIf: ctrl.tournament.twitch --><!--end .tournament-twitch-->
        </div><!--end .container-->
    </div>
@endsection

@section('main-container')
    @include('partials._tournavbar')

    <div class="rounds panel panel-default">
        <div class="panel-heading"><strong>Teams Standing</strong></div>
        <div class="panel-body">
            <table id="" class="table table-striped table-hover no-margin table-bordered">
                <thead>
                <tr>
                    <th class="col-xs-1">Ranking</th>
                    <th class="col-xs-1">Flag</th>
                    <th class="col-xs-3">Name</th>
                    <th class="col-xs-1 tooltipster" title="Points awarded to team for reaching phase">Points</th>
                    <th class="col-xs-2">Tourns Played</th>
                    <th class="col-xs-1">Score</th>
                    <th class="col-xs-1 text-right tooltipster" title="Win/Lost Index">W/L Index</th>
                </tr>
                </thead>
                <tbody id="data-items">
                @foreach($teams as $team)
                    <tr class="item">
                        <td class="color-main text-bold">{{ $ranking++ }}</td>
                        <td class="text-muted"><img class="tooltipster" title="{{ $team->country->countryName }}" src="/images/flags/20_shiny/{{ $team->country->countryCode }}.png" alt="" height="22px"/></td>
                        <td class="color-main text-bold">{{ $team->name }}</td>
                        <td>{{ $team->rating or "None" }}</td>
                        <td>{{ $team->tourny_played }}</td>
                        <td>{!! $team->total_score !!}</td>
                        <td class="text-right">{{ $team->points or 0 }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        {!! $teams->appends(Request::except('page'))->render() !!}
        <div id="loading" class="text-center"></div>
    </div>

@endsection
