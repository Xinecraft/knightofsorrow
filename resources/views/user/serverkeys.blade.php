@extends('layouts.main')
@section('title', 'Server Credentials')
@section('main-container')
    <div class="content col-xs-9">
        <div class="row">
            <div class="col-xs-10 col-xs-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Request for Server Credentials</div>
                    <div class="panel-body">

                        {!! Form::open(['class' => 'form-horizontal form']) !!}
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            {!! Form::label('password', 'Enter your Password', ['class' => 'col-xs-4 control-label'])  !!}
                            <div class="col-xs-6">
                                {!! Form::password('password',['class' => 'form-control'])  !!}
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-xs-6 col-xs-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    View Credentials
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
