@extends('layouts.main')
@section('title', 'Create a Trophy')
@section('main-container')
    <div class="content col-xs-9">
        <div class="row">
            <div class="col-xs-10 col-xs-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Create Trophy</div>
                    <div class="panel-body">

                        {!! Form::open(['class' => 'form-horizontal form','files' => 'true']) !!}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            {!! Form::label('name', 'Trophy Name', ['class' => 'col-md-4 control-label']) !!}
                            <div class="col-md-6">
                                {!! Form::text('name',null,['class' => 'form-control','placeholder' => 'Name of the Trophy'])  !!}
                                @if ($errors->has('name'))
                                    <span class="help-block">
                <strong>{{ $errors->first('name') }}</strong>
                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('short_name') ? ' has-error' : '' }}">
                            {!! Form::label('short_name', 'Short Name', ['class' => 'col-md-4 control-label']) !!}
                            <div class="col-md-6">
                                {!! Form::text('short_name',null,['class' => 'form-control','placeholder' => 'ShortName/Initials of the Trophy'])  !!}
                                @if ($errors->has('short_name'))
                                    <span class="help-block">
                <strong>{{ $errors->first('short_name') }}</strong>
                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                            {!! Form::label('description', 'Description', ['class' => 'col-xs-4 control-label'])  !!}
                            <div class="col-xs-6">
                                {!! Form::textarea('description',null,['class' => 'form-control', 'placeholder' => 'Full description of the Trophy'])  !!}
                                <i class="small text-info">Markdown supported.</i>
                            @if ($errors->has('description'))
                                    <span class="help-block">
                                <strong>{{ $errors->first('description') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('max_bearer') ? ' has-error' : '' }}">
                            {!! Form::label('max_bearer', 'Max User', ['class' => 'col-xs-4 control-label'])  !!}
                            <div class="col-xs-6">
                                {!! Form::selectRange('max_bearer', 1, 100,null,['class' => 'form-control'])  !!}
                                <i class="small text-info">Max no. of user that can hold this trophy</i>
                                @if ($errors->has('max_bearer'))
                                    <span class="help-block">
                                <strong>{{ $errors->first('max_bearer') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('photo') ? ' has-error' : '' }}">
                            {!! Form::label('photo', 'Trophy Image', ['class' => 'col-md-4 control-label'])  !!}
                            <div class="col-md-6">
                                {!! Form::file('photo',null,['class' => 'form-control'])  !!}
                                @if ($errors->has('photo'))
                                    <span class="help-block">
                            <strong>{{ $errors->first('photo') }}</strong>
                            </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('icon') ? ' has-error' : '' }}">
                            {!! Form::label('icon', 'Icon', ['class' => 'col-xs-4 control-label'])  !!}
                            <div class="col-xs-6">
                                {!! Form::text('icon',null,['class' => 'form-control','placeholder' => 'Eg: fa-trophy'])  !!}
                                <i class="small text-info">Font awsome icon name. Optional.</i>
                            @if ($errors->has('icon'))
                                    <span class="help-block">
                                <strong>{{ $errors->first('icon') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('color') ? ' has-error' : '' }}">
                            {!! Form::label('color', 'Color', ['class' => 'col-xs-4 control-label'])  !!}
                            <div class="col-xs-6">
                                {!! Form::text('color',null,['class' => 'form-control','placeholder' => 'Eg: #000000, green'])  !!}
                                <i class="small text-info">Color for Icon and Text. Optional.</i>
                                @if ($errors->has('color'))
                                    <span class="help-block">
                                <strong>{{ $errors->first('color') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-xs-6 col-xs-offset-4">
                                <button type="submit" class="btn btn-primary confirm">
                                    Create Trophy
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
