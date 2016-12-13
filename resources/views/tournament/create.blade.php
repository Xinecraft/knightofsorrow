@extends('layouts.main')
@section('title', 'Create Tournament')
@section('main-container')
    <div class="content col-xs-9 col-md-offset-2">

        <div class="col-xs-10 panel" style="padding:10px">
            <h5 class="info-title" style="margin:0 0 10px 0;border-bottom:2px dashed grey">Create Tournament</h5>

            {!! Form::open(['class' => 'form-horizontal','files' => 'true']) !!}

            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                {!! Form::label('name', 'Name', ['class' => 'col-xs-4 control-label']) !!}
                <div class="col-xs-6">
                {!! Form::text('name',null,['class' => 'form-control']) !!}
                @if ($errors->has('name'))
                <span class="help-block">
                <strong>{{ $errors->first('name') }}</strong>
                </span>
                @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                {!! Form::label('description', 'About', ['class' => 'col-xs-4 control-label']) !!}
                <div class="col-xs-6">
                {!! Form::textarea('description',null,['class' => 'form-control']) !!}
                @if ($errors->has('description'))
                <span class="help-block">
                <strong>{{ $errors->first('description') }}</strong>
                </span>
                @endif
                    <small class="text-info">BBCode is supported.</small>
                </div>
            </div>

            <div class="form-group{{ $errors->has('rules') ? ' has-error' : '' }}">
                {!! Form::label('rules', 'Rules', ['class' => 'col-xs-4 control-label']) !!}
                <div class="col-xs-6">
                {!! Form::textarea('rules',null,['class' => 'form-control']) !!}
                @if ($errors->has('rules'))
                <span class="help-block">
                <strong>{{ $errors->first('rules') }}</strong>
                </span>
                @endif
                    <small class="text-info">BBCode is supported.</small>
                </div>
            </div>

            <div class="form-group{{ $errors->has('photo') ? ' has-error' : '' }}">
                {!! Form::label('photo', 'Poster', ['class' => 'col-xs-4 control-label'])  !!}
                <div class="col-xs-6">
                    {!! Form::file('photo',null,['class' => 'form-control'])  !!}
                    @if ($errors->has('photo'))
                        <span class="help-block">
                            <strong>{{ $errors->first('photo') }}</strong>
                            </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('bracket_type') ? ' has-error' : '' }}">
                {!! Form::label('bracket_type', 'Bracket Type', ['class' => 'col-xs-4 control-label']) !!}
                <div class="col-xs-6">
                    {!! Form::select('bracket_type',
                    [
                                        '0' => 'Round Robin',
                                        '1' => 'Double Elimination',
                    ]
                    ,null,['class' => 'form-control']) !!}
                    @if ($errors->has('bracket_type'))
                        <span class="help-block">
                <strong>{{ $errors->first('bracket_type') }}</strong>
                </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('tournament_type') ? ' has-error' : '' }}">
                {!! Form::label('tournament_type', 'Type', ['class' => 'col-xs-4 control-label']) !!}
                <div class="col-xs-6">
                {!! Form::select('tournament_type',
                [
                                    '0' => '2v2 Team',
                                    '2' => '3v3 Team',
                ]
                ,null,['class' => 'form-control']) !!}
                @if ($errors->has('tournament_type'))
                <span class="help-block">
                <strong>{{ $errors->first('tournament_type') }}</strong>
                </span>
                @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('minimum_participants') ? ' has-error' : '' }}">
                {!! Form::label('minimum_participants', 'Min Participants', ['class' => 'col-xs-4 control-label']) !!}
                <div class="col-xs-6">
                {!! Form::text('minimum_participants',null,['class' => 'form-control']) !!}
                @if ($errors->has('minimum_participants'))
                <span class="help-block">
                <strong>{{ $errors->first('minimum_participants') }}</strong>
                </span>
                @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('maximum_participants') ? ' has-error' : '' }}">
                {!! Form::label('maximum_participants', 'Max Participants', ['class' => 'col-xs-4 control-label']) !!}
                <div class="col-xs-6">
                {!! Form::text('maximum_participants',null,['class' => 'form-control']) !!}
                @if ($errors->has('maximum_participants'))
                <span class="help-block">
                <strong>{{ $errors->first('maximum_participants') }}</strong>
                </span>
                @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('rounds_per_match') ? ' has-error' : '' }}">
                {!! Form::label('rounds_per_match', 'Rounds Per Match', ['class' => 'col-xs-4 control-label']) !!}
                <div class="col-xs-6">
                {!! Form::text('rounds_per_match',null,['class' => 'form-control']) !!}
                @if ($errors->has('rounds_per_match'))
                <span class="help-block">
                <strong>{{ $errors->first('rounds_per_match') }}</strong>
                </span>
                @endif
                </div>
            </div>


            <div class="form-group{{ $errors->has('registration_starts_at') ? ' has-error' : '' }}">
                {!! Form::label('registration_starts_at', 'Registration Starts:', ['class' => 'col-xs-4 control-label']) !!}
                <div class="col-xs-6">
                    <div id="datetimepicker1" class="input-group">
                        {!! Form::text('registration_starts_at', null, ['class' => 'form-control', 'data-format' => 'yyyy-MM-dd']) !!}
                        <span class="add-on input-group-btn">
                                            <button class="btn btn-info">
                                                <i data-time-icon="fa fa-clock-o" data-date-icon="fa fa-calendar">
                                                </i>
                                            </button>
                                        </span>
                    </div>

                    @if ($errors->has('registration_starts_at'))
                        <span class="help-block">
                                        <strong>{{ $errors->first('registration_starts_at') }}</strong>
                                    </span>
                    @endif
                </div>
            </div>


            <div class="form-group{{ $errors->has('registration_ends_at') ? ' has-error' : '' }}">
                {!! Form::label('registration_ends_at', 'Registration Ends:', ['class' => 'col-xs-4 control-label']) !!}
                <div class="col-xs-6">
                    <div id="datetimepicker2" class="input-group">
                        {!! Form::text('registration_ends_at', null, ['class' => 'form-control', 'data-format' => 'yyyy-MM-dd']) !!}
                        <span class="add-on input-group-btn">
                                            <button class="btn btn-info">
                                                <i data-time-icon="fa fa-clock-o" data-date-icon="fa fa-calendar">
                                                </i>
                                            </button>
                                        </span>
                    </div>

                    @if ($errors->has('registration_ends_at'))
                        <span class="help-block">
                                        <strong>{{ $errors->first('registration_ends_at') }}</strong>
                                    </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('tournament_starts_at') ? ' has-error' : '' }}">
                {!! Form::label('tournament_starts_at', 'Tournament Starts:', ['class' => 'col-xs-4 control-label']) !!}
                <div class="col-xs-6">
                    <div id="datetimepicker3" class="input-group">
                        {!! Form::text('tournament_starts_at', null, ['class' => 'form-control', 'data-format' => 'yyyy-MM-dd']) !!}
                        <span class="add-on input-group-btn">
                                            <button class="btn btn-info">
                                                <i data-time-icon="fa fa-clock-o" data-date-icon="fa fa-calendar">
                                                </i>
                                            </button>
                                        </span>
                    </div>

                    @if ($errors->has('tournament_starts_at'))
                        <span class="help-block">
                                        <strong>{{ $errors->first('tournament_starts_at') }}</strong>
                                    </span>
                    @endif
                </div>
            </div>


            <div class="form-group{{ $errors->has('managers[]') ? ' has-error' : '' }}">
                {!! Form::label('managers[]', 'Managers', ['class' => 'col-md-4 control-label']) !!}
                <div class="col-md-6">
                {!! Form::select('managers[]',App\User::lists('username', 'id'),null,['class' => 'form-control','multiple' => 'true']) !!}
                @if ($errors->has('managers[]'))
                <span class="help-block">
                <strong>{{ $errors->first('managers[]') }}</strong>
                </span>
                @endif
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-offset-4 col-sm-3">
                    <button type="submit" class="btn btn-info confirm">Create Tournament</button>
                </div>
            </div>
            {!! Form::close() !!}
        </div>

    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        $(function () {
            $('#datetimepicker1').datetimepicker({
                language: 'en',
                pickTime: false
            });
            $('#datetimepicker2').datetimepicker({
                language: 'en',
                pickTime: false
            });
            $('#datetimepicker3').datetimepicker({
                language: 'en',
                pickTime: false
            });
        });
    </script>
@endsection