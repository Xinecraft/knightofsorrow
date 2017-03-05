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

                <button class="btn btn-default btn-block btn-sm btn-info" id="shouts-loader">Load More</button>

                <ul class="chat" id="shoutbox-chat">
                    @foreach($shouts as $shout)
                        @if($shout->user_id % 2 == 0)
                            <li class="clearfix left col-xs-12 no-padding"><span class="chat-img pull-left">
                            <img src="{{ $shout->user->getGravatarLink(40) }}" width="40" height="40" alt="User Avatar" class="img img-shoutt"/>
                                </span>
                                <div class="chat-body clearfix">
                                    <div class="header text-left">
                                        <a class="{{ "color-".$shout->user->roles()->first()->name }}" href="{{ route('user.show',$shout->user->username) }}">
                                            <strong class="">{{ $shout->user->displayName() }}</strong>
                                        </a>
                                        <br>


                                        @if(Auth::check() && Auth::user()->isAdmin())
                                        <div class="pull-right">
                                            {!! Form::open(['method' => 'delete', 'route' => ['shouts.delete',$shout->id], 'class' => 'deleteShout'])  !!}
                                            <button data-toggle="tooltip" title="Delete" class="tooltipster confirm btn btn-link btn-xs"><i class="fa fa-trash"></i></button>
                                            {!! Form::close()  !!}
                                        </div>
                                        @endif

                                        <small class="text-muted">
                                            <span class="fa fa-clock-o"></span> {{ $shout->created_at->diffForHumans() }}
                                        </small>
                                    </div>
                                    <p class="convert-emoji text-justify">
                                        {!! nl2br(linkify(htmlentities($shout->shout))) !!}
                                    </p>
                                </div>
                            </li>
                        @else

                            <li class="right clearfix col-xs-12 no-padding"><span class="chat-img pull-right">
                            <img src="{{ $shout->user->getGravatarLink(40) }}" width="40" height="40" alt="User Avatar" class="img img-shoutt"/>
                        </span>
                                <div class="chat-body clearfix">
                                    <div class="header text-right">
                                        <a class="{{ "color-".$shout->user->roles()->first()->name }}" href="{{ route('user.show',$shout->user->username) }}">
                                            <strong class="">{{ $shout->user->displayName() }}</strong>
                                        </a>
                                        <br>
                                        <small class="text-muted"><span class="fa fa-clock-o"></span> {{ $shout->created_at->diffForHumans() }}
                                        </small>

                                        @if(Auth::check() && Auth::user()->isAdmin())
                                        <div class="pull-left">
                                            {!! Form::open(['method' => 'delete', 'route' => ['shouts.delete',$shout->id],'class' => 'deleteShout'])  !!}
                                            <button data-toggle="tooltip" title="Delete" class="tooltipster confirm btn btn-link btn-xs"><i class="fa fa-trash"></i></button>
                                            {!! Form::close()  !!}
                                        </div>
                                        @endif

                                    </div>
                                    <p class="text-right convert-emoji">
                                        {!! nl2br(linkify(htmlentities($shout->shout))) !!}
                                    </p>
                                </div>
                            </li>
                        @endif

                    @endforeach

                </ul>
            </div>
            <div class="panel-footer">
                @if(Auth::check())
                    @if(Auth::user()->muted)
                        <form class="comment-create-form media-body">
                            <input type="text" placeholder="You are muted" class="form-control text-center comment-textarea no-margin" disabled>
                        </form>
                    @else
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
                    @endif
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
        padding-bottom: 5px !important;
        border-bottom: 1px #E1E1E1 solid;
    }

    .shoutbox-cont .chat li.left .chat-body {

    }

    .shoutbox-cont .chat li.right .chat-body {

    }

    .shoutbox-cont .chat li .chat-body p {
        margin-top: 5px;
        color: #272727;
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

    #shouts-loader
    {
        margin-bottom: 15px;
    }
    li.left .chat-body .header a
    {
        margin-left:5px;
    }
    li.left .chat-body .header small
    {
        margin-left:5px;
    }
    li.right .chat-body .header a
    {
        margin-right:5px;
    }
    li.right .chat-body .header small
    {
        margin-right:5px;
    }
    .img-shoutt
    {
        border: 1px solid #b2b29d;
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