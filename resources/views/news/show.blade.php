@extends('layouts.main')
@section('title',$news->title)
@section('main-container')
    <div class="content col-xs-8">

        <div class="col-xs-12 panel" style="padding: 15px">
            <h3>{{ $news->title }}</h3>
            <p class=""><i>
                <small>{!! link_to_route('user.show', $news->user->displayName(), [$news->user->username]) !!}</small>
                 -
                <small class="text-muted">{{ $news->created_at->toDayDateTimeString() }}
                &squarf; {{ $news->getHumanReadableNewsType() }}
                </small>
                </i>

                @if(Auth::check() && Auth::user()->isAdmin())
                    <br>
                    <small class="text-muted">Last updated: <i>{{ $news->updated_at->toDayDateTimeString() }}
                     -
                    <a href="{{ route('news.edit',$news->id) }}">Edit News</a></i></small>
                @endif

            </p>
            <hr>
            <p class="convert-emoji">{!! BBCode::parseCaseInsensitive((htmlentities($news->text))) !!}</p>
        </div>

    </div>
@endsection