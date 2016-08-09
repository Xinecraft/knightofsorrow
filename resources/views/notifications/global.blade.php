@extends('layouts.main')
@section('title',$header)
@section('main-container')
    <div class="content col-xs-9">

        <div class="panel text-center">
            <h4>
                {{ $header }}
                @if($header == "Your Notifications")
                    <i class="fa fa-bell"></i>
                @else
                    <i class="fa fa-globe"></i>
                @endif
            </h4>
        </div>

        <div class="panel" style="padding: 20px;">

            <ul class="notifications" id="data-items">
                @forelse($notifications as $notification)
                    <li class="notification item {{ $header == "Your Notifications" ? $notification->getUnreadColorClass() : "" }}">
                        <div class="media">
                            <div class="media-body">
                                {!! $notification->body !!}

                                <div class="notification-meta pull-right">
                                    <small class="timestamp">{{ $notification->created_at->diffForHumans() }}</small>
                                </div>
                            </div>
                        </div>
                    </li>
                @empty
                    <h3 class="text-center">No Notifications</h3>
                @endforelse
            </ul>

            {!! $notifications->appends(Request::except('page'))->render() !!}
            <div id="loading" class="text-center"></div>

        </div>


    </div>
@endsection