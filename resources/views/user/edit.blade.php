@extends('layouts.main')
@section('title','Setting')
@section('main-container')
    <div class="content col-xs-9">
    @include('partials._errors')
        <div class="row">
            <div class="col-xs-6 panel pad5">
                <h5 class="info-title" style="margin:0 0 10px 0;border-bottom:2px dashed grey">Change Password</h5>
                {!! Form::open(['class' => 'form-horizontal']) !!}
                {!! Form::hidden('type','UpdatePassword') !!}
                    <div class="form-group"><label for="email" class="col-sm-4 control-label">Current Email</label>
                        <div class="col-xs-7">
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" placeholder="Email address">
                        </div>
                    </div>
                    <div class="form-group"><label for="password" class="col-sm-4 control-label">New Password</label>
                        <div class="col-xs-7">
                            <input type="password" class="form-control" id="password" name="password" placeholder="New password">
                        </div>
                    </div>
                    <div class="form-group"><label for="password_confirmation" class="col-sm-4 control-label">Password Again</label>
                        <div class="col-xs-7">
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="New password again">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-4 col-sm-3">
                            <button type="submit" class="btn btn-default">Update Password</button>
                        </div>
                    </div>
                {!! Form::close() !!}
            </div>

            <div class="col-xs-5 col-xs-offset-1 panel pad5">
                <h5 class="info-title" style="margin:0 0 10px 0;border-bottom:2px dashed grey">Link to Stats Tracker</h5>
                <p class="small"><b>Select which player from Stats Tracker is linked to your account.</b></p>
                @if($players->count())
                {!! Form::open(['class' => 'form-horizontal h203px']) !!}
                {!! Form::hidden('type','LinkPlayer') !!}
                <div class="form-group"><label for="ingameplayer" class="col-sm-4 control-label">Player Name:</label>
                    <div class="col-sm-8">
                        <select class="form-control" name="ingameplayer" id="ingameplayer">
                            <option value="">Choose one</option>
                            @foreach($players as $player)
                                <option value="{{ $player->name }}" {{ $player->name == $user->player_totals_name ? "selected" : "" }}>{{ $player->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-4 col-sm-4">
                        <button type="submit" class="btn btn-default">Update Stats Tracker</button>
                    </div>
                </div>
                {!! Form::close() !!}
                @else
                    <h4 class="text-center text-danger">No matching player found.</h4>
                @endif
                <small><i><b>Important Note:</b> If you can't see any player in list then first join server and play atleast one round there.
                Then return back to this page and refresh.</i></small>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-6 panel pad5">
                <h5 class="info-title" style="margin:0 0 10px 0;border-bottom:2px dashed grey">Edit Profile</h5>
                    {!! Form::model($user,['route' => 'user.setting2.post','class' => 'form-horizontal']) !!}
                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        {!! Form::label('name', 'Full Name:', ['class' => 'col-xs-4 control-label'])  !!}
                        <div class="col-xs-7">
                            {!! Form::text('name',null,['class' => 'form-control']) !!}
                            @if ($errors->has('name'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                        {!! Form::label('username', 'Username:', ['class' => 'col-xs-4 control-label'])  !!}
                        <div class="col-xs-7">
                            {!! Form::text('username',null,['class' => 'form-control', 'disabled' => 'true']) !!}
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('dob') ? ' has-error' : '' }}">
                        {!! Form::label('dob', 'Date of Birth:', ['class' => 'col-xs-4 control-label']) !!}
                        <div class="col-xs-7">

                            <div id="datetimepicker1" class="input-group">
                                {!! Form::text('dob', null, ['class' => 'form-control', 'data-format' => 'yyyy-MM-dd']) !!}
                                <span class="add-on input-group-btn">
                                            <button class="btn btn-info">
                                                <i data-time-icon="fa fa-clock-o" data-date-icon="fa fa-calendar">
                                                </i>
                                            </button>
                                        </span>
                            </div>

                            @if ($errors->has('dob'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('dob') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>


                <div class="form-group{{ $errors->has('gender') ? ' has-error' : '' }}">
                    {!! Form::label('gender', 'Gender:', ['class' => 'col-xs-4 control-label']) !!}
                    <div class="col-xs-7">
                        {!! Form::select('gender', ['' => 'unspecified','Male' => 'Male','Female' => 'Female','Others' => 'Others'], null, ['placeholder' => 'Select Gender...', 'class' => 'form-control']) !!}
                        @if ($errors->has('gender'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('gender') }}</strong>
                                    </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('gr_id') ? ' has-error' : '' }}">
                    {!! Form::label('gr_id', 'GameRanger Id:', ['class' => 'col-xs-4 control-label'])  !!}
                    <div class="col-xs-7">
                        {!! Form::text('gr_id',null,['class' => 'form-control']) !!}
                        @if ($errors->has('gr_id'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('gr_id') }}</strong>
                                    </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('evolve_id') ? ' has-error' : '' }}">
                    {!! Form::label('evolve_id', 'Evolve:', ['class' => 'col-xs-4 control-label'])  !!}
                    <div class="col-xs-7">
                        {!! Form::text('evolve_id',null,['class' => 'form-control']) !!}
                        @if ($errors->has('evolve_id'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('evolve_id') }}</strong>
                                    </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('facebook_url') ? ' has-error' : '' }}">
                    {!! Form::label('facebook_url', 'FB profile Url:', ['class' => 'col-xs-4 control-label'])  !!}
                    <div class="col-xs-7">
                        {!! Form::text('facebook_url',null,['class' => 'form-control']) !!}
                        @if ($errors->has('facebook_url'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('facebook_url') }}</strong>
                                    </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('website_url') ? ' has-error' : '' }}">
                    {!! Form::label('website_url', 'Website:', ['class' => 'col-xs-4 control-label'])  !!}
                    <div class="col-xs-7">
                        {!! Form::text('website_url',null,['class' => 'form-control']) !!}
                        @if ($errors->has('website_url'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('website_url') }}</strong>
                                    </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('about') ? ' has-error' : '' }}">
                        {!! Form::label('about', 'About Me:', ['class' => 'col-xs-4 control-label']) !!}
                        <div class="col-xs-7">
                            {!! Form::textarea('about',null,['class' => 'form-control']) !!}
                            <span class="help-block text-info small">
                                        BBCode supported.
                                    </span>
                            @if ($errors->has('about'))
                                <br>
                                <span class="help-block">
                                        <strong>{{ $errors->first('about') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-xs-6 col-xs-offset-4">
                            {!! Form::submit('Update Profile', ['class' => 'btn btn-primary']) !!}
                        </div>
                    </div>

                    {!! Form::close() !!}
            </div>

            <div class="col-xs-5 col-xs-offset-1 panel pad5">
                <h5 class="info-title" style="margin:0 0 10px 0;border-bottom:2px dashed grey">Profile Picture</h5>
                <p>To update your profile picture you need to register/login at <a target="_blank" href="http://gravatar.com">gravatar</a> and setup a profile picture there.</p>

            </div>

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
        });
    </script>
@endsection