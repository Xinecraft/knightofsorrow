@extends('layouts.main')
@section('title',$tournament->name." Bracket")
@section('styles')
    <style>
        .tab-pane
        {
            padding: 10px;
        }
        .form.form-inline
        {
            display: inline-block;
        }
        .vs:before
        {
            content: 'vs';
            font-size: 25px;
            float: right;
            color: #03A9F4;
        }
        .team-name
        {
            padding: 10px !important;
        }
        .team-name.small
        {
            padding: 5px !important;
        }
        .font125p
        {
            font-size:125% !important;
        }
    </style>
@endsection

@section('before-container')
    <div class="header wg-primary">
        <div class="container">
            <h1 class="ng-binding text-center"><a href="{{ route('tournament.show',$tournament->slug) }}">{{ $tournament->name }}</a></h1>
            <h3 class="ng-binding text-center">Calculation System for match #{{ $match->id }}</h3>
            <h4 class="text-center">{{ $match->team1->name }} <span class="text-danger">vs</span> {{ $match->team2->name }}</h4>
            <!-- ngIf: ctrl.tournament.twitch --><!--end .tournament-twitch-->
        </div><!--end .container-->
    </div>
@endsection

@section('main-container')
    <div class="col-xs-12 padding10">
        <div class="col-xs-6 col-xs-offset-3 panel" style="padding-top: 20px">
            {!! Form::open(['route' => ['tournament.match.postcalculate',$tournament->slug,$match->id],'class' => 'form-horizontal']) !!}
            @for($i = 0; $i<$tournament->rounds_per_match; $i++)
                <div class="form-group{{ $errors->has('game_id_'.$i) ? ' has-error' : '' }}">
                    {!! Form::label('game_id_'.$i, 'ID of Game No '.($i+1), ['class' => 'col-md-4 control-label']) !!}
                    <div class="col-md-8">
                        {!! Form::select('game_id[]',\App\Game::orderBy('id','ASC')->lists('id','id')->push(["0" => "No Game Played"]),null,['placeholder' => 'Select Gender...', 'class' => 'form-control']) !!}
                        @if ($errors->has('game_id_'.$i))
                            <span class="help-block">
                <strong>{{ $errors->first('game_id_'.$i) }}</strong>
                </span>
                        @endif
                    </div>
                </div>
                <br>
            @endfor
            <div class="form-group">
                <div class="col-sm-offset-4 col-sm-6">
                    <button type="submit" class="btn btn-danger confirm">Calculate</button>
                </div>
            </div>
            {!! Form::close() !!}
        </div>

    </div>
@endsection