@extends('layouts.main')
@section('title', 'Your Message Archive')
@section('styles')
    <style>
        .red {
            color: red;
        }

        pre {
            padding: 0px;
        }

        h1 {
            font-size: 300% !important;
        }

        .tiny {
            font-size: 14px;
        }
        .chatbox1:after
        {
            content: "";
            position: absolute;
            right: 66px;
            top: 11px;
            border-width: 10px 0px 10px 15px;
            border-style: solid;
            border-color: transparent #FFFFFF;
            display: block;
            width: 0;
        }
        .chatbox2:before
        {
            content: "";
            position: absolute;
            left: 66px;
            top: 11px;
            border-width: 10px 15px 10px 0px;
            border-style: solid;
            border-color: transparent #FFFFFF;
            display: block;
            width: 0;
        }
        .start-con-form .twitter-typeahead {
            width: 100% !important;
            margin-top: 5px;
    </style>
@endsection
@section('main-container')
    <div class="content col-xs-9">
        <div class="row">
            <div class="panel text-center">
                <h4> Your Messages Archive</h4>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading"><b> <i class="fa fa-envelope"></i> Messages</b></div>
                <div class="panel-body text-center stats">
                    <p>You have <kbd class="">{{ Auth::user()->receivedMessagesUnseen()->count() }}</kbd> new {{ str_plural('message', Auth::user()->receivedMessagesUnseen()->count()) }} <i class="fa fa-envelope-o"></i></p>
                    <br>

                    @forelse($messages as $message)
                        <a href="{{ route('messages.show',$message->sender->username) }}">
                            <div class="col-xs-4" style="">
                                <p class="padding10" style="border: 1px solid #bababa">
                                    <kbd>{{ $mrm = $message->reciever->messagesUnseenBy($message->sender->username)->count() }}</kbd>
                                    new {{ str_plural("message",$mrm) }}
                                    from {{ $message->sender->displayName() }}</p>
                            </div>
                        </a>
                    @empty
                    @endforelse
                </div>

                <div class="panel panel-default" style="margin:20px">
                    <div class="panel-heading"><b> <i class="fa fa-mail-forward"></i> Start New Conversation</b></div>
                    <div class="panel-body">
                        <form method="get" action="/conversation/new" class="start-con-form form-horizontal">
                            <div class="input-group col-xs-7 col-xs-offset-2">
                                {!! Form::text('with',null,['class' => 'composemailusername form-control', 'placeholder' => 'Username or Email']) !!}
                                <span class="add-on input-group-btn">
                                        <button class="btn btn-info" type="submit">
                                            Start
                                        </button>
                                    </span>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>

        <div class="row">
            @if(Auth::user()->isSuperAdmin())
                <div class="col-xs-6 no-padding">
                    <div class="panel panel-default">
                        <div class="panel-heading"><b>Website Statistics</b></div>
                        <div class="panel-body">
                            <h4>We have currently:</h4>
                            <p><kbd>{{ \App\User::count() }}</kbd> registered members.</p>
                            <p><kbd>{{ \App\PlayerTotal::count() }}</kbd> players served.</p>
                            <p><kbd>{{ \App\Game::count() }}</kbd> round played.</p>
                            <p><kbd>{{ \App\Chat::count() }}</kbd> server chat logs.</p>
                            <p><kbd>{{ \App\Shout::count() }}</kbd> shouts.</p>
                            <p><kbd>{{ \App\Status::count() }}</kbd> status updates.</p>
                            <p><kbd>{{ \App\Comment::count() }}</kbd> comments on statuses.</p>
                            <p><kbd>{{ \App\Mail::count() }}</kbd> private messages sent.</p>
                    </div>
                </div>
                </div>
            @endif
        </div>
    </div>
@endsection

@endsection