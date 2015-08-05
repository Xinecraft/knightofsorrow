@extends('layouts.main')
@section('main-container')
    <div class="content col-md-9">
    @include('partials._errors')
        <div class="row">
            <div class="col-md-6 panel pad5">
                <h5 class="info-title" style="margin:0 0 10px 0;border-bottom:2px dashed grey">Change Password</h5>
                {!! Form::open(['class' => 'form-horizontal']) !!}
                {!! Form::hidden('type','UpdatePassword') !!}
                    <div class="form-group"><label for="email" class="col-sm-4 control-label">Current Email</label>
                        <div class="col-sm-8">
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" placeholder="Email address">
                        </div>
                    </div>
                    <div class="form-group"><label for="password" class="col-sm-4 control-label">New Password</label>
                        <div class="col-sm-8">
                            <input type="password" class="form-control" id="password" name="password" placeholder="New password">
                        </div>
                    </div>
                    <div class="form-group"><label for="password_confirmation" class="col-sm-4 control-label">Password Again</label>
                        <div class="col-sm-8">
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

            <div class="col-md-5 col-md-offset-1 panel pad5">
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
                                <option value="{{ $player->name }}">{{ $player->name }}</option>
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

    </div>
@endsection