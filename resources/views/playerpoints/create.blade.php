@extends('layouts.main')
@section('title', 'Grant Points to a Player')
@section('main-container')
    <div class="content col-xs-9">
        <div class="row">
            <div class="col-xs-10 col-xs-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Points Distribution Form</div>
                    <div class="panel-body">

                        {!! Form::open(['class' => 'form-horizontal form']) !!}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            {!! Form::label('name', 'Player', ['class' => 'col-md-4 control-label']) !!}
                            <div class="col-md-6">
                                {!! Form::select('name',App\PlayerTotal::lists('name', 'id'),null,['class' => 'form-control']) !!}
                                @if ($errors->has('name'))
                                    <span class="help-block">
                <strong>{{ $errors->first('name') }}</strong>
                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('points') ? ' has-error' : '' }}">
                            {!! Form::label('points', 'Points', ['class' => 'col-xs-4 control-label'])  !!}
                            <div class="col-xs-6">
                                {!! Form::text('points',null,['class' => 'form-control','placeholder' => '-1000 to 5000'])  !!}
                                @if ($errors->has('points'))
                                    <span class="help-block">
                                <strong>{{ $errors->first('points') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('reason') ? ' has-error' : '' }}">
                            {!! Form::label('reason', 'Reason', ['class' => 'col-xs-4 control-label'])  !!}
                            <div class="col-xs-6">
                                {!! Form::textarea('reason',null,['class' => 'form-control'])  !!}
                                @if ($errors->has('reason'))
                                    <span class="help-block">
                                <strong>{{ $errors->first('reason') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-xs-6 col-xs-offset-4">
                                <button type="submit" class="btn btn-primary confirm">
                                    Grant Points
                                </button>
                            </div>
                        </div>
                        {!! Form::close() !!}

                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
