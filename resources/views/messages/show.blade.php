@extends('layouts.main')
@section('title', 'Conversation with '.$recuser->displayName())
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
    </style>
@endsection
@section('main-container')
<div class="content col-xs-9">
    <div class="row">
        <div class="panel text-center">
            <h4>Your Conversation
                with {!! link_to_route('user.show',$recuser->displayName(),$recuser->username,['class' => '']) !!}</h4>
        </div>
        <div class="">
            <br style="clear:both">
            {!! Form::open() !!}
            <div class="col-xs-8 col-xs-offset-2 form-group{{ $errors->has('message') ? ' has-error' : '' }}">

                {!! Form::textarea('message',null,['id' => 'message', 'class' => 'form-control no-resize', 'rows' => '2', 'placeholder' => 'Your message here']) !!}
                <span class="help-block tiny pull-left"><p id="" class="nomargin help-block text-info">Type colon ":" for emoji popup</p></span>
                    <span class="help-block pull-right"><p id="characterLeft" class="nomargin help-block ">You have
                            reached the limit</p></span>
                @if ($errors->has('message'))
                    <br>
                    <span class="help-block">
                <strong>{{ $errors->first('message') }}</strong>
                </span>
                @endif
                {!! Form::submit('Send Message',['class' => 'form-control btn btn-info disabled', 'id' => 'btnSubmit']) !!}
            </div>
            <div class="form-group col-xs-3 col-xs-offset-2">
            </div>
            {!! Form::close() !!}
        </div>

        <div class="row" id="data-items" style="margin-bottom:30px;margin-top:20px;">
            @forelse($messages as $message)
                @if($message->sender_id > $message->reciever_id)
                    <div class="item media col-xs-8 col-xs-offset-2">
                        <div class="media-left">
                            <a class="tooltipster" data-placement="right" title="{{ $message->sender->displayName() }}" href="{{ route('user.show',$message->sender->username) }}"><img
                                        src="{{ $message->sender->getGravatarLink() }}" alt=""
                                        class="img img-circle" width="50"></a>
                        </div>
                        <div class="media-body panel padding10 chatbox2">

                            {{-- Delete Form --}}
                            @if($message->canBeDeletedBy(Auth::user()))
                            <div class="pull-right">
                                {!! Form::open(['method' => 'delete', 'route' => ['messages.delete',$message->id]]) !!}
                                <button data-placement="left" title="Delete" class="btn btn-link btn-xs tooltipster confirm"><i class="fa fa-trash"></i></button>
                                {!! Form::close() !!}
                            </div>
                            @endif

                            <p class="">
                                <b>{!! link_to_route('user.show',$message->sender->displayName(),$message->sender->username) !!}</b>
                                <span><i class="tiny text-muted">{{ $message->created_at->diffForHumans() }}</i></span>
                            </p>
                            @if($message->seen_at == null && $message->reciever_id == Auth::user()->id)
                                <p><span class="label label-info">New</span></p>
                                {{ $message->hasBeenSeen() }}
                            @elseif($message->seen_at == null)
                                <p><span class="label label-info">Not seen</span></p>
                            @endif
                            <p class="convert-emoji">{!! Emojione\Emojione::toImage(nl2br(htmlentities($message->message))) !!}</p>
                        </div>
                    </div>
                @else
                    <div class="item media col-xs-8 col-xs-offset-2">
                        <div class="media-body panel padding10 chatbox1 text-right">

                            {{-- Delete Form --}}
                            @if($message->canBeDeletedBy(Auth::user()))
                            <div class="pull-left">
                                {!! Form::open(['method' => 'delete', 'route' => ['messages.delete',$message->id]])  !!}
                                <button data-placement="right" title="Delete" class="btn btn-link btn-xs tooltipster confirm"><i class="fa fa-trash"></i></button>
                                {!! Form::close() !!}
                            </div>
                            @endif

                            <p class="">
                                <b>{!! link_to_route('user.show',$message->sender->displayName(),$message->sender->username) !!}</b>
                                <span><i class="tiny text-muted">{{ $message->created_at->diffForHumans() }}</i></span>
                            </p>
                            @if($message->seen_at == null && $message->reciever_id == Auth::user()->id)
                                <p><span class="label label-info">New</span></p>
                                {{ $message->hasBeenSeen() }}
                            @elseif($message->seen_at == null)
                                <p><span class="label label-info">Not seen</span></p>
                            @endif
                            <p class="convert-emoji">{!! Emojione\Emojione::toImage(nl2br(htmlentities($message->message))) !!}</p>
                        </div>
                        <div class="media-right">
                            <a class="tooltipster" data-placement="left" title="{{ $message->sender->displayName() }}" href="{{ route('user.show',$message->sender->username) }}"><img
                                        src="{{ $message->sender->getGravatarLink() }}" alt=""
                                        class="img img-circle" width="50"></a>
                        </div>
                    </div>
                @endif
            @empty
                <div class="panel col-xs-8 col-xs-offset-2">
                    <h4 class="text-danger text-center"><i>Its lonely here! Send a message now to start
                            conversation with {{ $recuser->displayName() }}</i></h4>
                </div>
            @endforelse
        </div>
    </div>
    <div class="text-center">
        {!! $messages->appends(Request::except('page'))->render() !!}
        <div id="loading" class="text-center"></div>
    </div>
</div>
@endsection

@section('scripts')
    <script>
        (function () {
            $('#characterLeft').text('1500 characters left');
            $('#message').keyup(function () {
                var max = 1500;
                var len = $(this).val().length;
                if (len >= max) {
                    var ch = max - len;
                    $('#characterLeft').text(ch + ' characters left');
                    $('#characterLeft').addClass('red');
                    $('#btnSubmit').addClass('disabled');
                }
                else if(len == 0)
                {
                    var ch = max - len;
                    $('#characterLeft').text(ch + ' characters left');
                    $('#btnSubmit').addClass('disabled');
                }
                else {
                    var ch = max - len;
                    $('#characterLeft').text(ch + ' characters left');
                    $('#btnSubmit').removeClass('disabled');
                    $('#characterLeft').removeClass('red');
                }
            });
        })()
    </script>
@endsection