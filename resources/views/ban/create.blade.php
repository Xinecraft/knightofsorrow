@extends('layouts.main')
@section('title', 'Add Master Ban')
@section('main-container')
    <div class="content col-xs-9">
        @include('partials._errors')

        <div class="col-xs-10 panel" style="padding:10px">
            <h5 class="info-title" style="margin:0 0 10px 0;border-bottom:2px dashed grey">Add Master Ban</h5>

            {!! Form::open(['class' => 'form-horizontal']) !!}

            <div class="form-group{{ $errors->has('ip_address') ? ' has-error' : '' }}">
                {!! Form::label('ip_address', 'IP Address', ['class' => 'col-xs-3 control-label']) !!}
                <div class="col-xs-7">
                    {!! Form::text('ip_address',null,['class' => 'form-control', 'placeholder' => 'IP Address to ban']) !!}
                    @if ($errors->has('ip_address'))
                        <span class="help-block">
                <strong>{{ $errors->first('ip_address') }}</strong>
                </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('reason') ? ' has-error' : '' }}">
                {!! Form::label('reason', 'Reason', ['class' => 'col-xs-3 control-label']) !!}
                <div class="col-xs-7">
                    {!! Form::text('reason',null,['class' => 'form-control', 'placeholder' => 'Reason for this ban']) !!}
                    @if ($errors->has('reason'))
                        <span class="help-block">
                <strong>{{ $errors->first('reason') }}</strong>
                </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('banned_till') ? ' has-error' : '' }}">
                {!! Form::label('banned_till', 'Banned Till:', ['class' => 'col-xs-3 control-label']) !!}
                <div class="col-xs-7">
                    <div id="datetimepicker1" class="input-group">
                        {!! Form::text('banned_till', null, ['class' => 'form-control', 'data-format' => 'yyyy-MM-dd hh:mm:ss']) !!}
                        <span class="add-on input-group-btn">
                                            <button class="btn btn-info">
                                                <i data-time-icon="fa fa-clock-o" data-date-icon="fa fa-calendar">
                                                </i>
                                            </button>
                                        </span>
                    </div>
                    @if ($errors->has('banned_till'))
                        <span class="help-block">
                                        <strong>{{ $errors->first('banned_till') }}</strong>
                                    </span>
                    @endif
                    <span class="help-block">
                        Leave empty if <strong>permanent ban</strong>
                    </span>
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-3">
                    <button type="submit" class="btn btn-danger confirm">Add Ban</button>
                </div>
            </div>
            {!! Form::close() !!}
        </div>

    </div>
@endsection

@section('scripts')
        <!--<script src="{{ url('/') }}/js/angular.min.js"></script>-->
    <script>
        $(function () {
            $('#datetimepicker1').datetimepicker({
                language: 'en',
                pick12HourFormat: true
            });
        });
    </script>
@endsection