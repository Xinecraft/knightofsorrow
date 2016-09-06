@extends('layouts.main')
@section('main-container')
    <div class="content col-xs-7">
        @include('partials._errors')

        <div class="panel panel-default grid-item item">
            <div class="panel-heading media">
                <div class="pull-left">
                    {!! Html::image($status->user->getGravatarLink(40),'',array('class'=>'img media-oject inprofile-thumbs','width'=>'40','height'=>'40')) !!}
                </div>
                <div class="media-body row">
                    <div class="col-xs-9 no-padding">
                        <b>{!! link_to_route('user.show',$status->user->displayName(),[$status->user->username]) !!}</b>
                        <p class="small user-status-timeago no-margin">{!! link_to_route('show-status',$status->timeSincePublished,[$status->id],['class' => 'status-timeago']) !!}</p>
                    </div>
                    <div class="col-xs-3">
                        @if(Auth::check() and Auth::user()->id == $status->user->id)
                            {!! Form::open(['name'=>'deleteStatus','method'=>'DELETE','action'=>'StatusController@destroy','class'=>'form-inline pull-right deleteStatus']) !!}
                            {!! Html::link(action('StatusController@edit',['id' => $status->id]),'E',['class'=>'btn btn-warning btn-xs tooltipster', 'title' => 'Edit Status']) !!}
                            {!! Form::hidden('id',$status->id) !!}
                            {!! Form::submit('D',['class'=>'btn btn-danger btn-xs submit deleteStatus-submit tooltipster', 'title' => 'Delete Status']) !!}
                            {!! Form::close() !!}
                        @endif
                    </div>
                </div>

            </div>
            <div class="panel-body convert-emoji"> {!! $status->statusBody !!}</div>

            <div class="panel-footer">
                <div class="comment-sentence small text-muted">
                    <b>{{ $statusCommentCount = $status->comments->count() }} {{ str_plural("comment", $statusCommentCount) }}</b>
                </div>

                <div class="comments-container">
                    @foreach($status->comments as $comment)
                        <div class="media comment-media">
                            <div class="pull-left">
                                {!! Html::image($comment->user->getGravatarLink(30),'',array('class'=>'img media-oject inprofile-thumbs','width'=>'30','height'=>'30')) !!}
                            </div>
                            <div class="media-body small">
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
                                    {!! $comment->showBody() !!}
                                </p>
                                <p class="no-margin text-muted small">{{ $comment->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>

                @if(Auth::check())
                    <div class="media comment-media">
                        <div class="pull-left">
                            {!! Html::image(Auth::user()->getGravatarLink(40),'',array('class'=>'img media-oject inprofile-thumbs','width'=>'40','height'=>'40')) !!}
                        </div>

                        @if(Auth::user()->muted)
                            <form class="comment-create-form media-body">
                                <textarea name="" id="muted" cols="5" rows="1"
                                          class="form-control comment-textarea no-margin"
                                          placeholder="You are muted because of your behaviors" disabled></textarea>
                            </form>
                        @else
                            {!! Form::open(['route' => ['status-comment',$status->id], 'class'=>'comment-create-form media-body']) !!}
                            {!! Form::textarea('body', null, ['placeholder' => 'Your comment here', 'class' => 'form-control comment-textarea no-margin', 'rows' => 1, 'cols' => 5]) !!}
                            {!! Form::submit('Comment',['class' => 'btn btn-xs btn-default right comment-create-form-submit']) !!}
                            {!! Form::close() !!}
                        @endif
                    </div>
                @endif
            </div>
        </div>

    </div>

@endsection