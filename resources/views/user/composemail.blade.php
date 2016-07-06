@extends('layouts.main')
@section('main-container')
    <div class="content col-xs-9">
    @include('partials._errors')

      <div class="col-xs-10 panel composemail" style="padding:10px">
                <h5 class="info-title" style="margin:0 0 10px 0;border-bottom:2px dashed grey">Compose a Message</h5>
                {!! Form::open(['class' => 'form-horizontal']) !!}
                    <div class="form-group"><label for="to_username" class="col-sm-4 control-label">To:<small> (username without @)</small></label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control composemailusername" id="to_username" name="to_username" placeholder="Username" maxlength="255" value="{{ old('to_username') }}" required>
                        </div>
                    </div>
                    <div class="form-group"><label for="to_subject" class="col-sm-4 control-label">Subject:</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" id="to_subject" name="to_subject" placeholder="Subject" value="{{ old('to_subject') }}" maxlength="255" required>
                        </div>
                    </div>
                    <div class="form-group"><label for="to_body" class="col-sm-4 control-label">Body:</label>
                        <div class="col-sm-7">
                            <textarea name="to_body" id="to_body" class="form-control notsizable" placeholder="Full message goes here">{{ old('to_body') }}</textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-4 col-sm-3">
                            <button type="submit" class="btn btn-info">Send Mail</button>
                        </div>
                    </div>
                {!! Form::close() !!}
            </div>

    </div>
@endsection