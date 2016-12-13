@extends('layouts.main')
@section('title',$tournament->name." Bracket")
@section('styles')
    <style>
        .tab-pane {
            padding: 10px;
        }

        .form.form-inline {
            display: inline-block;
        }

        .vs:before {
            content: 'vs';
            font-size: 25px;
            float: right;
            color: #03A9F4;
        }

        .team-name {
            padding: 10px !important;
        }

        .team-name.small {
            padding: 5px !important;
        }

        .font125p {
            font-size: 125% !important;
        }

        .form-team-form {
            padding: 10px;
            border: 1px solid #dce4ec;
        }
    </style>
@endsection

@section('before-container')
    <div class="header wg-primary">
        <div class="container">
            <h1 class="ng-binding text-center"><a
                        href="{{ route('tournament.show',$tournament->slug) }}">{{ $tournament->name }}</a></h1>
            <h3 class="ng-binding text-center">Calculation System for match #{{ $match->match_index+1 }}</h3>
            <h4 class="text-center">{{ $match->team1->name }} <span
                        class="text-danger">vs</span> {{ $match->team2->name }}</h4>
        </div>
    </div>
@endsection

@section('main-container')
    <div class="col-xs-12 padding10">

        <div class="alert alert-info text-center">
            <strong>Attention!</strong>&nbsp; Round details of the round you choosen is provided on right side of form to be used as reference
        </div>
        {!! Form::open(['route' => ['tournament.match.postcalculatefinal',$tournament->slug,$match->id],'class' => 'form-horizontal']) !!}
        @foreach($games as $round)
            <div class="col-xs-12 panel panel-default no-margin no-padding" style="margin-bottom: 30px !important;">
                <div class="panel-heading"><b>
                        Match {{ $round->game_index }}</b>
                </div>
                @if($round->is_played)
                    <div class="panel-body">
                    <div class="well round-detail-summary text-center">
                        {{ $round->timeAgo }} &nbsp;&squarf;&nbsp; {{ $round->mapName }} &nbsp;&squarf;&nbsp; Round
                        time: {{ $round->time }} &nbsp;&squarf;&nbsp; Round: {{ $round->index }}
                    </div>
                    <div class="col-xs-6">
                        {!! Form::hidden('game_id[]',$round->id)  !!}
                        <div class="form-team-form {{ $i=1 }}">
                            <h4 style="padding: 10px;background-color: #e2e2e2;margin-top: 0">Team {{ $match->team1->name }}</h4>

                            @foreach($match->team1->playerselected as $player)
                                <div class="form-group{{ $errors->has('team1_p'.$i.'_score[]') ? ' has-error' : '' }}">
                                    {!! Form::label('team1_p'.$i.'_score[]', $player->displayName().' score', ['class' => 'col-md-4 control-label']) !!}
                                    <div class="col-md-6">
                                        {!! Form::text('team1_p'.$i.'_score[]',null,['class' => 'form-control']) !!}
                                        @if ($errors->has('team1_p'.$i.'_score[]'))
                                            <span class="help-block">
                                <strong>{{ $errors->first('team1_p'.$i.'_score[]') }}</strong>
                                </span>
                                        @endif
                                    </div>
                                </div>
                                <span class="{{ $i++ }}"></span>
                            @endforeach

                        </div>
                        <div class="form-team-form {{ $i=1 }}">
                            <h4 style="padding: 10px;background-color: #e2e2e2;margin-top: 0">Team {{ $match->team2->name }}</h4>

                            @foreach($match->team2->playerselected as $player)
                                <div class="form-group{{ $errors->has('team2_p'.$i.'_score[]') ? ' has-error' : '' }}">
                                    {!! Form::label('team2_p'.$i.'_score[]', $player->displayName().' score', ['class' => 'col-md-4 control-label']) !!}
                                    <div class="col-md-6">
                                        {!! Form::text('team2_p'.$i.'_score[]',null,['class' => 'form-control']) !!}
                                        @if ($errors->has('team2_p'.$i.'_score[]'))
                                            <span class="help-block">
                                <strong>{{ $errors->first('team2_p'.$i.'_score[]') }}</strong>
                                </span>
                                        @endif
                                    </div>
                                </div>
                                <span class="{{ $i++ }}"></span>
                            @endforeach

                        </div>
                        <hr>
                        <div class="form-group{{ $errors->has('winner[]') ? ' has-error' : '' }}">
                            {!! Form::label('winner[]', 'Match '.$round->game_index.' Winner', ['class' => 'col-md-4 control-label']) !!}
                            <div class="col-md-6">
                            {!! Form::select('winner[]',[
                            "0" => $match->team1->name." wins",
                            "1" => $match->team2->name." wins",
                            "3" => "A Tie",
                            "4" => "None",
                            ],null,['class' => 'form-control']) !!}
                            @if ($errors->has('winner[]'))
                            <span class="help-block">
                            <strong>{{ $errors->first('winner[]') }}</strong>
                            </span>
                            @endif
                            </div>
                        </div>

                    </div>
                    <div class="col-xs-6">
                        <div class="round-detail-players-swat panel panel-default col-xs-6 no-margin no-padding">
                            <div class="panel-heading"><strong>SWAT {!! $round->swatScoreWithColor !!}</strong></div>
                            <div class="panel-body">
                                @if($round->SwatPlayers->isEmpty())
                                    <h5>Its lone here.</h5>
                                @else
                                    <table class="table table-hover table-striped no-margin">
                                        <thead>
                                        <tr>
                                            <th class="col-xs-1">Flag</th>
                                            <th class="col-xs-3">Name</th>
                                            <th class="col-xs-1 text-right">Score</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($round->SwatPlayers as $swat)
                                            <tr class="getindistats" data-id="{{ $swat->id }}">
                                                <td>{!! Html::image('/images/flags/20_shiny/'.$swat->country->countryCode.".png",$swat->country->countryCode,['class' => 'tooltipster', 'title' => $swat->country->countryName]) !!}</td>
                                                <td><strong>{{ $swat->name }}</strong></td>
                                                <td class="text-right"><strong>{{ $swat->score }}</strong></td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                @endif
                            </div>
                        </div>
                        <div class="round-detail-players-suspects panel panel-default col-xs-6 no-margin no-padding">
                            <div class="panel-heading"><strong>SUSPECTS {!! $round->suspectsScoreWithColor !!}</strong>
                            </div>
                            <div class="panel-body">
                                @if($round->SuspectPlayers->isEmpty())
                                    <h5>Its lone here.</h5>
                                @else
                                    <table class="table table-hover table-striped no-margin">
                                        <thead>
                                        <tr>
                                            <th class="col-xs-1">Flag</th>
                                            <th class="col-xs-3">Name</th>
                                            <th class="col-xs-1 text-right">Score</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($round->SuspectPlayers as $suspect)
                                            <tr class="getindistats" data-id="{{ $suspect->id }}">
                                                <td>{!! Html::image('/images/flags/20_shiny/'.$suspect->country->countryCode.".png",$suspect->country->countryCode,['class' => 'tooltipster', 'title' => $suspect->country->countryName]) !!}</td>
                                                <td><strong>{{ $suspect->name }}</strong></td>
                                                <td class="text-right"><strong>{{ $suspect->score }}</strong></td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @else
                    <div class="panel-body">
                        <div class="alert alert-danger text-bold text-center">
                            This Round is not played. Still you have to choose a winner.
                        </div>
                        <div class="col-xs-6">
                            {!! Form::hidden('game_id[]',$round->id)  !!}
                            {!! Form::hidden('team1_p1_score[]',0)  !!}
                            {!! Form::hidden('team1_p2_score[]',0)  !!}
                            {!! Form::hidden('team2_p1_score[]',0)  !!}
                            {!! Form::hidden('team2_p2_score[]',0)  !!}
                            <div class="form-group{{ $errors->has('winner[]') ? ' has-error' : '' }}">
                                {!! Form::label('winner[]', 'Match '.$round->game_index.' Winner', ['class' => 'col-md-4 control-label']) !!}
                                <div class="col-md-6">
                                    {!! Form::select('winner[]',[
                                    "0" => $match->team1->name." wins",
                                    "1" => $match->team2->name." wins",
                                    "2" => "A Tie",
                                    "3" => "None",
                                    ],null,['class' => 'form-control']) !!}
                                    @if ($errors->has('winner[]'))
                                        <span class="help-block">
                            <strong>{{ $errors->first('winner[]') }}</strong>
                            </span>
                                    @endif
                                </div>
                            </div>

                        </div>
                        <div class="col-xs-6">
                        </div>
                    </div>
                @endif
            </div>
        @endforeach

        <div class="col-xs-12 panel padding10 text-center">
            <p><b>Note:</b><span class="text-danger"> Before clicking Submit make sure the information provided is correct. This cannot be undone and may force you to contact admin to fix it.</span></p>
            <p class="text-info text-bold">Please recheck and re-validate everything. If anything went wrong you will have to start this process again from beginning</p>
            <div class="form-group{{ $errors->has('overall_winner_id') ? ' has-error' : '' }}">
                {!! Form::label('overall_winner_id', 'Overall Winner of Match', ['class' => 'col-xs-3 control-label']) !!}
                <div class="col-md-6">
                    @if($tournament->bracket_type == 0)
                    {!! Form::select('overall_winner_id',[
                    "0" => "A Tie",
                    $match->team1->id => $match->team1->name,
                    $match->team2->id => $match->team2->name,
                     "-1" => "Cancelled",
                    ],null,['class' => 'form-control']) !!}
                    @else
                        {!! Form::select('overall_winner_id',[
                        $match->team1->id => $match->team1->name,
                        $match->team2->id => $match->team2->name,
                        ],null,['class' => 'form-control']) !!}
                    @endif
                    @if ($errors->has('overall_winner_id'))
                        <span class="help-block">
                            <strong>{{ $errors->first('overall_winner_id') }}</strong>
                            </span>
                    @endif
                </div>
            </div>
            <div class="form-group">
                <div class="col-xs-12">
                    {!! Form::submit('Submit Report', ['class' => 'confirm btn btn-danger']) !!}
                    <a class="btn btn-default" href="{{ route('tournament.match.getcalculate',[$tournament->slug,$match->id]) }}">Go Back</a>
                </div>
            </div>
        </div>
        {!! Form::close() !!}

    </div>
@endsection
