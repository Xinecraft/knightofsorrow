@extends('layouts.main')
@section('title',"Tournaments")
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
            <h1 class="ng-binding text-center">Tournaments</h1>
            <a href="{{ route('tournament.calendar') }}" class="pull-right btn btn-info">Open Calendar</a>
            <!-- ngIf: ctrl.tournament.twitch --><!--end .tournament-twitch-->
        </div><!--end .container-->
    </div>
@endsection

@section('main-container')
    <div class="col-xs-12 container padding10">
        <div class="alert alert-info text-center">
            Please read the <a class="text-bold" href="{{ route('tournament.guidelines') }}">Guidelines</a> before joining any tournament
        </div>
        @foreach(array_chunk($tournaments->all(),2) as $tours)
            <div class="row">
            @forelse($tours as $tournament)
            <div class="card col-xs-5 panel no-padding">
                <div class="card-image" style="min-height:250px; background-image: url('uploaded_images/{{ $tournament->photo->url }}');background-size: cover">
                    <span class="card-title">{{ $tournament->name }}</span>
                </div>
                <div class="card-user">
                    <img class="img-responsive userpic" src="/images/swat4.png">
                </div>
                <div class="card-content">
                    <table style="font-size: large" class="table table-striped table-hover table-bordered">
                        <tbody><tr>
                            <td>Game Name</td>
                            <td>
                                <b>{{ $tournament->game_name }}</b>
                            </td>
                        </tr>
                        <tr>
                            <td>Game Type</td>
                            <td>
                                <b>{{ $tournament->game_type }}</b>
                            </td>
                        </tr>
                        <tr>
                            <td>Tournament Type</td>
                            <td>
                                <b>{{ $tournament->getHumanReadableType() }}</b>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Tournament Status
                            </td>
                            <td>
                                <b>{!! $tournament->getHumanReadableStatus()  !!}</b>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Participants
                            </td>
                            <td>
                                <b>{!! $tournament->teams()->where('team_status','1')->count() . " / " . $tournament->maximum_participants  !!}</b>
                            </td>
                        </tr>
                        </tbody></table>
                </div>

                <div class="card-action">
                    <a class="btn btn-primary btn-block btn-sm" href="{{ route('tournament.show',$tournament->slug) }}">View Details</a>
                </div>
            </div>
        @empty
        @endforelse
        </div>
     @endforeach


    </div>
@endsection