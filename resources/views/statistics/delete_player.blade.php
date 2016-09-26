@extends('layouts.main')
@section('title', 'Delete Player '.$player->name)
@section('main-container')
    <div class="content col-xs-9">
        <div class="row">
            <div class="col-xs-10 col-xs-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Delete statistics of <b>{{ $player->name }}</b></div>
                    <div class="panel-body">

                        {!! Form::open(['class' => 'form-horizontal form']) !!}

                        <div class="form-group{{ $errors->has('player_name') ? ' has-error' : '' }}">
                            {!! Form::label('player_name', 'Player', ['class' => 'col-xs-4 control-label'])  !!}
                            <div class="col-xs-6">
                                {!! Form::text('player_name',$player->name,['class' => 'form-control','disabled'])  !!}
                                @if ($errors->has('player_name'))
                                    <span class="help-block">
                                <strong>{{ $errors->first('player_name') }}</strong>
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
                                <button type="submit" class="btn btn-danger confirm">
                                    Delete {{ $player->name }}
                                </button>
                            </div>
                        </div>
                        {!! Form::close() !!}

                    </div>
                </div>
            </div>
        </div>

        @if(Session::has('post-back'))
            <div class="row">
                <div class="col-xs-10 col-xs-offset-1">
                    <div class="panel panel-default">
                        <div class="panel-heading">Server Credentials</div>
                        <div class="panel-body">
                            <table class="table table-hover table-striped">
                                <tr>
                                    <th>Max Join Password</th>
                                    <td>
                                        @if(Session::has('credentials.maxjoinpassword'))
                                            {{ Session::get('credentials.maxjoinpassword') }}
                                        @else
                                            <i class="small">Unknown</i>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Admin Password</th>
                                    <td>
                                        @if(Session::has('credentials.adminpassword'))
                                            {{ Session::get('credentials.adminpassword') }}
                                        @else
                                            <i class="small">Unknown</i>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Super Admin Password</th>
                                    <td>
                                        @if(Session::has('credentials.sapassword'))
                                            {{ Session::get('credentials.sapassword') }}
                                        @else
                                            <i class="small">Unknown</i>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
