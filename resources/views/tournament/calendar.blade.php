@extends('layouts.main')
@section('title',"Tournaments Calendar")
@section('styles')
    <style>

        .card {
            box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12);
        }

        .card {
            margin-top: 10px;
            box-sizing: border-box;
            border-radius: 2px;
            background-clip: padding-box;
        }
        .card span.card-title {
            color: #FF5722;
            font-size: 24px;
            font-weight: 300;
            text-transform: uppercase;
        }

        .card .card-image {
            position: relative;
            overflow: hidden;
        }
        .card .card-image img {
            border-radius: 2px 2px 0 0;
            background-clip: padding-box;
            position: relative;
            z-index: -1;
        }
        .card .card-image span.card-title {
            position: absolute;
            bottom: 0;
            left: 0;
            padding: 16px;
        }
        .card .card-content {
            padding: 16px;
            border-radius: 0 0 2px 2px;
            background-clip: padding-box;
            box-sizing: border-box;
        }
        .card .card-content p {
            margin: 0;
            color: inherit;
        }
        .card .card-content span.card-title {
            line-height: 48px;
        }
        .card .card-action {
            border-top: 1px solid rgba(160, 160, 160, 0.2);
            padding: 16px;
        }
        .card .card-action a {
            color: #fff;
            margin-right: 16px;
            transition: color 0.3s ease;
            text-transform: uppercase;
        }
        .card .card-action a:hover {
            color: #fff;
            text-decoration: none;
        }
        .card-user{
            float: right;
            margin-bottom: -40px;
        }
        .userpic {
            width:100px;
            /*border-radius: 1000px !important;*/
            bottom: 47px;
            position: relative;
        }
        .card
        {
            margin:30px 30px 0 30px;
        }

    </style>
@endsection

@section('before-container')
    <div class="header wg-primary">
        <div class="container">
            <h1 class="ng-binding text-center">Tournaments Calendar</h1>
            <!-- ngIf: ctrl.tournament.twitch --><!--end .tournament-twitch-->
        </div><!--end .container-->
    </div>
@endsection

@section('main-container')
    @include('partials._tournavbar')
    <div class="col-xs-12 padding10 panel">

        @foreach($months as $month)
            <h3 style="padding: 10px;background-color: #e2e2e2;">{{ $month->first()->tournament_starts_at->format("F Y") }}</h3>
            @foreach($month as $tournament)
                <div class="media">
                    <div class="media-left">
                            <img class="media-object" style="width:100px;height:100px;" src="/uploaded_images/{{ $tournament->photo->url }}" alt="">
                    </div>
                    <div class="media-body">
                        <h4 class="media-heading text-bold">
                            <a href="{{ route('tournament.show',$tournament->slug) }}">{{ $tournament->name }}</a>
                        </h4>
                        <div class="col-xs-12 no-padding">
                            <div class="col-xs-4 no-padding" style="border-right: 5px solid dodgerblue">
                            <b class="text-info">{{ $tournament->game_type }}, {{ $tournament->getHumanReadableType() }}</b><br>
                            Registration Starts: <b>{{ $tournament->registration_starts_at->toDateString() }}</b><br>
                        Tournament Starts: <b>{{ $tournament->tournament_starts_at->toDateString() }}</b>
                            </div>
                            <div class="col-xs-4">
                                <br>
                                <b class="text-green">Past Champion</b>: <b>{!! $tournament->winnerteam == null ? "<i>None</i>" : link_to_route('tournament.team.show',$tournament->winnerteam->name,[$tournament->slug,$tournament->winnerteam->id])  !!}</b>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endforeach

    </div>
@endsection
