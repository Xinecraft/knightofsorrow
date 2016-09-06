@extends('layouts.main')
@section('meta-desc',"List of all bans.")
@section('title',"Ban #".$ban->id." of ".$ban->name)

@section('main-container')
    <div class="col-xs-9">
        <div class="panel" style="padding: 50px">
            @if(Auth::check() && Auth::user()->isAdmin())
            <a class="btn btn-sm btn-info pull-right" href="{{ route('bans.edit',$ban->id) }}">Edit Ban</a>
            @endif
            <h2 style="margin-bottom: 20px"><img class="tooltipster" title="{{ $ban->countryName }}" src="{{ $ban->countryImage }}" alt="" height="22px"/> {{ $ban->name }}</h2>
            <hr>
            <table style="font-size: large" class="table table-striped table-hover table-bordered">
                <tbody><tr>
                    <td class="col-xs-4">Ban ID</td>
                    <td class="col-xs-8">
                        <b>{{ $ban->id }}</b>
                    </td>
                </tr>
                <tr>
                    <td>Name</td>
                    <td>
                        {!! $ban->bannedUserURL !!}
                    </td>
                </tr>
                <tr>
                    <td>IP Address</td>
                    <td>
                        {{ $ban->ipAddrWithMask }}
                    </td>
                </tr>
                <tr>
                    <td>Banned Till</td>
                    <td>
                        <span class="tooltipster" title="{{ $ban->bannedTillDateTime }}">{{ $ban->bannedTill }}</span>
                    </td>
                </tr>
                <tr>
                    <td>
                        Country
                    </td>
                    <td>
                        {{ $ban->countryName }}
                    </td>
                </tr>
                <tr>
                    <td>
                        Status
                    </td>
                    <td>
                        <b>{!! $ban->statusWithColor !!}</b>
                    </td>
                </tr>
                <tr>
                    <td>
                        Reason
                    </td>
                    <td>
                        {{ $ban->reason }}
                    </td>
                </tr>
                <tr>
                    <td>
                        Created
                    </td>
                    <td>
                        {{ $ban->created_at->diffForHumans() }} ( by {!! $ban->bannedByAdminURL !!} )
                    </td>
                </tr>
                @if($ban->updated_by != null)
                <tr>
                    <td>
                        Last Modified
                    </td>
                    <td>
                        {{ $ban->updated_at->diffForHumans() }} ( by {!! $ban->updatedByAdminURL !!} )
                    </td>
                </tr>
                @endif
                </tbody></table>
        </div>

        @if(Auth::check())
            <div class="media comment-media panel padding10">
                <div class="pull-left">
                    {!! Html::image(Auth::user()->getGravatarLink(40),'',array('class'=>'img media-oject inprofile-thumbs','width'=>'40','height'=>'40')) !!}
                </div>
                @if(Auth::user()->muted)
                    <form class="comment-create-form media-body">
                    <textarea name="" id="muted" cols="5" rows="2" class="form-control comment-textarea no-margin" placeholder="You are muted because of your behaviors" disabled></textarea>
                    </form>
                @else
                {!! Form::open(['route' => ['ban-comment',$ban->id], 'class'=>'comment-create-form media-body']) !!}
                {!! Form::textarea('body', null, ['placeholder' => 'Your comment here', 'class' => 'form-control comment-textarea no-margin', 'rows' => 2, 'cols' => 5]) !!}
                {!! Form::submit('Comment',['class' => 'btn btn-xs btn-default right comment-create-form-submit']) !!}
                {!! Form::close() !!}
                @endif
            </div>
        @endif

        <div class="comments-container">
            @foreach($ban->comments->reverse() as $comment)
                <div class="media comment-media panel padding10">
                    <div class="pull-left">
                        {!! Html::image($comment->user->getGravatarLink(50),'',array('class'=>'img media-oject inprofile-thumbs','width'=>'50','height'=>'50')) !!}
                    </div>
                    <div class="media-body" style="font-size: 14px;word-break: break-all;">
                        @if(Auth::check() && (Auth::user()->isAdmin() || Auth::user()->id == $comment->user_id))
                            <span class="pull-right">
                                    {!! Form::open(['method' => 'delete','route' => ['comment.destroy',$comment->id],'class' => 'pull-right']) !!}
                                <button type="submit" class="tooltipster confirm submit btn-link"
                                        title="Delete Comment"><i class="fa fa-times"></i></button>
                                {!! Form::close() !!}
                                </span>
                        @endif
                        <p class="no-margin convert-emoji">
                            <b>{!! link_to_route('user.show',$comment->user->displayName(),[$comment->user->username]) !!}</b>
                        </p>
                        <p class="no-margin text-muted small">{{ $comment->created_at->diffForHumans() }}</p>
                        <p>{!! $comment->showBody() !!}</p>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
@endsection