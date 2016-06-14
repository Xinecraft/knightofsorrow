@extends('layouts.main')
@section('main-container')
    <div class="content col-md-8">
        @include('partials._errors')

        <div class="col-md-12 panel" style="padding: 15px">
            <h3>{{ $news->title }}</h3>
            <p class=""><i>
                <small>{!! link_to_route('user.show', $news->user->displayName(), [$news->user->username]) !!}</small>
                 -
                <small class="text-muted">{{ $news->created_at->toDayDateTimeString() }}</small>
                </i>
            </p>
            <hr>
            <p class="convert-emoji">{!! BBCode::parseCaseInsensitive((htmlentities($news->text))) !!}</p>
        </div>

    </div>
@endsection