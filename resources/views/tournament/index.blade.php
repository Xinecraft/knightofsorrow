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
            padding: 5px;
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
            padding: 5px;
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
            <!-- ngIf: ctrl.tournament.twitch --><!--end .tournament-twitch-->
        </div><!--end .container-->
    </div>
@endsection

@section('main-container')
    <div class="col-xs-12 padding10">
        @include('partials._tournavbar')

        <div class="row">
            <div class="col-xs-4">
                <div class="panel pad5" style="padding: 10px !important;">
                    <h4 class="" style="margin:0 0 10px 0;border-bottom:2px dashed grey">On Going Tourny</h4>
                    @if($ongoing == null)
                        <p class=""><i>No Ongoing Tournament</i></p>
                    @else
                        <div class="card no-padding no-margin">
                            <div class="card-image" style="min-height:250px; background-image: url('uploaded_images/{{ $ongoing->photo->url }}');background-size: cover">
                                <span class="card-title">{{ $ongoing->name }}</span>
                            </div>
                            <div class="card-user">
                                {{--<img class="img-responsive userpic" src="/images/swat4.png">--}}
                            </div>
                            <div class="card-content">
                                <table style="font-size: large" class="no-margin table table-striped table-hover table-bordered">
                                    <tbody><tr>
                                        <td>Game Name</td>
                                        <td>
                                            <b>{{ $ongoing->game_name }}</b>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Game Type</td>
                                        <td>
                                            <b>{{ $ongoing->game_type }}</b>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Tournament Type</td>
                                        <td>
                                            <b>{{ $ongoing->getHumanReadableType() }}</b>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Participants
                                        </td>
                                        <td>
                                            <b>{!! $ongoing->teams()->where('team_status','1')->count() . " / " . $ongoing->maximum_participants  !!}</b>
                                        </td>
                                    </tr>
                                    </tbody></table>
                            </div>

                            <div class="card-action">
                                <a class="btn btn-primary btn-block btn-sm" href="{{ route('tournament.show',$ongoing->slug) }}">View Details</a>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="panel pad5" style="padding: 10px !important;">
                    <h4 class="" style="margin:0 0 10px 0;border-bottom:2px dashed grey">News</h4>
                    <i>No News</i>
                </div>
                <div class="panel pad5" style="padding: 10px !important;">
                    <h4 class="" style="margin:0 0 10px 0;border-bottom:2px dashed grey">Player of the Month</h4>
                    <i>No Player</i>
                </div>
            </div>

            <div class="col-xs-4">
                <div class="panel pad5" style="padding: 10px !important;">
                    <h4 class="" style="margin:0 0 10px 0;border-bottom:2px dashed grey">Videos</h4>
                    <iframe id="kosTourVideo" width="100%" height="100%" src="http://youtube.com/embed/7lDxjRfKjVM" frameborder="0" allowfullscreen></iframe>
                </div>
            </div>

            <div class="col-xs-4">
                <div class="panel pad5" style="padding: 10px !important;">
                    <h4 class="" style="margin:0 0 10px 0;border-bottom:2px dashed grey">Upcoming Tourny</h4>
                    @if($upcoming == null)
                        <p class=""><i>No Upcoming Tournament</i></p>
                    @else
                    <div class="card no-padding no-margin">
                        <div class="card-image" style="min-height:250px; background-image: url('uploaded_images/{{ $upcoming->photo->url }}');background-size: cover">
                            <span class="card-title">{{ $upcoming->name }}</span>
                        </div>
                        <div class="card-user">
                            {{--<img class="img-responsive userpic" src="/images/swat4.png">--}}
                        </div>
                        <div class="card-content">
                            <table style="font-size: large" class="table no-margin table-striped table-hover table-bordered">
                                <tbody><tr>
                                    <td>Game Name</td>
                                    <td>
                                        <b>{{ $upcoming->game_name }}</b>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Game Type</td>
                                    <td>
                                        <b>{{ $upcoming->game_type }}</b>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Tournament Type</td>
                                    <td>
                                        <b>{{ $upcoming->getHumanReadableType() }}</b>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Participants
                                    </td>
                                    <td>
                                        <b>{!! $upcoming->teams()->where('team_status','1')->count() . " / " . $upcoming->maximum_participants  !!}</b>
                                    </td>
                                </tr>
                                </tbody></table>
                        </div>

                        <div class="card-action">
                            <a class="btn btn-primary btn-block btn-sm" href="{{ route('tournament.show',$upcoming->slug) }}">View Details</a>
                        </div>
                    </div>
                    @endif
                </div>
                
                <div class="panel pad5" style="padding: 10px !important;">
                    <h4 class="" style="margin:0 0 10px 0;border-bottom:2px dashed grey">Last Tourny</h4>
                    @if($last == null)
                    <p class=""><i>No Past Tournament</i></p>
                    @else
                        <div class="card no-padding no-margin">
                            <div class="card-image" style="min-height:250px; background-image: url('uploaded_images/{{ $last->photo->url }}');background-size: cover">
                                <span class="card-title">{{ $last->name }}</span>
                            </div>
                            <div class="card-user">
                                {{--<img class="img-responsive userpic" src="/images/swat4.png">--}}
                            </div>
                            <div class="card-content">
                                <table style="font-size: large" class="table no-margin table-striped table-hover table-bordered">
                                    <tbody><tr>
                                        <td>Game Name</td>
                                        <td>
                                            <b>{{ $last->game_name }}</b>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Game Type</td>
                                        <td>
                                            <b>{{ $last->game_type }}</b>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Tournament Type</td>
                                        <td>
                                            <b>{{ $last->getHumanReadableType() }}</b>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Participants
                                        </td>
                                        <td>
                                            <b>{!! $last->teams()->where('team_status','1')->count() . " / " . $last->maximum_participants  !!}</b>
                                        </td>
                                    </tr>
                                    </tbody></table>
                            </div>

                            <div class="card-action">
                                <a class="btn btn-primary btn-block btn-sm" href="{{ route('tournament.show',$last->slug) }}">View Details</a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

        </div>


    </div>
@endsection
