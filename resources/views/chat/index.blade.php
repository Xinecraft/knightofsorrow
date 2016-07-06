@extends('layouts.main')
@section('title', 'Server Chat Archive')
@section('main-container')
    <div class="content col-xs-8">
        @include('partials._errors')

        <div class="col-xs-12 panel panel-default" style="padding: 15px">
            @if(Request::has('search'))
                <h4 class="well well-sm">Search for "<b>{{ Request::get('search') }}</b>" matched {{ $chats->total() }}
                    chats</h4>
            @endif
            <div class="panel-heading">
                <a href="{{ route('chat.index') }}" class="btn btn-warning pull-right btn-xs">Reset</a>

                {!! Form::open(['method' => 'get', 'name' => 'search', 'class' => 'form']) !!}
                <div class="input-group col-xs-7">
                    {!! Form::text('search',null,['class' => 'form-control col-xs-5', 'placeholder' => 'Search within chat...']) !!}
                    <span class="add-on input-group-btn">
                    <button type="submit" class="btn btn-info">Search</button>
                    </span>

                </div>
                {!! Form::close() !!}


            </div>
            <div class="panel-body ls-chats" id="data-items">
                @foreach($chats as $chat)
                    <p class="no-margin item">
                        {!! $chat->message !!}
                        <small class=""><i>{{ $chat->created_at->toDayDateTimeString() }}</i></small>
                    </p>
                @endforeach
            </div>
            <div class="panel-footer">
                <b>{{ $chats->total() }}</b> matching chats found.
            </div>
            {!! $chats->appends(Request::except('page'))->render() !!}
            <div id="loading" class="text-center"></div>
        </div>
    </div>
@endsection