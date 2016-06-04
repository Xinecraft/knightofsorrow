<div class="shoutbox-cont">
    <div class="panel panel-default">
        <div class="panel-heading" id="accordion">
            <span class="fa fa-comment"></span> Shoutbox
            <div class="btn-group pull-right">
                <a type="button" class="btn btn-default btn-xs" data-toggle="collapse" data-parent="#accordion"
                   href="#collapseOne">
                    <span class="fa fa-chevron-down"></span>
                </a>
            </div>
        </div>
        <div class="" id="collapseOne">
            <div class="panel-body messageLog">
                <ul class="chat" id="shoutbox-chat">

                    @foreach($shouts as $shout)

                        @if($shout->user_id % 2 == 0)

                            <li class="left clearfix"><span class="chat-img pull-left">
                            <img src="{{ $shout->user->getGravatarLink(40) }}" width="40" height="40" alt="User Avatar" class="img-circle"/>
                                </span>
                                <div class="chat-body clearfix">
                                    <div class="header text-left">
                                        <a href="{{ route('user.show',$shout->user->username) }}">
                                            <strong class="primary-font">{{ $shout->user->name }}</strong>
                                        </a>
                                        <br>

                                        <!-- Shout Delete System

                                        @can('delete',$shout)
                                        <div class="pull-right">
                                            {{ Form::open(['method' => 'delete', 'route' => ['shouts.delete',$shout->id], 'class' => 'deleteShout']) }}
                                            <button data-toggle="tooltip" title="Delete" class="btn btn-link btn-xs"><i class="fa fa-trash"></i></button>
                                            {{ Form::close() }}
                                        </div>
                                        @endcan
                                        -->

                                        <small class="text-muted">
                                            <span class="fa fa-clock-o"></span> {{ $shout->created_at->diffForHumans() }}
                                        </small>
                                    </div>
                                    <p class="convert-emoji">
                                        {!! nl2br(htmlentities($shout->shout)) !!}
                                    </p>
                                </div>
                            </li>
                        @else

                            <li class="right clearfix"><span class="chat-img pull-right">
                            <img src="{{ $shout->user->getGravatarLink(40) }}" width="40" height="40" alt="User Avatar" class="img-circle"/>
                        </span>
                                <div class="chat-body clearfix">
                                    <div class="header text-right">
                                        <a href="{{ route('user.show',$shout->user->username) }}">
                                            <strong class="primary-font">{{ $shout->user->name }}</strong>
                                        </a>
                                        <br>
                                        <small class="text-muted"><span class="fa fa-clock-o"></span> {{ $shout->created_at->diffForHumans() }}
                                        </small>

                                        <!--Shout Delete System
                                        @can('delete',$shout)
                                        <div class="pull-left">
                                            {{ Form::open(['method' => 'delete', 'route' => ['shouts.delete',$shout->id],'class' => 'deleteShout']) }}
                                            <button data-toggle="tooltip" title="Delete" class="btn btn-link btn-xs"><i class="fa fa-trash"></i></button>
                                            {{ Form::close() }}
                                        </div>
                                        @endcan
                                        -->
                                    </div>
                                    <p class="text-right convert-emoji">
                                        {!! nl2br(htmlentities($shout->shout)) !!}
                                    </p>
                                </div>
                            </li>
                        @endif

                    @endforeach

                </ul>
            </div>
            <div class="panel-footer">
                @if(Auth::check())
                {!!  Form::open(['route' => 'shouts.store','id' => 'shoutbox-form']) !!}
                <div id="shout-input-group" class="input-group">
                    <input name="shout" id="btn-input" type="text" class="textarea form-control input-sm"
                           placeholder="Type your message here..." autocomplete="off" />
                        <span class="input-group-btn">
                            <button class="btn btn-primary btn-sm" id="btn-chat">
                                Send
                            </button>
                        </span>
                </div>
                    <div id="shout-input-group-error" class="help-block"></div>

                {!! Form::close() !!}
                 @else
                    <div class='panel nomargin padding10 text-muted'><b>{!!  link_to('/auth/login','Login') !!}
                            or {!! link_to('/auth/register', 'Register') !!} to shout.</b></div>
                @endif
            </div>
        </div>
    </div>
</div>


<style>
    .shoutbox-cont .chat {
        list-style: none;
        margin: 0;
        padding: 0;
    }

    .shoutbox-cont .chat li {
        margin-bottom: 10px;
        padding-bottom: 5px;
        border-bottom: 1px #E1E1E1 solid;
    }

    .shoutbox-cont .chat li.left .chat-body {
        margin-left: 48px;
    }

    .shoutbox-cont .chat li.right .chat-body {
        margin-right: 48px;
    }

    .shoutbox-cont .chat li .chat-body p {
        margin: 0;
        color: #777777;
    }

    .shoutbox-cont .panel .slidedown .fa, .chat .fa {
        margin-right: 5px;
    }

    .shoutbox-cont .panel-body {
        overflow-y: auto;
        height: 400px;
        font-size: 90%;
    }

    .shoutbox-cont ::-webkit-scrollbar-track {
        -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
        background-color: #F5F5F5;
    }

    .shoutbox-cont ::-webkit-scrollbar {
        width: 12px;
        background-color: #F5F5F5;
    }

    .shoutbox-cont ::-webkit-scrollbar-thumb {
        -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, .3);
        background-color: #555;
    }
</style>
<!--
<script>
    $('.deleteShout').submit(function(){
        var form = $(this),
                formData = form.serialize(),
                formUrl = form.attr('action'),
                formMethod = form.attr('method');
        form.hide();
        $.ajax({
            url: formUrl,
            type: formMethod,
            data: formData,
            success:function(){
                form.parent().parent().fadeOut(500);
            },
            error:function(){
                form.show();
            }
        });
        return false;
    });
</script>
-->