@extends('layouts.main')
@section('title', 'Apply for '.$tournament->name)
@section('main-container')
    <div class="content col-xs-12">
        <div class="panel text-center">
            <h4>Apply for
                tournament {!! link_to_route('tournament.show',$tournament->name,$tournament->slug)  !!}</h4>
        </div>

        <div class="col-xs-6 panel" style="padding:10px">
            <h5 class="info-title" style="margin:0 0 10px 0;border-bottom:2px dashed grey">Create New Team and Apply</h5>

            {!! Form::open(['route' => ['tournament.apply.new',$tournament->id],'class' => 'form-horizontal']) !!}

            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                {!! Form::label('name', 'Name', ['class' => 'col-xs-3 control-label']) !!}
                <div class="col-xs-7">
                    {!! Form::text('name',null,['class' => 'form-control','placeholder' => 'Name of the Team']) !!}
                    @if ($errors->has('name'))
                        <span class="help-block">
                <strong>{{ $errors->first('name') }}</strong>
                </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                {!! Form::label('description', 'About', ['class' => 'col-xs-3 control-label']) !!}
                <div class="col-xs-7">
                    {!! Form::textarea('description',null,['class' => 'form-control','placeholder' => 'Few words about your team']) !!}
                    @if ($errors->has('description'))
                        <span class="help-block">
                <strong>{{ $errors->first('description') }}</strong>
                </span>
                    @endif
                    <small class="text-info">BBCode is supported.</small>
                </div>
            </div>

            <div class="form-group{{ $errors->has('country_id') ? ' has-error' : '' }}">
                {!! Form::label('country_id', 'Country', ['class' => 'col-md-3 control-label']) !!}
                <div class="col-md-7">
                {!! Form::select('country_id',\App\Country::orderBy('id','desc')->lists('countryName','id'),null,['class' => 'form-control']) !!}
                @if ($errors->has('country_id'))
                <span class="help-block">
                <strong>{{ $errors->first('country_id') }}</strong>
                </span>
                @endif
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-4">
                    <button type="submit" class="btn btn-info confirm">Create Team and Apply</button>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
        <div class="col-xs-5 col-xs-offset-1 panel" style="padding:10px">
            <h5 class="info-title" style="margin:0 0 10px 0;border-bottom:2px dashed grey">Join Existing Team</h5>

            {!! Form::open(['route' => ['tournament.apply.existing',$tournament->id],'class' => 'form-horizontal']) !!}


            <div class="form-group{{ $errors->has('team') ? ' has-error' : '' }}">
                {!! Form::label('team', 'Find Team', ['class' => 'col-md-3 control-label']) !!}
                <div class="col-md-7">
                {!! Form::select('team',App\KTeam::where('k_tournament_id',$tournament->id)->lists('name', 'id'),null,['class' => 'form-control']) !!}
                @if ($errors->has('team'))
                <span class="help-block">
                <strong>{{ $errors->first('team') }}</strong>
                </span>
                @endif
                </div>
            </div>


            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-3">
                    <button type="submit" class="btn btn-primary confirm">Join Team</button>
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