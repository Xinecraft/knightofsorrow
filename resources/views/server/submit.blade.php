@extends('layouts.main')
@section('main-container')
    <div class="content col-xs-9">
        @include('partials._errors')

        <div class="col-xs-10 panel composemail" style="padding:10px">
            <h5 class="info-title" style="margin:0 0 10px 0;border-bottom:2px dashed grey">Add a new Server</h5>

            {!! Form::open(['class' => 'form-horizontal']) !!}
            <div class="form-group"><label for="ip_address" class="col-sm-4 control-label">IP Address:</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control ip_address" id="ip_address" name="ip_address" placeholder="Server's IP Address" value="{{ old('ip_address') }}" maxlength="255" required>
                </div>
            </div>
            <div class="form-group"><label for="join_port" class="col-sm-4 control-label">Join Port:</label>
                <div class="col-sm-7">
                    <input type="number" class="form-control" id="join_port" name="join_port" placeholder="Server's Join Port" value="{{ old('join_port') }}" maxlength="10" required>
                </div>
            </div>
            <div class="form-group"><label for="query_port" class="col-sm-4 control-label">Query Port:</label>
                <div class="col-sm-7">
                    <input type="number" class="form-control" id="query_port" name="query_port" placeholder="Server's Query Port (Generally Join Port + 1)" value="{{ old('query_port') }}" maxlength="10" required>
                </div>
            </div>
            <div class="form-group"><label for="description" class="col-sm-4 control-label">About Server:</label>
                <div class="col-sm-7">
                    <textarea name="description" id="description" class="form-control notsizable" placeholder="Anything about server.">{{ old('description') }}</textarea>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-4 col-sm-3">
                    <button type="submit" class="btn btn-info">Add Server</button>
                </div>
            </div>
            {!! Form::close() !!}
        </div>

    </div>
@endsection