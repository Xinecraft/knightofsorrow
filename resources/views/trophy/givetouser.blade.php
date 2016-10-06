@extends('layouts.main')
@section('title', 'Trophy Distribution')
@section('main-container')
    <div class="content col-xs-9">
        <div class="row">
            <div class="col-xs-10 col-xs-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Distribute Trophy</div>
                    <div class="panel-body">

                        {!! Form::open(['class' => 'form-horizontal form']) !!}

                        <div class="form-group{{ $errors->has('trophy') ? ' has-error' : '' }}">
                            {!! Form::label('trophy', 'Trophy', ['class' => 'col-md-4 control-label']) !!}
                            <div class="col-md-6">
                                {!! Form::select('trophy',App\Trophy::lists('name', 'id'),null,['class' => 'form-control']) !!}
                                @if ($errors->has('trophy'))
                                    <span class="help-block">
                <strong>{{ $errors->first('trophy') }}</strong>
                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('users[]') ? ' has-error' : '' }}">
                            {!! Form::label('users[]', 'Users', ['class' => 'col-md-4 control-label']) !!}
                            <div class="col-md-6">
                                {!! Form::select('users[]',App\User::lists('username', 'id'),null,['class' => 'form-control','multiple' => 'true']) !!}
                                @if ($errors->has('users[]'))
                                    <span class="help-block">
                <strong>{{ $errors->first('users[]') }}</strong>
                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-xs-6 col-xs-offset-4">
                                <button type="submit" class="btn btn-primary confirm">
                                    Share Trophy
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
